<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Folio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Reports/ReportsList');
    }

    public function generateReport(Request $request) {
        $month = Carbon::parse($request->month)->month;
        $year = $request->year;

        // Fetch all income for month, year
        $folios = Folio::with([
            'guest',
            'booking',
            'transactions' => function($query) use ($month, $year) {
                $query->whereMonth('date_placed', $month)
                      ->whereYear('date_placed', $year)
                      ->where('is_paid', true);
            }
        ])->whereHas('transactions', function($query) use ($month, $year) {
            $query->whereMonth('date_placed', $month)
                  ->whereYear('date_placed', $year);
        })->get();

        $totalIncome = 0; $totalCashPayments = 0; $totalCardPayments = 0; $totalGcashPayments = 0; $totalPaymayaPayments = 0; $totalCheckPayments = 0;
        foreach($folios as $folio) {
            $totalIncome += (int) $folio->transactions->sum('amount');

            // Calculate total for payment methods
            if($folio->transactions) {
                foreach($folio->transactions as $transaction) {
                    if($transaction->payment_method === 'Cash') {
                        $totalCashPayments += (int) $transaction->amount;
                    }

                    if($transaction->payment_method === 'Credit/Debit Card' || $transaction->payment_method === 'card') {
                        $totalCardPayments += (int) $transaction->amount;
                    }

                    if($transaction->payment_method === 'Gcash' || $transaction->payment_method === 'gcash') {
                        $totalGcashPayments += (int) $transaction->amount;
                    }

                    if($transaction->payment_method === 'PayMaya' || $transaction->payment_method === 'paymaya') {
                        $totalPaymayaPayments += (int) $transaction->amount;
                    }

                    if($transaction->payment_method === 'Check') {
                        $totalCheckPayments += (int) $transaction->amount;
                    }
                }
            }
        }

        // Accounts Receivable
        $accountReceivables = Folio::with([
            'guest',
            'booking',
            'transactions' => function($query) use ($month, $year) {
                $query->whereMonth('date_placed', $month)
                      ->whereYear('date_placed', $year)
                      ->where('is_paid', false);
            }
        ])->whereHas('transactions', function($query) use ($month, $year) {
            $query->whereMonth('date_placed', $month)
                  ->whereYear('date_placed', $year)
                  ->where('is_paid', false);
        })->get();

        $totalReceivables = 0;
        foreach($accountReceivables as $folio) {
            $totalReceivables += (int) $folio->transactions->sum('amount');
        }

        // Operational Expenses
        $expenses = Expense::whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year);

        $totalExpenses = $expenses->sum('amount');

        $grandTotal = (int) $totalIncome - (int) $totalExpenses;
        $isPositive = ($grandTotal > 0);

        return Inertia::render('Admin/Reports/Show', [
            'folios' => $folios,
            'expenses' => $expenses->get(),
            'accountReceivables' => $accountReceivables,
            'month' => $request->month,
            'year' => $year,
            'totalIncome' => 'P' . number_format($totalIncome, 2),
            'totalExpenses' => 'P' . number_format($totalExpenses, 2),
            'totalReceivables' => 'P' . number_format($totalReceivables, 2),
            'grandTotal' => 'P' . number_format($grandTotal, 2),
            'isPositive' => $isPositive,
            'totalCashPayments' => 'P' . number_format($totalCashPayments, 2),
            'totalCardPayments' => 'P' . number_format($totalCardPayments, 2),
            'totalGcashPayments' => 'P' . number_format($totalGcashPayments, 2),
            'totalPaymayaPayments' => 'P' . number_format($totalPaymayaPayments, 2),
            'totalCheckPayments' => 'P' . number_format($totalCheckPayments, 2),
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
