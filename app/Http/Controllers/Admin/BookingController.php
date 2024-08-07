<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookingStoreRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Services\BookingService;

class BookingController extends Controller
{

    protected $bookingService;
    public function __construct(BookingService $bookingService) {
        $this->bookingService = $bookingService;
    }

    public function createRoomUnavailablility($newBooking) {
        $isConfirmed = true;
        $this->bookingService->createRoomUnavailablility($newBooking, $isConfirmed);
    }

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
        return Inertia::render('Admin/Bookings/Create', [
            'rooms' => Room::where('is_available', true)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingStoreRequest $request)
    {
        try {
            // Check if guest exists already. If not, create one.
            $guest = Guest::where('email', $request->email)->first();
            if(!$guest) {
                $guest = new Guest;
                $guest->fill($request->validated());
                $guest->save();
            }

            // Check for bookings that could overlap with existing ones
            $booking = new Booking;
            $booking->fill($request->validated());
            $booking->guest_id = $guest->id;
            $booking->is_manual = true;
            if(!$booking->booking_confirmation) {
                $booking->booking_confirmation = Str::random(7);
            }
            $booking->save();

            $this->createRoomUnavailablility($booking);

            session()->flash('flash.banner', 'Booking Created Successfully!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('bookings.index');
          } catch(Throwable $e) {
            report($e);
          }
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
