<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
      $rooms = Room::where('is_available', true)->get();
      $bookings = Booking::where('check_in', '>', Carbon::now())->get();
      return Inertia::render('Dashboard', [
        'availableRooms' => count($rooms),
        'upcomingBookings' => count($bookings)
      ]);
    }
}
