<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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

        // Date scopes (optional dashboard counts)
        $today = Transaction::ofToday()->get();
        $last_week = Transaction::ofLastWeek()->get();
        $last_10_days = Transaction::ofLastDays(10)->get();

        return view('transactions.index', compact(
            'transactions',
            'today',
            'last_week',
            'last_10_days',
            'search'
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

    // 🔥 DELETE FUNCTION
    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}