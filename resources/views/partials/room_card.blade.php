<div class="room-card">
    <div class="room-img-container">
        <a href="{{ route('rooms.show', $room->id) }}">
            @if($room->foto_kamar)
                <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="{{ $room->tipe_kamar }}" class="room-img">
            @else
                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" alt="Default Room Image" class="room-img">
            @endif
        </a>

        @if($room->status === 'tersedia')
            <span class="room-badge tersedia">Tersedia</span>
        @elseif($room->status === 'penuh')
            <span class="room-badge penuh">Penuh</span>
        @else
            <span class="room-badge perbaikan">Perbaikan</span>
        @endif
    </div>
    
    <div class="room-details">
        <div class="room-title-row">
            <h3 class="room-type">
                <a href="{{ route('rooms.show', $room->id) }}" class="room-title-link">{{ $room->tipe_kamar }}</a>
            </h3>
            <span class="room-number">Lantai {{ $room->lantai }} • No. {{ $room->nomor_kamar }}</span>
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
            
            <div class="room-actions">
                <a href="{{ route('rooms.show',$room->id) }}" class="room-detail-btn">Detail</a>
            </div>
        </div>
    </div>
</div>
