<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController; 



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');


Auth::routes();


Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::resource('rooms', RoomController::class)->except(['index']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('bookings.create');


    Route::post('/rooms/{room}/book', [BookingController::class, 'store'])->name('bookings.store');


    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
});
