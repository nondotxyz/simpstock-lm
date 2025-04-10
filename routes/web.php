<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/report', [ReportController::class, 'index'])->name('report');

Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
Route::get('/transaction/list', [TransactionController::class, 'list'])->name('transaction.list');
Route::get('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

Route::get('/stocks', [StocksController::class, 'index'])->name('stocks');
Route::post('/stocks/create/', [StocksController::class, 'store'])->name('stocks.create');
Route::get('/stocks/{product}/edit', [StocksController::class, 'edit'])->name('stocks.edit');
Route::get('/stocks/{product}/update', [StocksController::class, 'update'])->name('stocks.update');

