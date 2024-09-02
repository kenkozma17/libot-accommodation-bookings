<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $search = $request->get('search');
      $payments = Payment::where([
        [function ($query) use ($request) {
          if (($s = $request->search)) {
            $query->orWhere('payer_name', 'LIKE', '%' . $s . '%')
              ->orWhere('payment_amount', 'LIKE', '%' . $s . '%')
              ->get();
          }
        }]
      ])
        ->where('payment_status', 'PAID')
        ->orderBy('created_at', 'desc')
        ->paginate(config('pagination.default'))
        ->withQueryString();;

      return Inertia::render('Admin/Payments/PaymentsList', [
        'payments' => $payments,
        'search' => $search
      ]);
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
      $payment = Payment::where('id', $id)
        ->with(['booking'])->first();
      return Inertia::render('Admin/Payments/Show', [
        'payment' => $payment,
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
