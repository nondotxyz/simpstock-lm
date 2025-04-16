<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CashierMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'loginCashier'])->name('login');
Route::post('/login', [AuthController::class, 'authenticateCashier'])->name('cashier.authenticate');
Route::get('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'authenticateAdmin'])->name('admin.authenticate');

Route::middleware(CashierMiddleware::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/report', [ReportController::class, 'index'])->name('report');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction/list', [TransactionController::class, 'list'])->name('transaction.list');
    Route::get('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

    Route::get('/stocks', [StocksController::class, 'index'])->name('stocks');
    Route::post('/stocks/create/', [StocksController::class, 'store'])->name('stocks.create');
    Route::get('/stocks/{product}/edit', [StocksController::class, 'edit'])->name('stocks.edit');
    Route::get('/stocks/{product}/update', [StocksController::class, 'update'])->name('stocks.update');

});

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/cashiers', [CashierController::class, 'index'])->name('cashiers.index');
    Route::post('/cashiers', [CashierController::class, 'store'])->name('cashiers.create');
    Route::put('/cashiers/{cashier}', [CashierController::class, 'update'])->name('cashiers.update');
    Route::delete('/cashiers/{cashier}', [CashierController::class, 'destroy'])->name('cashiers.destroy');
    Route::get('/cashiers/{cashier}/edit', [CashierController::class, 'edit'])->name('cashiers.edit');
});


