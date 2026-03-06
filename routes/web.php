<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');

