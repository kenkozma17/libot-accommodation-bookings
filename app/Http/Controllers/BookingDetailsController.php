<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class BookingDetailsController extends Controller
{
    public function index(Request $request) {
      $room = $request->all();

      return Inertia::render('Booking/BookingDetails');
    }

    public function store(Request $request) {

      $validator = Validator::make($request->all(), [
        'contactDetails.firstName' => 'required',
        'contactDetails.lastName' => 'required',
        'contactDetails.email' => 'required',
        'contactDetails.phone' => 'required|min:12',
        'contactDetails.terms' => 'accepted',
      ], $this->validationMessages());

      if ($validator->fails()) {
        return redirect('/booking-details')
          ->withErrors($validator)
          ->withInput();
      }
  
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
