<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Controllers\AuthController;

// Redirect root to /reservasi_hotel
Route::redirect('/', '/reservasi_hotel');

Route::prefix('reservasi_hotel')->group(function () {
    Route::get('/', function () {
        $rooms = Room::all();
        return view('welcome', compact('rooms'));
    });

    Route::get('/kamar/{id}', function ($id) {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    })->name('rooms.show');
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


// Admin: Edit, Update, Delete Kamar (basic closures)
Route::get('/reservasi_hotel/kamar/create', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403);
    }

    return view('rooms.create');
})->name('rooms.create');

Route::post('/reservasi_hotel/kamar', function (Request $request) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403);
    }

    $data = $request->validate([
        'tipe_kamar' => 'required|string|max:255',
        'nomor_kamar' => 'required|string|max:100|unique:rooms,nomor_kamar',
        'kapasitas' => 'required|integer|min:1',
        'harga_per_malam' => 'required|numeric|min:0',
        'status' => 'required|in:tersedia,penuh,perbaikan',
        'deskripsi' => 'nullable|string',
        'foto_kamar' => 'nullable|string',
    ]);

    Room::create($data);

    return redirect('/reservasi_hotel')->with('success', 'Kamar baru berhasil ditambahkan.');
})->name('rooms.store');

Route::get('/reservasi_hotel/kamar/{id}/edit', function ($id) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403);
    }

    $room = Room::findOrFail($id);
    return view('rooms.edit', compact('room'));
})->name('rooms.edit');

Route::post('/reservasi_hotel/kamar/{id}/update', function (Request $request, $id) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403);
    }

    $room = Room::findOrFail($id);

    $data = $request->validate([
        'tipe_kamar' => 'required|string|max:255',
        'nomor_kamar' => 'required|string|max:100',
        'kapasitas' => 'required|integer|min:1',
        'harga_per_malam' => 'required|numeric|min:0',
        'status' => 'required|in:tersedia,penuh,perbaikan',
        'deskripsi' => 'nullable|string',
        'foto_kamar' => 'nullable|string',
    ]);

    $room->update($data);

    return redirect()->route('rooms.show', $room->id)->with('success', 'Data kamar berhasil diperbarui.');
})->name('rooms.update');

Route::post('/reservasi_hotel/kamar/{id}/delete', function ($id) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403);
    }

    $room = Room::findOrFail($id);
    $room->delete();

    return redirect('/reservasi_hotel')->with('success', 'Kamar berhasil dihapus.');
})->name('rooms.delete');

