<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('transactions.create');

    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');
});

Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index');

Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
    ->name('transactions.edit');

Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
    ->name('transactions.update');

Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
    ->name('transactions.destroy');


require __DIR__.'/auth.php';


