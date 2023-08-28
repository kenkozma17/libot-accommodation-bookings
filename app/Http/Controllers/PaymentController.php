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

class PaymentController extends Controller
{
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
    Log::info($response);
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
      'paymongo_payment_id' => $payMongoPayment['id'],
      'receipt_number' => $payMongoPayment['id'],
      'payment_source' => $paymentMethod,
      'currency_code' => 'PHP',
      'payment_status' => 'PAID'
    ]);
    
    // Set booking status to confirmed
    $booking = Booking::where('booking_confirmation', $bookingConfirmation)->first();
    $booking->booking_status = 'CONFIRMED';
    $booking->payment_id = $payment->id;
    $booking->save();

    // Set unavailability to confirmed
    $unavailability = RoomUnavailability::where('booking_id', $booking->id)->first();
    $unavailability->is_confirmed = true;
    $unavailability->save();
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

    return $newBooking;
  }

  public function createRoomUnavailablility($newBooking) {
    $newUnavailability = RoomUnavailability::create([
      'room_id' => $newBooking->room_id,
      'booking_id' => $newBooking->id,
      'start_date' => $newBooking->check_in,
      'end_date' => $newBooking->check_out,
      'notes' => null,
      'is_range' => true,
      'is_confirmed' => false
    ]);

    return $newUnavailability;
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
            'phone' => $guest['contactDetails']['phone']
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
          'description' => $data['reservation']['stayCount'] . ' night(s) stay in ' . $room->name,
        ]
      ]
    ]);

    return $paymentData;
  }
}
