<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomStoreRequest;
use App\Models\Room;
use App\Models\Amenity;
use App\Models\RoomImage;
use App\Models\RoomUnavailability;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
      ])->where('is_available', true)
      ->orderBy('name', 'asc')
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
      $amenities = Amenity::all();
      return Inertia::render('Admin/Rooms/Create', [
        'amenities' => $amenities
      ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomStoreRequest $request)
    {
      try {
        $room = new Room; 

        if(isset($request->cover_image) && $request->cover_image) {
          $imageName = time().'.'.$request->cover_image->extension();
          $request->cover_image->move(public_path('images'), $imageName);
          $room->cover_image = $imageName;
        }
        
        $room->fill($request->validated());
        $room->save();

        $amenities = $request->amenities;
        if(isset($amenities) && count($amenities)) {
          $amenities = collect($amenities)->map(function ($amenity) {
            return $amenity['id'];
          });
          $room->amenities()->sync($amenities);
        }

        session()->flash('flash.banner', 'Room Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('rooms.show', $room->id);
      } catch(Throwable $e) {
        report($e);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $room = Room::where('id', $id)->with(['bookings', 'unavailableDates'])->first();
      $amenities = Amenity::all();
      return Inertia::render('Admin/Rooms/Show', [
        'room' => $room,
        'amenities' => $amenities,
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

        $amenities = $request->amenities;
        if(isset($amenities) && count($amenities)) {
          $amenities = collect($amenities)->map(function ($amenity) {
            return $amenity['id'];
          });
          $room->amenities()->sync($amenities);
        }
        $room->save();

        session()->flash('flash.banner', 'Room Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
      } catch(Throwable $e) {
        report($e);
      }
    }

    public function blockDate(Request $request, string $id) {
      try {
        $dates = $request->new_unavailable_dates;
        foreach($dates as $date) {
          $date = Carbon::parse($date)->format('Y-m-d');
          $newUnavailability = new RoomUnavailability();
          $newUnavailability->start_date = $date;
          $newUnavailability->notes = $request->notes;
          $newUnavailability->is_range = 0;
          $newUnavailability->is_confirmed = 1;
          $newUnavailability->room_id = $id;
          $newUnavailability->save();
        }

        session()->flash('flash.banner', 'Date Blocked Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return to_route('rooms.show', $id);

      } catch(Throwable $e) {

      }
    } 

    public function unblockDate(Request $request, string $id) {
      try {
        $unavailability = RoomUnavailability::destroy($id);

        session()->flash('flash.banner', 'Date Unblocked Successfully!');
        session()->flash('flash.bannerStyle', 'success');
      } catch(Throwable $e) {

      }
    }

    public function uploadImage(Request $request, string $id) {
      try {
        $images = $request->images;
        if(isset($images) && count($images)) {
          foreach($images as $image) {
            $imageName = uniqid().time().'.'.$image->extension();
            $image->move(public_path('images/rooms'), $imageName);
            $roomImage = RoomImage::create([
              'room_id' => $id,
              'image_url' => $imageName
            ]);
          }
        }
      } catch(Throwable $e) {

      }
    }

    public function deleteImage(string $imageId) {
      $roomImage = RoomImage::find($imageId);
      File::delete(public_path('/images/rooms/' . $roomImage->image_url));
      $roomImage->destroy($imageId);
    }

    public function setPrimaryImage(string $imageId) {
      $roomImage = RoomImage::find($imageId);

      // Set all room images to not primary before updating primary
      RoomImage::where('room_id', $roomImage->room_id)->update(['is_primary' => 0]);
      $roomImage->is_primary = 1;
      $roomImage->save();

      $room = Room::find($roomImage->room_id);
      $room->cover_image = $roomImage->image_url;
      $room->save();

      return to_route('rooms.show', $roomImage->room_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
