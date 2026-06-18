<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class TransactionController extends Controller
{
 
    public function index(Request $request)
    {
        $search = $request->search;

        $transactions = Transaction::when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%$search%");
            })
            ->latest()
            ->paginate(5);

        $today = Transaction::ofToday()->get();
        $last_week = Transaction::ofLastWeek()->get();
        $last_10_days = Transaction::ofLastDays(10)->get();

        return view('transactions.index', compact(
            'transactions', 'today', 'last_week', 'last_10_days', 'search'
        ));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'created_at' => 'required|date',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully!');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'created_at' => 'required|date',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }

    public function export()
    {
        $transactions = Transaction::all();
        $pdf = Pdf::loadView('transactions.pdf', compact('transactions'));
        return $pdf->download('transactions_report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }
}