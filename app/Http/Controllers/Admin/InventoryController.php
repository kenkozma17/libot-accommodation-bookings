<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryStoreRequest;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \Illuminate\Support\Str;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $items = InventoryItem::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('name', 'LIKE', '%' . $s . '%')
                  ->get();
              }
            }]
          ])
          ->with('category')
          ->orderBy('name', 'asc')
          ->paginate(config('pagination.default'))
          ->withQueryString();

        return Inertia::render('Admin/Inventory/InventoryList', [
            'items' => $items,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Inventory/Create', [
            'categories' => InventoryCategory::orderBy('name', 'asc')->get(),
            'units' => InventoryItem::first()->units,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryStoreRequest $request)
    {
        $item = new InventoryItem();
        $item->fill($request->validated());
        $item->save();

        session()->flash('flash.banner', 'Inventory Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = InventoryItem::with('category')->where('id', $id)->first();
        $categories = InventoryCategory::orderBy('name', 'asc')->get();
        return Inertia::render('Admin/Inventory/Show', [
            'item' => $item,
            'categories' => $categories,
            'units' => $item->units,
            'movements' => InventoryMovement::where('inventory_item_id', $item->id)
              ->orderBy('created_at', 'desc')
              ->paginate(config('pagination.default'))
              ->withQueryString(),
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
    public function update(InventoryStoreRequest $request, string $id)
    {
        $item = InventoryItem::find($id);
        $item->fill($request->validated());
        $item->save();

        session()->flash('flash.banner', 'Inventory Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      InventoryItem::destroy($id);

      session()->flash('flash.banner', 'Inventory Deleted Successfully!');
      session()->flash('flash.bannerStyle', 'success');

      return redirect()->route('inventory.index');
    }
}
