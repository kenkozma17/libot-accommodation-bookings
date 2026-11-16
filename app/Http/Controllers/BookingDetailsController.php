<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Guest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class BookingDetailsController extends Controller
{
    public function index(Request $request) {
      $room = $request->all();

      if(isset($room['id']) && $room['id']) {
        return Inertia::render('Booking/BookingDetails');
      }
      return redirect()->back();
    }

    public function store(Request $request) {
        $data = $request->all();
        $guest = $data['contactDetails'];
        $validator = Validator::make(
        $request->all(),
            [
                'contactDetails.firstName' => 'required',
                'contactDetails.lastName' => 'required',
                'contactDetails.email' => 'required|email',
                'contactDetails.phone' => 'required|min:12',
                'contactDetails.terms' => 'accepted',
            ],
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return redirect('/booking-details?id=' . $request->input('room.id'))
                ->withErrors($validator)
                ->withInput();
        }

        $guest = $request->input('contactDetails');

        $this->createGuest($guest);

        return redirect('/payment');

    }

    public function createGuest($guest) {
      try {
        $existingGuest = Guest::where('email', $guest['email'])->first();
        $guestArray = [
          'email' => $guest['email'],
          'first_name' => $guest['firstName'],
          'last_name' => $guest['lastName'],
          'nationality' => $guest['nationality'],
          'phone' => $guest['phone'],
        ];

        if($existingGuest) {
          $existingGuest->update($guestArray);
        } else {
          $newGuest = Guest::create($guestArray);
        }
      } catch(Throwable $e) {
        report($e);
      }
    }

    public function validationMessages(): array
    {
        return [
          'contactDetails.firstName.required' => 'The first name is required.',
          'contactDetails.lastName.required' => 'The last name is required.',
          'contactDetails.email.required' => 'The email is required.',
          'contactDetails.phone.min' => 'The phone number must be at least 12 digits.',
          'contactDetails.terms' => 'You must agree to the terms and conditions.',
        ];
    }
}
