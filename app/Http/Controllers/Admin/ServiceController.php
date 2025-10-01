<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Service;
use App\Http\Requests\ServiceStoreRequest;
use App\Models\InventoryItem;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $services = Service::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('name', 'LIKE', '%' . $s . '%')
                  ->get();
              }
            }]
          ])
          ->with('category')
          ->orderBy('created_at', 'asc')
          ->paginate(config('pagination.default'))
          ->withQueryString();
        return Inertia::render('Admin/Services/ServicesList', [
            'services' => $services,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Services/Create', [
            'serviceCategories' => ServiceCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        $service = new Service();
        $service->fill($request->validated());
        $service->slug = Str::slug($request->name);
        $service->save();

        session()->flash('flash.banner', 'Service Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::with(['category', 'inventory_items' => function($query) {
          return $query->orderBy('name', 'asc');
        }])->where('id', $id)->first();
        $serviceCategories = ServiceCategory::orderBy('name', 'asc')->get();
        $items = InventoryItem::with('category')->orderBy('name', 'desc')->get();
        return Inertia::render('Admin/Services/Show', [
            'service' => $service,
            'serviceCategories' => $serviceCategories,
            'items' => $items,
        ]);
    }

    /**
     * Attach an inventory item to a service
     */
    public function addInventoryItem(string $serviceId, Request $request) {
      $service = Service::find($serviceId);
      $inventoryItemId = $request->inventory_item_id;
      if(isset($request->inventory_item_id)) {
        $inventoryItem = InventoryItem::find($inventoryItemId);

        if($inventoryItem) {
          $service->inventory_items()->attach($inventoryItem, [
            'quantity' => $request->quantity,
            'unit' => $inventoryItem->unit,
          ]);
        }
      }
    }

    /**
     * Remove an inventory item from a service
     */
    public function removeInventoryItem(string $serviceId, Request $request) {
      $service = Service::find($serviceId);
      $inventoryItemId = $request->inventory_item_id;
      if(isset($request->inventory_item_id)) {
        $inventoryItem = InventoryItem::find($inventoryItemId);

        if($inventoryItem) {
          $service->inventory_items()->detach($inventoryItem);
        }
      }
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
    public function update(ServiceStoreRequest $request, string $id)
    {
        $service = Service::find($id);
        $service->fill($request->validated());
        $service->slug = Str::slug($request->name);
        $service->save();

        session()->flash('flash.banner', 'Service Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Service::destroy($id);

        session()->flash('flash.banner', 'Service Deleted Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('services.index');
    }
}
