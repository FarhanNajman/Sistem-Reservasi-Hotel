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
                    <input type="date" id="check_in" name="check_in" required value="{{ request('check_in', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="form-group">
                    <label for="check_out"><i data-lucide="calendar-output" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Check-Out</label>
                    <input type="date" id="check_out" name="check_out" required value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                
                <div class="form-group">
                    <label for="tamu"><i data-lucide="users" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Jumlah Tamu</label>
                    <select id="tamu" name="tamu">
                        <option value="1" {{ request('tamu') == '1' ? 'selected' : '' }}>1 Orang</option>
                        <option value="2" {{ request('tamu', '2') == '2' ? 'selected' : '' }}>2 Orang</option>
                        <option value="3" {{ request('tamu') == '3' ? 'selected' : '' }}>3 Orang</option>
                        <option value="4" {{ request('tamu') == '4' ? 'selected' : '' }}>4 Orang</option>
                    </select>
                </div>
                
                <button type="submit" class="search-submit-btn">
                    <i data-lucide="search" style="width: 18px;"></i>
                    Cari Kamar
                </button>
            </form>
        </div>
    </div>
    <!-- Room List Section -->
    <section class="section">
        <div class="section-header">
            <h2>Kamar & Pilihan Menginap</h2>
            <p>Pilihlah tipe kamar terbaik yang sesuai dengan kebutuhan perjalanan bisnis atau liburan keluarga Anda.</p>
        </div>

        @if(!$isSearch)
            <div class="tabs-header" style="display: flex; justify-content: center; gap: 15px; margin-bottom: 30px;">
                <button type="button" class="tab-btn active" onclick="openTab(this, 'kamar-terbaru')">Kamar Terbaru</button>
                <button type="button" class="tab-btn" onclick="openTab(this, 'semua-kamar')">Semua Kamar</button>
            </div>
            
            <div id="kamar-terbaru" class="tab-content active">
                <div class="room-grid">
                    @forelse($latestRooms as $room)
                        @include('partials.room_card', ['room' => $room])
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                            <i data-lucide="help-circle" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                            <h3>Belum ada kamar terbaru</h3>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div id="semua-kamar" class="tab-content" style="display: none;">
                <div class="room-grid">
                    @forelse($rooms as $room)
                        @include('partials.room_card', ['room' => $room])
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                            <i data-lucide="help-circle" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                            <h3>Belum ada kamar tersedia</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="room-grid">
                @forelse($rooms as $room)
                    @include('partials.room_card', ['room' => $room])
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                        <i data-lucide="search-x" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                        <h3>Kamar tidak ditemukan</h3>
                        <p>Coba ubah tanggal atau kriteria pencarian lainnya.</p>
                        <a href="{{ url('/') }}" class="search-submit-btn" style="display: inline-flex; width: auto; margin-top: 15px; text-decoration: none; padding: 10px 20px;">Kembali</a>
                    </div>
                @endforelse
            </div>
        @endif
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
    <script>
        // Tab Logic
        function openTab(btnElement, tabName) {
            let i, tabcontent, tablinks;
            
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].classList.remove("active");
            }
            
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            
            const activeContent = document.getElementById(tabName);
            if (activeContent) {
                activeContent.style.display = "block";
                
                // Force reflow before adding active class for animation
                void activeContent.offsetWidth;
                activeContent.classList.add("active");
            }
            
            if (btnElement) {
                btnElement.classList.add("active");
            }
        }
    </script>
@endsection
