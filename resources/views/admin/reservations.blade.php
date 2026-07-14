@extends('layouts.admin')

@section('title', 'Kelola Reservasi - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Daftar Reservasi Tamu</h2>
        <p>Lihat dan kelola semua pemesanan kamar, termasuk konfirmasi pembayaran.</p>
    </div>

    <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; padding: 20px;">
        @if($reservations->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                <i data-lucide="inbox" style="width: 48px; height: 48px; margin-bottom: 16px;"></i>
                <h3>Belum Ada Reservasi</h3>
                <p>Saat ini belum ada tamu yang melakukan pemesanan.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Kode Reservasi</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Nama Tamu</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Kamar</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Check-in / Check-out</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Total Harga</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Status</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background-color 0.2s;">
                            <td style="padding: 12px 16px; font-weight: 500;">{{ $res->kode_booking }}</td>
                            <td style="padding: 12px 16px;">
                                <div>{{ $res->nama_tamu }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $res->telepon_tamu }}</div>
                            </td>
                            <td style="padding: 12px 16px;">
                                <div>No. {{ $res->room->nomor_kamar ?? '-' }}</div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ $res->room->tipe_kamar ?? '-' }}</div>
                            </td>
                            <td style="padding: 12px 16px;">
                                <div>{{ \Carbon\Carbon::parse($res->tanggal_check_in)->format('d M Y') }}</div>
                                <div><small>s/d</small> {{ \Carbon\Carbon::parse($res->tanggal_check_out)->format('d M Y') }}</div>
                            </td>
                            <td style="padding: 12px 16px; font-weight: 600;">
                                Rp {{ number_format($res->total_harga, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 16px;">
                                @if($res->status === 'pending')
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #fef08a; color: #854d0e;">Pending</span>
                                @elseif($res->status === 'dikonfirmasi')
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #bbf7d0; color: #166534;">Dikonfirmasi</span>
                                @else
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #e2e8f0; color: #475569;">{{ ucfirst($res->status) }}</span>
                                @endif
                            </td>
                            <td style="padding: 12px 16px; vertical-align: middle;">
                                <div style="display: flex; flex-direction: column; gap: 6px; align-items: stretch; min-width: 110px; margin: 0 auto;">
                                    @if($res->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $res->bukti_pembayaran)) }}" target="_blank" style="background-color: #3b82f6; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px; width: 100%; box-sizing: border-box;" title="Lihat Bukti">
                                            <i data-lucide="image" style="width: 14px; height: 14px;"></i> Bukti
                                        </a>
                                    @endif
                                    
                                    @if($res->status === 'pending')
                                    <form action="{{ route('admin.reservations.confirm', $res->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; justify-content: center; gap: 4px; width: 100%; box-sizing: border-box;" onclick="return confirm('Konfirmasi pembayaran untuk pesanan ini?');">
                                            <i data-lucide="check" style="width: 14px; height: 14px;"></i> Konfirmasi
                                        </button>
                                    </form>
                                    @elseif(!$res->bukti_pembayaran)
                                    <span style="color: var(--text-muted); font-size: 0.9rem; text-align: center;">-</span>
                                    @endif
                                </div>
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
