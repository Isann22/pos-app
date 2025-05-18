<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::get('/receipt/{orderId}', \App\Livewire\Pos\Receipt::class)->name('receipt.livewire');
Route::get('/sales', \App\Livewire\Pos\Pos::class)->middleware(['auth', 'verified'])->name('cashier');

Route::view('/test', 'test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
