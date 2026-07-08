@extends('layouts.app')

@section('title', 'N★JM Hotel - Beranda Pemesanan Kamar')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang Di</h1>
            <img src="{{ asset('gambar/logo/logo1.png') }}" alt="Logo Utama" style="height: 200px; width: auto; object-fit: contain; margin: 15px auto; display: block;">
            <p>Perpaduan sempurna antara kemewahan modern, kenyamanan prima, dan kehangatan tradisi pelayanan terbaik di pusat kota.</p>
        </div>
    </section>

    <!-- Search / Filter Bar Container -->
    <div style="display: flex; justify-content: center; width: 100%;">
        <div class="search-bar-container">
            <form action="{{ url('/reservasi/cari') }}" method="GET" class="search-form" id="searchForm">
                <div class="form-group">
                    <label for="check_in"><i data-lucide="calendar-input" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Check-In</label>
                    <input type="date" id="check_in" name="check_in" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="form-group">
                    <label for="check_out"><i data-lucide="calendar-output" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Check-Out</label>
                    <input type="date" id="check_out" name="check_out" required value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                
                <div class="form-group">
                    <label for="tamu"><i data-lucide="users" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Jumlah Tamu</label>
                    <select id="tamu" name="tamu">
                        <option value="1">1 Orang</option>
                        <option value="2" selected>2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                    </select>
                </div>
                
                <button type="submit" class="search-submit-btn">
                    <i data-lucide="search" style="width: 18px;"></i>
                    Cari Kamar
                </button>
            </form>
        </div>
    </div>
@auth
@if(Auth::user()->role == 'admin')

<div class="admin-dashboard">

    <div class="admin-top">

        <div>
            <h2>Dashboard Admin</h2>
            <p>Kelola seluruh data kamar hotel.</p>
        </div>

        <a href="#" class="admin-add-btn">
            + Tambah Kamar
        </a>

    </div>

    <div class="admin-card-grid">

        <div class="admin-card">
            <h3>{{ $rooms->count() }}</h3>
            <span>Total Kamar</span>
        </div>

        <div class="admin-card">
            <h3>{{ $rooms->where('status','tersedia')->count() }}</h3>
            <span>Tersedia</span>
        </div>

        <div class="admin-card">
            <h3>{{ $rooms->where('status','perbaikan')->count() }}</h3>
            <span>Perbaikan</span>
        </div>

        <div class="admin-card">
            <h3>{{ $rooms->where('tipe_kamar','VIP Room')->count() }}</h3>
            <span>VIP Room</span>
        </div>

    </div>

</div>

@endif
@endauth
    <!-- Room List Section -->
    <section class="section">
        <div class="section-header">
            <h2>Kamar & Pilihan Menginap</h2>
            <p>Pilihlah tipe kamar terbaik yang sesuai dengan kebutuhan perjalanan bisnis atau liburan keluarga Anda.</p>
        </div>

        <div class="room-grid">
            @forelse($rooms as $room)
                <div class="room-card">
                    <div class="room-img-container">
                        <a href="{{ route('rooms.show', $room->id) }}">
                            @if($room->foto_kamar)
                                <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="{{ $room->tipe_kamar }}" class="room-img">
                            @else
                                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" alt="Default Room Image" class="room-img">
                            @endif
                        </a>
                        
                        @auth

@if(Auth::user()->role == 'admin')

<a href="#" class="room-book-btn">
    Edit
</a>

@else

    @if($room->status === 'tersedia')
        <a href="{{ url('/reservasi/pesan/'.$room->id) }}" class="room-book-btn">
            Pesan
        </a>
    @else
        <a href="#" class="room-book-btn disabled" tabindex="-1">
            Pesan
        </a>
    @endif

@endif

@else

@if($room->status === 'tersedia')
    <a href="{{ url('/login') }}" class="room-book-btn">
        Pesan
    </a>
@else
    <a href="#" class="room-book-btn disabled">
        Pesan
    </a>
@endif

@endauth
                    </div>
                    
                    <div class="room-details">
                        <div class="room-title-row">
                            <h3 class="room-type">
                                <a href="{{ route('rooms.show', $room->id) }}" class="room-title-link">{{ $room->tipe_kamar }}</a>
                            </h3>
                            <span class="room-number">Kamar No. {{ $room->nomor_kamar }}</span>
                        </div>
                        
                        <ul class="room-features">
                            <li><i data-lucide="users" style="width: 14px; color: var(--primary-color);"></i> {{ $room->kapasitas }} Tamu</li>
                            <li><i data-lucide="wifi" style="width: 14px; color: var(--primary-color);"></i> Free Wi-Fi</li>
                            <li><i data-lucide="snowflake" style="width: 14px; color: var(--primary-color);"></i> AC</li>
                        </ul>
                        
                        <p class="room-desc">{{ $room->deskripsi }}</p>
                        
                        <div class="room-footer">
                            <div class="room-price-wrapper">
                                <span class="room-price">Rp {{ number_format($room->harga_per_malam, 0, ',', '.') }}</span>
                                <span style="font-size: 0.8rem; color: var(--text-muted);">/ malam</span>
                            </div>
                            
                            <div class="room-actions" style="display: flex; gap: 8px;">
                                <a href="{{ route('rooms.show', $room->id) }}" class="room-detail-btn">Detail</a>
                                @if($room->status === 'tersedia')
                                    <a href="{{ url('/reservasi/pesan/'.$room->id) }}" class="room-book-btn">Pesan</a>
                                @else
                                    <a href="#" class="room-book-btn disabled" tabindex="-1">Pesan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                    <i data-lucide="help-circle" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                    <h3>Belum ada kamar tersedia</h3>
                    <p>Silakan hubungi administrator hotel untuk input data kamar.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Services / Amenities Section -->
    <section class="section" style="background-color: white; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="section-header">
            <h2>Layanan & Fasilitas Hotel</h2>
            <p>Nikmati berbagai layanan premium kami untuk memaksimalkan pengalaman menginap Anda di N★JM Hotel.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <i data-lucide="coffee"></i>
                </div>
                <h3>Sarapan Gratis</h3>
                <p>Mulai hari Anda dengan sarapan prasmanan hidangan lokal khas Indonesia dan internasional yang lezat.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <i data-lucide="shield-check"></i>
                </div>
                <h3>Keamanan 24 Jam</h3>
                <p>Sistem keamanan modern terintegrasi CCTV dan petugas keamanan siaga demi kenyamanan Anda.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <i data-lucide="utensils"></i>
                </div>
                <h3>Restoran Premium</h3>
                <p>Nikmati cita rasa kuliner terbaik, termasuk hidangan andalan khas koki kami, di restoran hotel.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <i data-lucide="sparkles"></i>
                </div>
                <h3>Layanan Kamar Harian</h3>
                <p>Kamar Anda akan selalu bersih, rapi, dan harum berkat layanan housekeeping harian yang teliti.</p>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Logika sederhana untuk validasi tanggal check-in & check-out
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');

        checkInInput.addEventListener('change', function() {
            // Check-out minimal harus H+1 dari check-in
            const checkInDate = new Date(this.value);
            checkInDate.setDate(checkInDate.getDate() + 1);
            
            const nextDayString = checkInDate.toISOString().split('T')[0];
            checkOutInput.min = nextDayString;
            
            if (checkOutInput.value < nextDayString) {
                checkOutInput.value = nextDayString;
            }
        });
    </script>
@endsection
