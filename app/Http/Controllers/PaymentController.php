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

class PaymentController extends Controller
{
  public function index(Request $request) {
    $data = $request->all();

    return Inertia::render('Booking/Payment');
  }

  public function createPayMongoSession(Request $request) {
    $data = $request->all();
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
    $newGuest = Guest::create([
      'email' => 'paymongo1@test.com',
      'first_name' => 'ken',
      'last_name' => 'kozma',
      'nationality' => $request->all(),
      'phone' => 'tester',
      'address' => $request->all()
    ]);
  }

  // # 1
  public function createGuest($guest) {
    $newGuest = Guest::create([
      'email' => $guest['email'],
      'first_name' => $guest['firstName'],
      'last_name' => $guest['lastName'],
      'nationality' => $guest['nationality'],
      'phone' => $guest['phone'],
    ]);
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

  // # 3
  public function createBooking($booking) {
    $newBooking = Booking::create([
      'booking_confirmation' => $booking,
      'check_in' => $booking,
      'check_out' => $booking,
      'rate_per_night' => $booking,
      'total_price' => $booking,
      'booking_status' => $booking,
      'special_requests' => $booking,
      'adults_count' => $booking,
      'children_count' => $booking,
      'guest_id' => $booking,
      'room_id' => $booking,
      'payment_id' => $booking
    ]);
  }

  // # 4
  public function createUnavailableDates($booking) {
    $newUnavailability = DateUnavailability::create([
      'room_id' => $booking,
      'booking_id' => $booking,
      'start_date' => $booking,
      'end_date' => $booking,
      'notes' => $booking,
      'is_range' => $booking,
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
