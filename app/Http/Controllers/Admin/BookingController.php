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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
            // Check for bookings that could overlap with existing ones
            $start = Carbon::parse($request->check_in)->format('Y-m-d');
            $end = Carbon::parse($request->check_out)->format('Y-m-d');
            $isRoomAvailable = Room::where('id', $request->room_id)
                ->where('is_available', true)
                ->orderBy('rate', 'asc')
                ->whereDoesntHave('unavailableDates', function (Builder $query) use ($start, $end) {
                $query->where('is_confirmed', true);

                // Handles range overlap and allows customers to check in on the same day others check out
                $query->where('start_date', '<', $end)
                    ->where('end_date', '>', $start);

                // Handles unavailable blocked dates. Room is unavailable for the whole date.
                $query->orWhereBetween('start_date', [$start, $end])
                    ->whereNull('end_date');
            })->first();


            if($isRoomAvailable) {
                // Check if guest exists already. If not, create one.
                $guest = Guest::where('email', $request->email)->first();
                if(!$guest) {
                    $guest = new Guest;
                    $guest->fill($request->validated());
                    $guest->save();
                }

                // Create the booking
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
            } else {
                session()->flash('flash.banner', 'This booking overlaps with another booking for this room!');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->back();
            }
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
