<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Folio;
use App\Models\FolioTransaction;
use App\Models\InventoryMovement;
use App\Models\Service;
use App\Models\ServiceCategory;
use Inertia\Inertia;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

class FolioTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // try {
            $folioTransaction = new FolioTransaction();
            $folioTransaction->fill($request->all());
            $folioTransaction->folio_id = $request->folio_id;
            $folioTransaction->user_id = Auth::user()->id;
            $folioTransaction->service_id = $request->service['id'];
            $folioTransaction->date_placed = $request->date_placed;

            $service = Service::with('inventory_items')->find($request->service['id']);
            if(!$service) {
                session()->flash('flash.banner', 'Service not found!');
                session()->flash('flash.bannerStyle', 'danger');
                return redirect()->back();
            }

            # Fetch all service inventory items and then decrease each inventory items stock by stored quantity
            $serviceItems = $service->inventory_items;
            for($y = 0; $y < $request->quantity; $y++) {
              $this->modifyStockOnService($serviceItems, 'Decrease');
            }

            if($service->slug === 'down-payment' || $service->slug === 'manual-payment' || $service->slug === 'adjustment' || $service->slug === 'discount') {
              $folioTransaction->price = $request->amount;
            } elseif($service->slug === 'senior-discount') {
              $folioTransaction->price = -($request->amount * .2);
            } else {
              $folioTransaction->price = $service->price;
            }

            $folioTransaction->amount = $folioTransaction->price * $request->quantity;
            $folioTransaction->service_name = $service->name;
            $folioTransaction->save();

            session()->flash('flash.banner', 'Transaction Created Successfully!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('folios.show', $request->folio_id);

        // } catch(Exception $ex) {

        // }
    }

    public function modifyStockOnService($items, string $type) {
      if($items) {
        foreach($items as $item) {
          $movement = InventoryMovement::create([
            'type' => $type,
            'quantity' => $item->pivot->quantity,
            'unit' => $item->pivot->unit,
            'inventory_item_id' => $item->id,
            'current_stock' => $item->stock - $item->pivot->quantity,
            'previous_stock' => $item->stock,
          ]);
          $movement->save();
          $item->stock = $item->stock - $item->pivot->quantity;
          $item->save();
        }
      }
    }

    public function printFolio($folioId) {
        $folio = Folio::with(['guest'])->where('id', $folioId)->first();
        $gross = 0; $discount = 0; $balance = 0;
        foreach($folio->transactions as $transaction) {
          if(str_contains(strtolower($transaction->service_name), 'discount')) {
            $discount += (float) $transaction->amount;
          } else {
            $gross += (float) $transaction->amount;
            if(!$transaction->is_paid) {
              $balance += (float) $transaction->amount;
            }
          }
        }

        return Inertia::render('Admin/FolioTransactions/Print', [
            'folio' => $folio,
            'gross' => 'P' . number_format($gross, 2),
            'total' => 'P' . number_format($gross + $discount, 2),
            'discount' => 'P' . number_format(abs($discount), 2),
            'balance' => 'P' . number_format($balance, 2)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $folioTransaction = FolioTransaction::with(['folio', 'service', 'user'])->where('id', $id)->first();
        $serviceCategories = ServiceCategory::with('services')->orderBy('name', 'asc')->get();
        return Inertia::render('Admin/FolioTransactions/Show', [
            'transaction' => $folioTransaction,
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
    public function update(Request $request, string $id)
    {
        try {
            $folioTransaction = FolioTransaction::find($id);
            $folioTransaction->update($request->all());

            $folioTransaction->amount = $folioTransaction->price * $request->quantity;

            $folioTransaction->save();

            session()->flash('flash.banner', 'Transaction Updated Successfully!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->back();
          } catch(Exception $e) {
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
