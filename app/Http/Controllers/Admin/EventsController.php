<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventSet;
use App\Models\Guest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $search = $request->get('search');
      $events = Event::where([
        [function ($query) use ($request) {
          if (($s = $request->search)) {
            $query->orWhere('name', 'LIKE', '%' . $s . '%')
              ->get();
          }
        }]
      ])
      ->orderBy('start_date', 'desc')
      ->paginate(config('pagination.default'))
      ->withQueryString();;
      return Inertia::render('Admin/Events/EventsList', [
        'events' => $events,
        'search' => $search
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Events/Create', [
          'guests' => Guest::orderBy('last_name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
      $event = new Event();
      $event->fill($request->validated());
      $event->save();

      session()->flash('flash.banner', 'Event Created Successfully!');
      session()->flash('flash.bannerStyle', 'success');

      return redirect()->route('events.index');
    }

    public function addEventSet($eventId, Request $request) {
      $event = Event::find($eventId);
      $setId = $request->set_id;
      if(isset($setId) && $setId) {
        $eventSet = EventSet::find($setId);
        if($eventSet) {
          $event->sets()->syncWithoutDetaching([$eventSet->id]);
        }
      }
    }

    public function removeEventSet($eventId, Request $request) {
      $event = Event::find($eventId);
      $setId = $request->set_id;
      if(isset($setId) && $setId) {
        $eventSet = EventSet::find($setId);
        if($eventSet) {
          $event->sets()->detach($eventSet->id);
        }
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $event = Event::where('id', $id)->with(['guest', 'sets' => function($query){
        return $query->with('services');
      }])->first();
      return Inertia::render('Admin/Events/Show', [
        'event' => $event,
        'sets' => EventSet::orderBy('name', 'asc')->get()
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
    public function update(EventStoreRequest $request, string $id)
    {
      $item = Event::find($id);
      $item->update($request->validated());
      $item->save();

      session()->flash('flash.banner', 'Event Updated Successfully!');
      session()->flash('flash.bannerStyle', 'success');

      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
