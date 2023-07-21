<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

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
      $validated = $request->validate([
        'contactDetails.firstName' => 'required',
        'contactDetails.lastName' => 'required',
        'contactDetails.email' => 'required',
        'contactDetails.phone' => 'required|min:12',
        'contactDetails.terms' => 'accepted',
        ],
        $this->validationMessages()
      );
  
      return redirect('/payment');
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
