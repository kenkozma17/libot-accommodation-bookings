<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Folio;
use App\Models\FolioTransaction;
use App\Models\Service;
use App\Models\ServiceCategory;
use Inertia\Inertia;
use Exception;
use Illuminate\Http\Request;

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
            $folioTransaction->service_id = $request->service['id'];
            $folioTransaction->date_placed = $request->date_placed;

            $service = Service::find($request->service['id']);
            if(!$service) {
                session()->flash('flash.banner', 'Service not found!');
                session()->flash('flash.bannerStyle', 'danger');
                return redirect()->back();
            }
            $folioTransaction->price = (
                $service->slug === 'down-payment' || $service->slug === 'manual-payment' || $service->slug === 'adjustment'
                ? $request->amount
                : $service->price
            );
            $folioTransaction->amount = $folioTransaction->price * $request->quantity;
            $folioTransaction->service_name = $service->name;
            $folioTransaction->save();

            session()->flash('flash.banner', 'Transaction Created Successfully!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('folios.show', $request->folio_id);

        // } catch(Exception $ex) {

        // }
    }

    public function printFolio($folioId) {
        $folio = Folio::with(['guest'])->where('id', $folioId)->first();
        $totalExpenses = 0;
        foreach($folio->transactions as $transaction) {
            $totalExpenses += (int) $transaction->amount;
        }
        return Inertia::render('Admin/FolioTransactions/Print', [
            'folio' => $folio,
            'totalExpenses' => 'P' . number_format($totalExpenses, 2)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $folioTransaction = FolioTransaction::with(['folio', 'service'])->where('id', $id)->first();
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
