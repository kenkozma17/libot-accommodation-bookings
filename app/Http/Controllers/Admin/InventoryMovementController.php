<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryMovementRequest;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InventoryMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $movements = InventoryMovement::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('id', 'LIKE', '%' . $s . '%')
                  ->get();
              }
            }]
          ])->orWhereHas('item', function ($query) use ($request) {
            if (($s = $request->search)) {
              $query->where('name', 'LIKE', '%' . $s . '%' );
            }
          })
          ->with('item')
          ->orderBy('created_at', 'desc')
          ->paginate(config('pagination.default'))
          ->withQueryString();

        return Inertia::render('Admin/InventoryMovements/InventoryMovementsList', [
            'movements' => $movements,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/InventoryMovements/Create', [
          'items' => InventoryItem::with('category')->orderBy('name', 'asc')->get(),
          'units' => InventoryItem::first()->units,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryMovementRequest $request)
    {
      $this->adjustInventoryStock($request);

      session()->flash('flash.banner', 'Inventory Transaction Created Successfully!');
      session()->flash('flash.bannerStyle', value: 'success');

      return inertia()->location(route('inventory.show', $request->inventory_item_id));
    }

    /**
     * Adjust stock levels
     */
    public function adjustInventoryStock(StoreInventoryMovementRequest $request) {
      if(isset($request->type) && $request->type) {
        $movement = new InventoryMovement();
        $item = InventoryItem::find($request->inventory_item_id);

        if($item) {
          $movement->previous_stock = $item->stock;

          if(Str::lower($request->type) === 'increase') {
            $movement->current_stock = $item->stock += $request->quantity;
          } elseif(Str::lower($request->type) === 'decrease') {
            $movement->current_stock = $item->stock -= $request->quantity;
          } elseif(Str::lower($request->type) === 'adjustment') {
            $movement->current_stock = $item->stock += $request->quantity;
          }

          $item->save();
          $movement->fill($request->validated());
          $movement->save();

        } else {
          throw new Exception('Inventory Item not found!');
        }
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Admin/InventoryMovements/Show', [
            'movement' => InventoryMovement::find($id),
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
