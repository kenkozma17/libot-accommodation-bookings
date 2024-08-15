<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Inertia\Inertia;
use App\Http\Requests\ExpenseStoreRequest;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $expenses = Expense::where([
            [function ($query) use ($request) {
              if (($s = $request->search)) {
                $query->where('name', 'LIKE', '%' . $s . '%')
                    ->orWhere('type', 'LIKE', '%' . $s . '%')
                    ->get();
              }
            }]
          ])
          ->orderBy('created_at', 'asc')
          ->paginate(config('pagination.default'))
          ->withQueryString();

        return Inertia::render('Admin/Expenses/ExpensesList', [
            'expenses' => $expenses,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Expenses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseStoreRequest $request)
    {
        $expense = new Expense();
        $expense->fill($request->validated());
        $expense->save();

        session()->flash('flash.banner', 'Expenses Created Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::find($id);
        return Inertia::render('Admin/Expenses/Show', [
            'expense' => $expense,
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
    public function update(ExpenseStoreRequest $request, string $id)
    {
        $expense = Expense::find($id);
        $expense->fill($request->validated());
        $expense->save();

        session()->flash('flash.banner', 'Expense Updated Successfully!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
