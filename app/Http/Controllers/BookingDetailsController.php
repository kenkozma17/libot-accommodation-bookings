<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Guest;

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
      $validated = $request->validate([
        'contactDetails.firstName' => 'required',
        'contactDetails.lastName' => 'required',
        'contactDetails.email' => 'required',
        'contactDetails.phone' => 'required|min:12',
        'contactDetails.terms' => 'accepted',
        ],
        $this->validationMessages()
      );

      $this->createGuest($guest);
  
      return redirect('/payment');
    }

    public function createGuest($guest) {
      $existingGuest = Guest::where('email', $guest['email'])->first();

      if($existingGuest) {
        $existingGuest->update([
          'email' => $guest['email'],
          'first_name' => $guest['firstName'],
          'last_name' => $guest['lastName'],
          'nationality' => $guest['nationality'],
          'phone' => $guest['phone'],
        ]);
      } else {
        $newGuest = Guest::create([
          'email' => $guest['email'],
          'first_name' => $guest['firstName'],
          'last_name' => $guest['lastName'],
          'nationality' => $guest['nationality'],
          'phone' => $guest['phone'],
        ]);
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
