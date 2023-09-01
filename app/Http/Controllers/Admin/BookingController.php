<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $search = $request->get('search');
      $bookings = Booking::where([
        [function ($query) use ($request) {
          if (($s = $request->search)) {
            $query->where('booking_confirmation', 'LIKE', '%' . $s . '%')
              ->get();
          }
        }]
      ])
      ->orWhereHas('guest', function ($query) use ($request) {
        if (($s = $request->search)) {
          $query->where('first_name', 'LIKE', '%' . $s . '%' )
            ->orWhere('last_name', 'LIKE', '%' . $s . '%')
            ->orWhere('email', 'LIKE', '%' . $s . '%');
        }
      })
      ->where('booking_status', 'CONFIRMED')
      ->orderBy('check_in', 'asc')
      ->paginate(config('pagination.default'))
      ->withQueryString();

      return Inertia::render('Admin/Bookings/BookingsList', [
        'bookings' => $bookings,
        'search' => $search
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $booking = Booking::find($id);
      return Inertia::render('Admin/Bookings/Show', [
        'booking' => $booking,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $booking = Booking::find($id);
      $booking->arrival_status = $request->arrival_status;
      $booking->save();

      session()->flash('flash.banner', 'Booking Updated Successfully!');
      session()->flash('flash.bannerStyle', 'success');

      return redirect()->route('bookings.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
