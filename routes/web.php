<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');

Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');

Route::delete('/delete/{id}', [TransactionController::class, 'destroy'])->name('transactions.delete');

Route::get('/export', [TransactionController::class, 'export'])->name('transactions.export');
Route::get('/export-excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');