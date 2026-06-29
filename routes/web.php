<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Http\Controllers\AuthController;

// Redirect root to /reservasi_hotel
Route::redirect('/', '/reservasi_hotel');

Route::prefix('reservasi_hotel')->group(function () {
    Route::get('/', function () {
        $rooms = Room::all();
        return view('welcome', compact('rooms'));
    });
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Room Booking Route (Checks auth and redirects if guest)
Route::get('/reservasi/pesan/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
    }
    
    $room = Room::findOrFail($id);
    return redirect('/reservasi_hotel')->with('success', 'Kamar No. ' . $room->nomor_kamar . ' (' . $room->tipe_kamar . ') berhasil dipilih! Fitur pengisian data pesanan segera hadir.');
})->name('reservasi.pesan');

