@extends('layouts.app')

@section('title', 'Dashboard Admin - N★JM Hotel')

@section('content')
    <section class="section">
        <div class="admin-dashboard">
            <div class="admin-top">
                <div>
                    <h2>Dashboard Admin</h2>
                    <p>Kelola data kamar dan reservasi hotel dari halaman khusus ini.</p>
                </div>
                <a href="{{ route('rooms.create') }}" class="admin-add-btn">+ Tambah Kamar</a>
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
                    <h3>{{ $rooms->where('status','penuh')->count() }}</h3>
                    <span>Penuh</span>
                </div>
                <div class="admin-card">
                    <h3>{{ $reservations->count() }}</h3>
                    <span>Total Reservasi</span>
                </div>
            </div>

            <div class="section-header" style="margin-top: 40px;">
                <h2>Ringkasan Kamar</h2>
                <p>Daftar kamar saat ini di hotel. Klik detail kamar untuk mengelola setiap entri.</p>
            </div>

            <div class="room-grid" style="grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:24px; margin-top:24px;">
                @foreach($rooms as $room)
                    <div class="room-card">
                        <div class="room-img-container">
                            <a href="{{ route('rooms.show', $room->id) }}">
                                @if($room->foto_kamar)
                                    <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="{{ $room->tipe_kamar }}" class="room-img">
                                @else
                                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" alt="Default Room Image" class="room-img">
                                @endif
                            </a>
                        </div>
                        <div class="room-details">
                            <div class="room-title-row">
                                <h3 class="room-type">{{ $room->tipe_kamar }}</h3>
                                <span class="room-number">No. {{ $room->nomor_kamar }}</span>
                            </div>
                            <p class="room-desc">{{ $room->deskripsi }}</p>
                            <div class="room-footer" style="margin-top: 16px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
                                <span class="room-price">Rp {{ number_format($room->harga_per_malam,0,',','.') }}</span>
                                <a href="{{ route('rooms.show', $room->id) }}" class="room-detail-btn">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection