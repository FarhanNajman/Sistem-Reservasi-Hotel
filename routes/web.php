<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;

// Redirect root to /reservasi_hotel
Route::redirect('/', '/reservasi_hotel');

Route::prefix('reservasi_hotel')->group(function () {
    Route::get('/', function () {
        $rooms = Room::all();
        return view('welcome', compact('rooms'));
    });
});
