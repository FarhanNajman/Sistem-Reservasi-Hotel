@extends('layouts.app')

@section('title', $title . ' - N★JM Hotel')

@section('content')
<div class="detail-container" style="padding-top: 40px; padding-bottom: 40px;">
    <div class="section-header">
        <h2>{{ $title }}</h2>
        <p>Jelajahi koleksi kamar kami untuk menemukan pilihan menginap yang paling sesuai dengan kebutuhan Anda.</p>
    </div>

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
@endsection
