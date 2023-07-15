<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomSelectionController extends Controller
{
    
  public function index(Request $request) {
    $bookingDetails = $request->all();

    if(isset($bookingDetails['dates']['start']) && isset($bookingDetails['dates']['end'])) {
      return Inertia::render('Booking/RoomSelection');
    }

    return redirect()->back();
  }
}
