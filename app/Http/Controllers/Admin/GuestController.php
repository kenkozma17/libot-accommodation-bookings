<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\GuestStoreRequest;
use App\Models\Guest;
use App\Models\Booking;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $search = $request->get('search');
      $guests = Guest::where([
        [function ($query) use ($request) {
          if (($s = $request->search)) {
            $query->orWhere('first_name', 'LIKE', '%' . $s . '%')
              ->orWhere('last_name', 'LIKE', '%' . $s . '%')
              ->orWhere('email', 'LIKE', '%' . $s . '%')
              ->orWhere('phone', 'LIKE', '%' . $s . '%')
              ->get();
          }
        }]
      ])->paginate(config('pagination.default'))->withQueryString();;
      return Inertia::render('Admin/Guests/GuestsList', [
        'guests' => $guests,
        'search' => $search
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return Inertia::render('Admin/Guests/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuestStoreRequest $request)
    {
        try {
          $guest = new Guest; 
          $guest->fill($request->validated());
          $guest->save();

          session()->flash('flash.banner', 'Guest Created Successfully!');
          session()->flash('flash.bannerStyle', 'success');
  
          return redirect()->route('guests.index');
        } catch(Throwable $e) {
          report($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $guest = Guest::where('id', $id)->with(['bookings', 'payments'])->first();
      return Inertia::render('Admin/Guests/Show', [
        'guest' => $guest,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuestStoreRequest $request, string $id)
    {
      try {
        $guest = Guest::find($id);
        $guest->update($request->validated());
        $guest->save();

        session()->flash('flash.banner', 'Guest Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
      } catch(Throwable $e) {
        report($e);
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
