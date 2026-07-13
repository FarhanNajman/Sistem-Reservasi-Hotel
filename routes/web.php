<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $latestRooms = Room::orderBy('created_at', 'desc')->take(4)->get();
        $roomTypes = Room::select('tipe_kamar')->distinct()->pluck('tipe_kamar');
        $roomFloors = Room::select('lantai')->distinct()->orderBy('lantai')->pluck('lantai');
        $isSearch = false;
        return view('welcome', compact('rooms', 'latestRooms', 'roomTypes', 'roomFloors', 'isSearch'));
    });

    Route::get('/kamar-terbaru', function () {
        $rooms = Room::orderBy('created_at', 'desc')->take(3)->get();
        $title = 'Kamar Terbaru';
        return view('rooms.index', compact('rooms', 'title'));
    })->name('rooms.terbaru');

    Route::get('/semua-kamar', function (Request $request) {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $tamu = $request->input('tamu');
        $tipeKamar = $request->input('tipe_kamar');
        $lantai = $request->input('lantai');

        $query = Room::where('status', '!=', 'perbaikan');

        if ($tamu) {
            $query->where('kapasitas', $tamu);
        }

        if ($tipeKamar) {
            $query->where('tipe_kamar', $tipeKamar);
        }

        if ($lantai) {
            $query->where('lantai', $lantai);
        }

        $rooms = $query->get();
        $isSearch = false;

        if ($checkIn && $checkOut) {
            $isSearch = true;
            foreach ($rooms as $room) {
                // Cek apakah ada reservasi yang tumpang tindih
                $isBooked = $room->reservations()
                    ->where('tanggal_check_in', '<', $checkOut)
                    ->where('tanggal_check_out', '>', $checkIn)
                    ->whereIn('status', ['pending', 'dikonfirmasi', 'check_in'])
                    ->exists();
                    
                if ($isBooked) {
                    $room->status = 'penuh';
                } else {
                    $room->status = 'tersedia';
                }
            }
        }

        $title = ($tamu || $tipeKamar || $lantai || ($checkIn && $checkOut)) ? 'Hasil Pencarian Kamar' : 'Semua Kamar';
        $roomTypes = Room::select('tipe_kamar')->distinct()->pluck('tipe_kamar');
        $roomFloors = Room::select('lantai')->distinct()->orderBy('lantai')->pluck('lantai');
        
        return view('rooms.index', compact('rooms', 'title', 'roomTypes', 'roomFloors', 'isSearch'));
    })->name('rooms.semua');

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

Route::middleware('auth')->group(function () {
    // Menampilkan form pesanan
    Route::get('/reservasi/pesan/{id}', function ($id) {
        $room = Room::findOrFail($id);
        return view('reservasi.create', compact('room'));
    })->name('reservasi.pesan');

    // Memproses data pesanan
    Route::post('/reservasi/pesan/{id}', function (Request $request, $id) {
        $room = Room::findOrFail($id);
        
        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'email_tamu' => 'required|email|max:255',
            'telepon_tamu' => 'required|string|max:20',
            'tanggal_check_in' => 'required|date|after_or_equal:today',
            'tanggal_check_out' => 'required|date|after:tanggal_check_in',
            'catatan' => 'nullable|string',
        ]);

        // Kalkulasi jumlah hari
        $checkIn = \Carbon\Carbon::parse($validated['tanggal_check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['tanggal_check_out']);
        $hari = $checkIn->diffInDays($checkOut);
        
        if ($hari == 0) $hari = 1;

        $totalHarga = $hari * $room->harga_per_malam;

        $baseKode = 'RSV-LT' . $room->lantai . 'N' . $room->nomor_kamar . '-' . $checkIn->format('ymd');
        $kodeBooking = $baseKode;
        $counter = 1;
        while (\App\Models\Reservation::where('kode_booking', $kodeBooking)->exists()) {
            $kodeBooking = $baseKode . '-' . $counter;
            $counter++;
        }

        $reservation = Reservation::create([
            'kode_booking' => $kodeBooking,
            'nama_tamu' => $validated['nama_tamu'],
            'email_tamu' => $validated['email_tamu'], // Menyimpan email dari input manual form
            'telepon_tamu' => $validated['telepon_tamu'],
            'room_id' => $room->id,
            'tanggal_check_in' => $validated['tanggal_check_in'],
            'tanggal_check_out' => $validated['tanggal_check_out'],
            'total_harga' => $totalHarga,
            'status' => 'pending',
            'catatan' => $validated['catatan'],
        ]);

        return redirect()->route('pembayaran.show', $reservation->id);
    });

    // Menampilkan halaman pembayaran
    Route::get('/pembayaran/{id}', function ($id) {
        $reservation = Reservation::where('id', $id)->where('email_tamu', Auth::user()->email)->firstOrFail();
        return view('pembayaran.show', compact('reservation'));
    })->name('pembayaran.show');

    // Memproses pembayaran
    Route::post('/pembayaran/{id}/proses', function ($id) {
        $reservation = Reservation::where('id', $id)->where('email_tamu', Auth::user()->email)->firstOrFail();
        
        // Simulasi sukses pembayaran, ubah status jadi dikonfirmasi (atau dibayar)
        $reservation->update([
            'status' => 'dikonfirmasi'
        ]);

        return redirect()->route('reservasi.saya')->with('success', 'Pembayaran berhasil! Reservasi Anda telah dikonfirmasi.');
    })->name('pembayaran.proses');

    // Menampilkan halaman reservasi saya
    Route::get('/reservasi-saya', function () {
        // Mengambil reservasi berdasarkan email pengguna yang sedang login
        $reservations = Reservation::where('email_tamu', Auth::user()->email)->with('room')->orderBy('created_at', 'desc')->get();
        return view('reservasi.index', compact('reservations'));
    })->name('reservasi.saya');
});


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
        'fasilitas' => 'nullable|array',
        'fasilitas.*' => 'string|max:255',
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
        'fasilitas' => 'nullable|array',
        'fasilitas.*' => 'string|max:255',
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

