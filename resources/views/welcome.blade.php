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
            <form action="{{ url('/reservasi/cari') }}#kamar-section" method="GET" class="search-form" id="searchForm">
                <div class="form-group">
                    <label for="lantai"><i data-lucide="layers" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Lantai</label>
                    <select id="lantai" name="lantai">
                        <option value="">Semua Lantai</option>
                        @foreach($roomFloors as $floor)
                            <option value="{{ $floor }}" {{ request('lantai') == $floor ? 'selected' : '' }}>Lantai {{ $floor }}</option>
                        @endforeach
                    </select>
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

                <div class="form-group">
                    <label for="tipe_kamar"><i data-lucide="bed-double" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Tipe Kamar</label>
                    <select id="tipe_kamar" name="tipe_kamar">
                        <option value="">Semua Tipe</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type }}" {{ request('tipe_kamar') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="search-submit-btn" aria-label="Cari Kamar" style="width: 50px; height: 50px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 18px;">
                    <i data-lucide="search" style="width: 24px; height: 24px;"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- Room List Section -->
    <section class="section" id="kamar-section">
        <div class="section-header">
            @if($isSearch)
                <h2>Hasil Pencarian Kamar</h2>
                <p>Kamar yang tersedia sesuai kriteria Anda.</p>
            @else
                <h2>Kamar Terbaru</h2>
                <p>Jelajahi kamar-kamar terbaru kami dengan fasilitas yang baru diperbarui.</p>
            @endif
        </div>

        <div class="room-grid">
            @forelse($isSearch ? $rooms : $latestRooms as $room)
                @include('partials.room_card', ['room' => $room])
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color);">
                    @if($isSearch)
                        <i data-lucide="search-x" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                        <h3>Kamar tidak ditemukan</h3>
                        <p>Coba ubah jumlah tamu, tipe kamar, atau lantai lainnya.</p>
                    @else
                        <i data-lucide="help-circle" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 15px;"></i>
                        <h3>Belum ada kamar terbaru</h3>
                    @endif
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
    @if($isSearch)
    <script>
        // Auto scroll to results when search is performed
        window.addEventListener('DOMContentLoaded', (event) => {
            const kamarSection = document.getElementById('kamar-section');
            if(kamarSection) {
                kamarSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>
    @endif
@endsection
