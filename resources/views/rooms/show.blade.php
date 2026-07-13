@extends('layouts.app')

@section('title', 'Detail Kamar ' . $room->nomor_kamar . ' - N★JM Hotel')

@section('content')
@php
    $floorPlan = null;
    $mainImage = $room->foto_kamar ? (filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar)) : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80';

    if ($room->tipe_kamar === 'Standard Room') {
        if ($room->nomor_kamar === '101') {
            $floorPlan = 'gambar/kamar/standard/denah1.webp';
        } elseif ($room->nomor_kamar === '102') {
            $floorPlan = 'gambar/kamar/standard/denah2.jpg';
        } elseif ($room->nomor_kamar === '103') {
            $floorPlan = 'gambar/kamar/standard/denah3.jpg';
        }
    }
@endphp

<div class="detail-container">
    <!-- Breadcrumbs Navigation -->
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Beranda</a>
        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
        <span>Detail Kamar</span>
        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
        <span class="active">{{ $room->tipe_kamar }} - No. {{ $room->nomor_kamar }}</span>
    </div>

    <!-- Main Detail Grid -->
    <div class="detail-grid">
        <!-- Left Column: Visual Assets & Info -->
        <div class="detail-main">
            <!-- Main Room Image -->
            <div class="detail-hero-card">
                <img id="mainRoomImage" src="{{ $mainImage }}" alt="{{ $room->tipe_kamar }}" class="detail-hero-img">
                
                @if($room->status === 'tersedia')
                    <span class="room-badge tersedia">Tersedia</span>
                @elseif($room->status === 'penuh')
                    <span class="room-badge penuh">Penuh</span>
                @else
                    <span class="room-badge perbaikan">Dalam Perbaikan</span>
                @endif
            </div>

            <!-- Room Specifications & Facilities -->
            <div class="detail-info-card">
                <h3 class="detail-section-title">Spesifikasi & Fasilitas Kamar</h3>
                
                <div class="specs-grid">
                    <div class="spec-item">
                        <i data-lucide="home"></i>
                        <div>
                            <h5>Tipe Kamar</h5>
                            <p>{{ $room->tipe_kamar }}</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i data-lucide="key-round"></i>
                        <div>
                            <h5>Nomor Kamar</h5>
                            <p>Kamar {{ $room->nomor_kamar }}</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i data-lucide="building-2"></i>
                        <div>
                            <h5>Lantai</h5>
                            <p>Lantai {{ $room->lantai }}</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i data-lucide="users"></i>
                        <div>
                            <h5>Kapasitas Maksimal</h5>
                            <p>{{ $room->kapasitas }} Orang Dewasa</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <i data-lucide="wallet"></i>
                        <div>
                            <h5>Tarif Kamar</h5>
                            <p>Rp {{ number_format($room->harga_per_malam, 0, ',', '.') }} / malam</p>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <h4 class="section-subtitle">Fasilitas yang Didapat</h4>
                <div class="amenities-grid">
                    <div class="amenity-item">
                        <i data-lucide="wifi"></i>
                        <span>Koneksi Wi-Fi Gratis & Cepat</span>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="snowflake"></i>
                        <span>Pendingin Ruangan (AC) Sentral</span>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="tv"></i>
                        <span>TV Flat-Screen Smart TV</span>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="coffee"></i>
                        <span>Teko Listrik / Coffee Maker</span>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="bath"></i>
                        <span>Kamar Mandi Dalam & Hot Shower</span>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="concierge-bell"></i>
                        <span>Layanan Housekeeping Harian</span>
                    </div>
                </div>
            </div>

            <!-- Floor Plan (Denah Kamar) -->
            @if($floorPlan)
                <div class="detail-info-card">
                    <h3 class="detail-section-title">Denah Layout Kamar</h3>
                    <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 0.95rem;">Berikut adalah denah desain arsitektur interior untuk Kamar No. {{ $room->nomor_kamar }} (Standard Room).</p>
                    <div class="floorplan-container">
                        <img src="{{ asset($floorPlan) }}" alt="Denah Kamar {{ $room->nomor_kamar }}" class="floorplan-img" onclick="openLightbox('{{ asset($floorPlan) }}')">
                        <div class="floorplan-overlay">
                            <i data-lucide="zoom-in"></i> Klik untuk memperbesar denah
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Room Booking Summary Sticky Sidebar -->
        <div class="detail-sidebar">
            <div class="booking-sidebar-card">
                <div class="sidebar-header">
                    <span class="sidebar-category">{{ $room->tipe_kamar }}</span>
                    <h2 class="sidebar-room-name">Kamar No. {{ $room->nomor_kamar }}</h2>
                </div>
                
                <div class="sidebar-price-section">
                    <span class="sidebar-price">Rp {{ number_format($room->harga_per_malam, 0, ',', '.') }}</span>
                    <span class="sidebar-price-label">/ malam (termasuk pajak & sarapan)</span>
                </div>

                <div class="divider"></div>

                <div class="sidebar-features">
                    <div class="sidebar-feature-row">
                        <span class="feature-label">Status Kamar</span>
                        @if($room->status === 'tersedia')
                            <span class="status-badge-inline tersedia">Tersedia untuk Dipesan</span>
                        @elseif($room->status === 'penuh')
                            <span class="status-badge-inline penuh">Kamar Penuh</span>
                        @else
                            <span class="status-badge-inline perbaikan">Sedang Dipelihara</span>
                        @endif
                    </div>
                    <div class="sidebar-feature-row">
                        <span class="feature-label">Posisi Kamar</span>
                        <span class="feature-val">Lantai {{ $room->lantai }}</span>
                    </div>
                    <div class="sidebar-feature-row">
                        <span class="feature-label">Maksimal Tamu</span>
                        <span class="feature-val">{{ $room->kapasitas }} Tamu</span>
                    </div>
                    <div class="sidebar-feature-row">
                        <span class="feature-label">Jenis Ranjang</span>
                        <span class="feature-val">
                            @if($room->nomor_kamar == '103')
                                2 Single Beds
                            @else
                                1 Double King Bed
                            @endif
                        </span>
                    </div>
                </div>
 
                <p class="sidebar-desc-brief">
                    {{ $room->deskripsi }}
                </p>

                <div class="divider"></div>

                @if($room->status === 'tersedia')
                    <a href="{{ url('/reservasi/pesan/'.$room->id) }}" class="sidebar-book-btn">
                        <i data-lucide="calendar-check" style="width: 18px; height: 18px;"></i>
                        Pesan Kamar Sekarang
                    </a>
                @elseif($room->status === 'penuh')
                    <button class="sidebar-book-btn disabled" disabled>
                        <i data-lucide="user-x" style="width: 18px; height: 18px;"></i>
                        Kamar Penuh
                    </button>
                @else
                    <button class="sidebar-book-btn disabled" disabled>
                        <i data-lucide="alert-triangle" style="width: 18px; height: 18px;"></i>
                        Kamar Tidak Tersedia
                    </button>
                @endif

                <a href="{{ url('/') }}" class="sidebar-back-btn">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                    Kembali ke Daftar Kamar
                </a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <div class="divider"></div>
                        <div class="admin-actions">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="sidebar-edit-btn">Edit</a>
                            <form action="{{ route('rooms.delete', $room->id) }}" method="POST" style="display:inline-flex; gap:8px;" onsubmit="return confirm('Yakin ingin menghapus Kamar No. {{ $room->nomor_kamar }}?');">
                                @csrf
                                <button type="submit" class="sidebar-delete-btn">Hapus</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Simple Lightbox for Floor Plan -->
<div id="floorplanLightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage">
    <div id="lightboxCaption" class="lightbox-caption"></div>
</div>

@endsection

@section('scripts')
<script>
    function openLightbox(imgUrl) {
        const lightbox = document.getElementById('floorplanLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        const lightboxCaption = document.getElementById('lightboxCaption');
        
        lightbox.style.display = "flex";
        lightboxImg.src = imgUrl;
        lightboxCaption.innerHTML = "Denah Detail Layout Kamar Standard No. {{ $room->nomor_kamar }}";
    }

    function closeLightbox() {
        document.getElementById('floorplanLightbox').style.display = "none";
    }
</script>
@endsection
