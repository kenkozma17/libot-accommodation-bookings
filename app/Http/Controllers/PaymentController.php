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

class PaymentController extends Controller
{
  public function index(Request $request) {
    $data = $request->all();
    return Inertia::render('Booking/Payment');
  }

  public function createPayMongoSession(Request $request) {
    $data = $request->all();

    $booking = $data['reservation'];
    $this->createBooking($booking);

    $paymentData = $this->getPaymentPayload($data);

    $response = Http::accept('application/json')
      ->withBasicAuth(env('PAYMONGO_SECRET_KEY'), env('PAYMONGO_SECRET_KEY'))
      ->withBody($paymentData)
      ->withHeaders([
        'Content-Type' => 'application/json'
      ])->post('https://api.paymongo.com/v1/checkout_sessions');

    if($response->successful()) {
      $responseBody = $response->json();
      $checkoutUrl = $response['data']['attributes']['checkout_url'];

      return Inertia::location($checkoutUrl);
    }
  }

  public function handlePaymentSuccess(Request $request) {
    $payload = $request->all();
    // $this->createPayment();
  }

  public function createBooking($booking) {
    $newBooking = Booking::create([
      'booking_confirmation' => Str::random(15),
      'check_in' => $booking['dates']['start'],
      'check_out' => $booking['dates']['end'],
      'rate_per_night' => $booking['room']['rate'],
      'total_price' => $booking['room']['rate'] * $booking['stayCount'],
      'booking_status' => 'PENDING',
      'special_requests' => $booking['guests']['contactDetails']['requests'],
      'adults_count' => $booking['guests']['adults'],
      'children_count' => $booking['guests']['children'],
      'guest_id' => Guest::where('email', $booking['guests']['contactDetails']['email'])->first()->id,
      'room_id' => $booking['room']['id'],
      'payment_id' => null
    ]);
    
    // $newUnavailability = RoomUnavailability::create([
    //   'room_id' => $newBooking->room_id,
    //   'booking_id' => $newBooking->id,
    //   'start_date' => $newBooking->check_in,
    //   'end_date' => $newBooking->check_out,
    //   'notes' => null,
    //   'is_range' => true,
    //   'is_confirmed' => false
    // ]);

  }

  // # 2
  public function createPayment($payment) {
    $newPayment = Payment::create([
      'payment_amount' => 3000,
      'payment_status' => 'PAID',
      'payment_date' => Carbon::now(),
      'payment_method' => 'gcash',
      'transaction_id' => '123',
      'payer_name' => 'ken kozma',
      'payer_email' => 'ken@gmail.com',
      'payment_gateway' => 'paymongo',
      'receipt_number' => '123',
      // 'payment_reference' => $payment,
      // 'currency_code' => $payment,
      // 'payment_source' => $payment,
      'booking_id' => $payment,
      'guest_id' => $payment,
    ]);
  }

  public function getPaymentPayload($data) {
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
