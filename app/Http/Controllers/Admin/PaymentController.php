<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Inertia\Inertia;
use Illuminate\Support\Facades\Response;

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

    public function export() {
        // Get all payments
        $payments = Payment::orderBy('created_at', 'desc')->get();

        $csvFileName = 'payments.csv';
        $csvFile = fopen($csvFileName, 'w');
        $headers = ['Transaction #', 'Payer Name', 'Amount', 'Fee', 'Payer Email', 'Payment Method', 'Status', 'Date'];

        // Set CSV headers
        fputcsv($csvFile, $headers);

        foreach($payments as $payment) {
            fputcsv($csvFile, [
                $payment->paymongo_payment_id,
                $payment->payer_name,
                $payment->payment_amount,
                $payment->fee,
                $payment->payer_email,
                $payment->payment_source,
                $payment->status,
                $payment->payment_date,
            ]);
        }

        // Close CSV File
        fclose($csvFile);

        return Response::download(public_path($csvFileName))->deleteFileAfterSend(true);
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
