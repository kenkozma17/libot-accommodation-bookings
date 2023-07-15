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
}
