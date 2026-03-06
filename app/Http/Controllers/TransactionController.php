<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
{
    $today = Transaction::ofToday()->get();
    $last_week = Transaction::ofLastWeek()->get();
    $last_10_days = Transaction::ofLastDays(10)->get();

    return view('transactions.index', compact('today', 'last_week', 'last_10_days'));
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

    Transaction::create([
        'title' => $request->title,
        'amount' => $request->amount,
        'created_at' => $request->created_at,
    ]);

    return redirect()->route('transactions.index')->with('success', 'Transaction added successfully!');
}
}