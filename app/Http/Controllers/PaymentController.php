<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\RoomUnavailability;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Mail\BookingConfirmationMail;
use Carbon\Exceptions\Exception;
use App\Services\BotLogger;
use App\Services\BookingService;

class PaymentController extends Controller
{

  protected $bookingService;

  public function __construct(BookingService $bookingService) {
    $this->bookingService = $bookingService;
  }

  public function createRoomUnavailablility($newBooking) {
    $this->bookingService->createRoomUnavailablility($newBooking);
  }

  public function index(Request $request) {
    $data = $request->all();
    return Inertia::render('Booking/Payment');
  }

  public function createPayMongoCheckoutSession(Request $request) {
    $data = $request->all();

    // Create pending booking, room unavailability and payment
    $booking = $data['reservation'];
    $newBooking = $this->processBooking($booking);

    // Build payload to generate paymongo
    $paymentData = $this->getPaymentPayload($data, $newBooking);
    $response = $this->executeCheckoutSession($paymentData);

    // Redirect to PayMongo Checkout
    if($response->successful()) {
      $responseBody = $response->json();
      $checkoutUrl = $response['data']['attributes']['checkout_url'];

      return Inertia::location($checkoutUrl);
    }
  }

  public function handlePayMongoPaymentSuccess(Request $request) {
    $response = $request->all();
    if($response['data']['attributes']['type'] === 'checkout_session.payment.paid') {
      $payMongoPayment = $response['data']['attributes']['data'];
      $bookingConfirmation = $payMongoPayment['attributes']['metadata']['booking_confirmation'];
      $booking = Booking::where('booking_confirmation', $bookingConfirmation)->first();

      $paymentMethod = isset($payMongoPayment['attributes']['source']) ?
        $payMongoPayment['attributes']['source']['type'] :
        $payMongoPayment['attributes']['payment_method_used'];

      // Set Payment to confirmed and add data
      $payment = Payment::where('booking_id', $booking->id)->first();
      $payment->update([
        'payment_method' => $paymentMethod,
        'paymongo_payment_id' => $payMongoPayment['attributes']['payments'][0]['id'],
        'receipt_number' => $payMongoPayment['attributes']['payments'][0]['id'],
        'payment_source' => $paymentMethod,
        'currency_code' => $payMongoPayment['attributes']['payments'][0]['attributes']['currency'],
        'payment_status' => 'PAID'
      ]);

      // Set booking status to confirmed
      $booking = Booking::where('booking_confirmation', $bookingConfirmation)
        ->with(['guest', 'payment'])
        ->first();
      $booking->booking_status = 'CONFIRMED';
      $booking->payment_id = $payment->id;
      $booking->save();

      // Set unavailability to confirmed
      $unavailability = RoomUnavailability::where('booking_id', $booking->id)->first();
      $unavailability->is_confirmed = true;
      $unavailability->save();

      // Generate Booking Confirmation
      $this->generateConfirmationPdf($booking->id);

      // Send confirmation email
      $this->sendConfirmationEmail($booking);

      (new BotLogger())->logMessage(env("APP_ENV") . " Environment - " . env("APP_NAME") . " ✅ A guest has completed payment for their booking (". $booking->booking_confirmation .")");

    }
  }

  public function executeCheckoutSession($paymentData) {
    $response = Http::accept('application/json')
      ->withBasicAuth(env('PAYMONGO_SECRET_KEY'), env('PAYMONGO_SECRET_KEY'))
      ->withBody($paymentData)
      ->withHeaders([
        'Content-Type' => 'application/json'
      ])->post('https://api.paymongo.com/v1/checkout_sessions');

    return $response;
  }

  public function processBooking($booking) {
    $newBooking = $this->createBooking($booking);
    $unavailability = $this->createRoomUnavailablility($newBooking);
    $payment = $this->createPayment($booking, $newBooking->id, $newBooking->guest_id);

    return $newBooking;
  }

  public function createBooking($booking) {
    $guest = Guest::where('email', $booking['guests']['contactDetails']['email'])->first();
    $newBooking = Booking::create([
        'booking_confirmation' => Str::random(7),
        'check_in' => $booking['dates']['start'],
        'check_out' => $booking['dates']['end'],
        'rate_per_night' => $booking['room']['rate'],
        'total_price' => $booking['room']['rate'] * $booking['stayCount'],
        'booking_status' => 'PENDING',
        'special_requests' => $booking['guests']['contactDetails']['requests'],
        'adults_count' => $booking['guests']['adults'],
        'children_count' => $booking['guests']['children'],
        'guest_id' => $guest->id,
        'room_id' => $booking['room']['id'],
        'payment_id' => null
    ]);

    (new BotLogger())->logMessage(env("APP_ENV") . " Environment - " . env("APP_NAME") . " ⏳ A guest (" . $guest->full_name . ") created a booking (" . $newBooking->booking_confirmation .") but hasn't paid yet.");

    return $newBooking;
  }

  public function createPayment($booking, $bookingId, $guestId) {
    $room = Room::find($booking['room']['id']);
    $guest = $booking['guests'];
    $newPayment = Payment::create([
      'payment_amount' => $room->rate * $booking['stayCount'],
      'payment_status' => 'PENDING',
      'payment_date' => Carbon::now(),
      'payment_method' => null,
      'paymongo_payment_id' => null,
      'payer_name' => $guest['contactDetails']['firstName'] . ' ' . $guest['contactDetails']['lastName'],
      'payer_email' => $guest['contactDetails']['email'],
      'payment_gateway' => 'PAYMONGO',
      'receipt_number' => null,
      'payment_reference' => null,
      'currency_code' => null,
      'payment_source' => null,
      'booking_id' => $bookingId,
      'guest_id' => $guestId,
    ]);

    return $newPayment;
  }

  public function sendConfirmationEmail(Booking $booking) {
    \Mail::to($booking->guest->email)
      ->cc(env("FRONT_DESK_EMAIL"))
      ->send(new BookingConfirmationMail($booking));
  }

  public function generateConfirmationPdf($bookingId) {
    $booking = Booking::where("id", $bookingId)->with(['guest', 'payment'])
      ->first();
    $file = Pdf::loadView('confirmation', ['booking' => $booking, 'property' => env("APP_NAME")]);
    Storage::put('public/confirmations/' . $booking->booking_confirmation . '.pdf', $file->output());
  }

  public function getPaymentPayload($data, $newBooking) {
    $guest = $data['reservation']['guests'];

    $room = Room::find($data['reservation']['room']['id']);
    $totalPriceInCents = (int) bcmul($room->rate * $data['reservation']['stayCount'], 100);
    $paymentData = json_encode([
      'data' => [
        'attributes' => [
          'cancel_url' => config('app.url'),
          'success_url' => config('app.url'),
          'billing' => [
            'name' => $guest['contactDetails']['firstName'] . ' ' . $guest['contactDetails']['lastName'],
            'email' => $guest['contactDetails']['email'],
          ],
          'send_email_receipt' => true,
          'show_line_items' => true,
          'external_reference_number' => $newBooking->booking_confirmation,
          'metadata' => [
            'booking_confirmation' => $newBooking->booking_confirmation
          ],
          'line_items' => [[
            'currency' => 'PHP',
            'amount' => $totalPriceInCents,
            'name' => $room->name,
            'quantity' => 1
          ]],
          'payment_method_types' => ['card', 'paymaya', 'gcash'],
          'description' => $data['reservation']['stayCount'] . ' night(s) stay in ' . $room->name . ' at ' . env('APP_NAME'),
        ]
      ]
    ]);

    return $paymentData;
  }
}
