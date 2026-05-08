<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RfqController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('rfqs', RfqController::class);
    Route::resource('vendors', VendorController::class);
    Route::post('rfqs/{rfq}/invite', [RfqController::class, 'inviteVendor'])->name('rfqs.invite');
});

require __DIR__.'/auth.php';