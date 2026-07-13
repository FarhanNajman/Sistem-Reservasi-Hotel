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
        @include('partials.search_bar')
    </div>
    <!-- Room List Section -->
    <section class="section" id="kamar-section">
        <div class="section-header">
            <h2> Kamar Terbaru</h2>
            <p>Jelajahi kamar-kamar terbaru kami dengan fasilitas yang baru diperbarui.</p>
        </div>

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
@endsection
