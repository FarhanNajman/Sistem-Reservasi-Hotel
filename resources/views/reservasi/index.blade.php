@extends('layouts.app')

@section('title', 'Reservasi Saya - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Reservasi Saya</h2>
        <p>Kelola dan lihat riwayat pemesanan kamar Anda di N★JM Hotel.</p>
    </div>

    <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); max-width: 1000px; margin: 0 auto;">
        @if($reservations->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                <i data-lucide="bed" style="width: 48px; height: 48px; margin-bottom: 16px;"></i>
                <h3>Anda Belum Memiliki Reservasi</h3>
                <p style="margin-bottom: 20px;">Silakan jelajahi daftar kamar kami dan mulai pengalaman menginap Anda.</p>
                <a href="{{ url('/reservasi_hotel') }}" class="nav-btn" style="text-decoration: none; padding: 10px 20px;">Lihat Kamar</a>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Kode Booking</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Kamar</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Check-in / Check-out</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Total Harga</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background-color 0.2s;">
                            <td style="padding: 12px 16px; font-weight: 600; color: var(--primary-color);">{{ $res->kode_booking }}</td>
                            <td style="padding: 12px 16px;">
                                <div style="font-weight: 500;">No. {{ $res->room->nomor_kamar ?? '-' }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $res->room->tipe_kamar ?? '-' }}</div>
                            </td>
                            <td style="padding: 12px 16px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i data-lucide="log-in" style="width: 14px; height: 14px; color: #10b981;"></i>
                                    {{ \Carbon\Carbon::parse($res->tanggal_check_in)->format('d M Y') }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                                    <i data-lucide="log-out" style="width: 14px; height: 14px; color: #ef4444;"></i>
                                    {{ \Carbon\Carbon::parse($res->tanggal_check_out)->format('d M Y') }}
                                </div>
                            </td>
                            <td style="padding: 12px 16px; font-weight: 600;">
                                Rp {{ number_format($res->total_harga, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 16px;">
                                @if($res->status === 'pending')
                                    <div style="display:inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; background-color: #fef08a; color: #854d0e; border: 1px solid #fde047;">
                                        <i data-lucide="clock" style="width: 14px; height: 14px;"></i> Menunggu Pembayaran
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;">Silakan selesaikan pembayaran.</div>
                                @elseif($res->status === 'dikonfirmasi')
                                    <div style="display:inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; background-color: #bbf7d0; color: #166534; border: 1px solid #86efac;">
                                        <i data-lucide="check-circle-2" style="width: 14px; height: 14px;"></i> Dikonfirmasi
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;">Siap untuk Check-in.</div>
                                @else
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #e2e8f0; color: #475569;">{{ ucfirst($res->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
