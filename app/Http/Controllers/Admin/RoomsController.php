<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomStoreRequest;
use App\Models\Room;
use Inertia\Inertia;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $search = $request->get('search');
      $rooms = Room::where([
        [function ($query) use ($request) {
          if (($s = $request->search)) {
            $query->orWhere('name', 'LIKE', '%' . $s . '%')
              ->get();
          }
        }]
      ])->orderBy('name', 'asc')
      ->paginate(config('pagination.default'))
      ->withQueryString();;
      return Inertia::render('Admin/Rooms/RoomsList', [
        'rooms' => $rooms,
        'search' => $search
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return Inertia::render('Admin/Rooms/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
      try {
        $room = new Room; 

        $imageName = time().'.'.$request->cover_image->extension();
        $request->cover_image->move(public_path('images'), $imageName);
        
        $room->fill($request->validated());
        $room->cover_image = $imageName;
        $room->save();

        session()->flash('flash.banner', 'Room Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('rooms.index');
      } catch(Throwable $e) {
        report($e);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $room = Room::where('id', $id)->with(['bookings'])->first();
      return Inertia::render('Admin/Rooms/Show', [
        'room' => $room,
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
    public function update(RoomStoreRequest $request, string $id)
    {
      try {
        $room = Room::find($id);
        $room->update($request->validated());
        $room->save();

        session()->flash('flash.banner', 'Room Updated Successfully!');
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
