<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
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
    })->name('rooms.show')->where('id', '[0-9]+');
});
 
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        $rooms = Room::all();
        $reservations = Reservation::all();

        return view('admin.dashboard', compact('rooms', 'reservations'));
    })->name('admin.dashboard');

    Route::get('/admin/reservations', function () {
        $reservations = Reservation::with('room')->orderBy('created_at', 'desc')->get();
        return view('admin.reservations', compact('reservations'));
    })->name('admin.reservations');

    Route::post('/admin/reservations/{id}/confirm', function ($id) {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->status === 'pending') {
            $reservation->status = 'dikonfirmasi';
            $reservation->save();
            return redirect()->route('admin.reservations')->with('success', 'Pembayaran berhasil dikonfirmasi dan status reservasi menjadi dikonfirmasi.');
        }
        return redirect()->route('admin.reservations')->with('error', 'Status reservasi tidak dapat diubah.');
    })->name('admin.reservations.confirm');

    Route::get('/admin/users', function () {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    })->name('admin.users');
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

    $validated = $request->validate([
        'tipe_kamar' => 'required|string|max:255',
        'lantai' => 'required|integer|min:1|max:3',
        'nomor_kamar' => [
            'required',
            'string',
            'digits_between:1,2',
            Rule::unique('rooms', 'nomor_kamar')->where(fn ($query) => $query->where('lantai', (int) $request->input('lantai'))),
        ],
        'kapasitas' => 'required|integer|min:1',
        'harga_per_malam' => 'required|numeric|min:0',
        'status' => 'required|in:tersedia,penuh,perbaikan',
        'deskripsi' => 'nullable|string',
        'foto_kamar' => 'nullable|string',
        'foto_kamar_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        'denah_kamar_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
    ], [
        'nomor_kamar.unique' => 'Nomor kamar sudah ada untuk lantai ini.',
    ]);

    $validated['nomor_kamar'] = Room::normalizeNomorKamar((int) $validated['lantai'], (string) $validated['nomor_kamar']);

    if ($request->hasFile('foto_kamar_upload')) {
        $path = $request->file('foto_kamar_upload')->store('gambar/kamar', 'public');
        $validated['foto_kamar'] = 'storage/' . $path;
    }

    if ($request->hasFile('denah_kamar_upload')) {
        $path = $request->file('denah_kamar_upload')->store('gambar/denah', 'public');
        $validated['denah_kamar'] = 'storage/' . $path;
    }

    Room::create($validated);

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

    $validated = $request->validate([
        'tipe_kamar' => 'required|string|max:255',
        'lantai' => 'required|integer|min:1|max:3',
        'nomor_kamar' => [
            'required',
            'string',
            'digits_between:1,2',
            Rule::unique('rooms', 'nomor_kamar')->where(fn ($query) => $query->where('lantai', (int) $request->input('lantai')))->ignore($room->id),
        ],
        'kapasitas' => 'required|integer|min:1',
        'harga_per_malam' => 'required|numeric|min:0',
        'status' => 'required|in:tersedia,penuh,perbaikan',
        'deskripsi' => 'nullable|string',
        'foto_kamar' => 'nullable|string',
        'foto_kamar_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        'denah_kamar_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
    ], [
        'nomor_kamar.unique' => 'Nomor kamar sudah ada untuk lantai ini.',
    ]);

    $validated['nomor_kamar'] = Room::normalizeNomorKamar((int) $validated['lantai'], (string) $validated['nomor_kamar']);

    if ($request->hasFile('foto_kamar_upload')) {
        $path = $request->file('foto_kamar_upload')->store('gambar/kamar', 'public');
        $validated['foto_kamar'] = 'storage/' . $path;
    }

    if ($request->hasFile('denah_kamar_upload')) {
        $path = $request->file('denah_kamar_upload')->store('gambar/denah', 'public');
        $validated['denah_kamar'] = 'storage/' . $path;
    }

    $room->update($validated);

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

