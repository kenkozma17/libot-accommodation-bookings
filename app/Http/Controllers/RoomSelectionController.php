<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class RoomSelectionController extends Controller
{
    
  public function index(Request $request) {
    $bookingDetails = $request->all();
    if(isset($bookingDetails['dates']['start']) && isset($bookingDetails['dates']['end'])) {
      $dates = $bookingDetails['dates'];
      $start = Carbon::parse($dates['start'])->format('Y-m-d');
      $end = Carbon::parse($dates['end'])->format('Y-m-d');
      $guests = $bookingDetails['guests'];
      $guestCount = (int) $guests['adults'] + (int) $guests['children'];

      $rooms = Room::where('max_occupancy', '>=', $guestCount)
        ->where('is_available', true)
        ->orderBy('rate', 'desc')
        ->whereDoesntHave('unavailableDates', function (Builder $query) use ($start, $end) {
          $query->where('is_confirmed', true);

          // Handles range overlap and allows customers to check in on the same day others check out
          $query->where('start_date', '<', $end)
            ->where('end_date', '>', $start);

          // Handles unavailable blocked dates. Room is unavailable for the whole date.
          $query->orWhereBetween('start_date', [$start, $end])
            ->whereNull('end_date');
          
      })->paginate(config('pagination.max'))->withQueryString();


      return Inertia::render('Booking/RoomSelection', [
        'availableRooms' => $rooms
      ]);
    }

    return redirect()->back();
  }
}
