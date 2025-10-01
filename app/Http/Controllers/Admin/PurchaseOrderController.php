<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::with('category')->whereColumn('stock', '<', 'min_level')->get();
        $categories = InventoryCategory::orderBy('name', 'asc')->get();
        return Inertia::render('Admin/PurchaseOrders/LivePurchaseOrder', [
          'items' => $items,
          'categories' => $categories,
        ]);
    }

    /**
     * Generate purchase order printable
     */
    public function generatePurchaseOrderFile(Request $request) {
      $filteredItems = $request->items;
      if($filteredItems) {
        $file = Pdf::loadView('pdf.purchase-order', ['items' => $filteredItems]);
        Storage::put('public/confirmations/purchase_order.pdf', $file->output());
      }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
