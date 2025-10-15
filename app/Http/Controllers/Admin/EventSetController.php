<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventSetRequest;
use App\Models\EventSet;
use App\Models\Service;
use App\Models\ServiceCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sets = EventSet::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('name', 'LIKE', '%' . $s . '%')
                  ->get();
              }
            }]
          ])
          ->orderBy('name', 'asc')
          ->paginate(config('pagination.default'))
          ->withQueryString();

        return Inertia::render('Admin/EventSets/EventSetsList', [
            'sets' => $sets,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/EventSets/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventSetRequest $request)
    {
        $item = new EventSet();
        $item->fill($request->validated());
        $item->save();

        session()->flash('flash.banner', 'Event Set Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('event-sets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $set = EventSet::where('id', $id)->with('services')->first();
      $serviceCategories = ServiceCategory::with(['services' => function($query) {
        return $query->orderBy('name', 'asc');
      }])->orderBy('name', 'asc')->get();
      return Inertia::render('Admin/EventSets/Show', [
          'set' => $set,
          'serviceCategories' => $serviceCategories
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
    public function update(StoreEventSetRequest $request, string $id)
    {
        $item = EventSet::find($id);
        $item->update($request->validated());
        $item->save();

        session()->flash('flash.banner', 'Event Set Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
    }

    /**
     * Attach a service to an event set
     */
    public function addService(string $eventSetId, Request $request) {
      $set = EventSet::find($eventSetId);
      $serviceId = $request->service_id;
      if(isset($request->service_id)) {
        $service = Service::find($serviceId);

        if($service) {
          $set->services()->syncWithoutDetaching([$service->id]);
        }
      }
    }

    /**
     * Remove a service from an event set
     */
    public function removeService(string $eventSetId, Request $request) {
      $set = EventSet::find($eventSetId);
      $serviceId = $request->service_id;
      if(isset($request->service_id)) {
        $service = Service::find($serviceId);

        if($service) {
          $set->services()->detach($service);
        }
      }
    }

    /**
     * Generate purchase order printable
     */
    public function generatePurchaseOrderFile(Request $request) {
      $filteredServices = json_decode($request->services);
      $eventPax = $request->pax;

      $items = array_merge(...array_map(function ($service) {
        return $service->inventory_items;
      }, $filteredServices));

      $groupedItems = collect($items)
        ->groupBy('id')
        ->map(function($item) use ($eventPax) {
          $base = $item->first();
          $base->refill_quantity = $item->sum('pivot.quantity') * $eventPax;
          $base->est_refill_cost_formatted = 'P' . number_format($base->refill_quantity * $base->est_cost, 2);
          $base->est_refill_cost = $base->refill_quantity * $base->est_cost;
          return $base;
        })
        ->values();

      if($filteredServices) {
        $file = Pdf::loadView('pdf.purchase-order', ['items' => $groupedItems, 'eventPax' => $eventPax]);
        return response($file->output(), 200)->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="purchase-order.pdf"');
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      EventSet::destroy($id);

      session()->flash('flash.banner', 'Event Set Successfully!');
      session()->flash('flash.bannerStyle', 'success');

      return redirect()->route('event-sets.index');
    }
}
