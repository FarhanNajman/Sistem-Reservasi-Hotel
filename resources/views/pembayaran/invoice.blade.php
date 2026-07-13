@extends('layouts.app')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 700px; margin: 0 auto;">
    
    @if (session('success'))
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <p style="margin: 0; color: #15803d; font-weight: 500;">{{ session('success') }}</p>
        </div>
    @endif

    <div style="background: white; border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        
        <!-- Header Invoice -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0; color: var(--primary-color); font-size: 2rem;">INVOICE</h1>
                <p style="margin: 5px 0 0 0; color: var(--text-muted);">#{{ $reservation->kode_booking }}</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Status Pembayaran:</p>
                @if($reservation->status === 'pending')
                    <span style="display: inline-block; margin-top: 8px; padding: 6px 16px; background-color: #fef08a; color: #854d0e; font-weight: 700; border-radius: 20px; font-size: 0.95rem;">
                        <i data-lucide="clock" style="width: 16px; height: 16px; display: inline-block; vertical-align: text-bottom; margin-right: 4px;"></i> PENDING
                    </span>
                @elseif($reservation->status === 'dikonfirmasi' || $reservation->status === 'check_in' || $reservation->status === 'check_out')
                    <span style="display: inline-block; margin-top: 8px; padding: 6px 16px; background-color: #bbf7d0; color: #166534; font-weight: 700; border-radius: 20px; font-size: 0.95rem;">
                        <i data-lucide="check-circle" style="width: 16px; height: 16px; display: inline-block; vertical-align: text-bottom; margin-right: 4px;"></i> LUNAS
                    </span>
                @else
                    <span style="display: inline-block; margin-top: 8px; padding: 6px 16px; background-color: #e2e8f0; color: #475569; font-weight: 700; border-radius: 20px; font-size: 0.95rem;">
                        {{ strtoupper($reservation->status) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Detail Pemesan -->
        <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-bottom: 35px;">
            <div style="flex: 1; min-width: 200px;">
                <h3 style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Ditagihkan Kepada</h3>
                <p style="margin: 0 0 5px 0; font-weight: 600; color: var(--text-dark); font-size: 1.1rem;">{{ $reservation->nama_tamu }}</p>
                <p style="margin: 0 0 5px 0; color: var(--text-dark);">{{ $reservation->email_tamu }}</p>
                <p style="margin: 0; color: var(--text-dark);">{{ $reservation->telepon_tamu }}</p>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <h3 style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Detail Reservasi</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px 0; color: var(--text-muted);">Check-in</td>
                        <td style="padding: 4px 0; text-align: right; font-weight: 500; color: var(--text-dark);">{{ \Carbon\Carbon::parse($reservation->tanggal_check_in)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: var(--text-muted);">Check-out</td>
                        <td style="padding: 4px 0; text-align: right; font-weight: 500; color: var(--text-dark);">{{ \Carbon\Carbon::parse($reservation->tanggal_check_out)->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabel Rincian -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 15px; text-align: left; font-weight: 600; color: var(--text-dark);">Deskripsi Kamar</th>
                    <th style="padding: 15px; text-align: right; font-weight: 600; color: var(--text-dark);">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 15px; color: var(--text-dark);">
                        <div style="font-weight: 600;">Kamar Tipe {{ $reservation->room->tipe_kamar }}</div>
                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 4px;">Lantai {{ $reservation->room->lantai }} - No. {{ $reservation->room->nomor_kamar }}</div>
                        @php
                            $checkIn = \Carbon\Carbon::parse($reservation->tanggal_check_in);
                            $checkOut = \Carbon\Carbon::parse($reservation->tanggal_check_out);
                            $hari = $checkIn->diffInDays($checkOut);
                        @endphp
                        <div style="font-size: 0.9rem; color: var(--text-muted); margin-top: 2px;">Durasi: {{ $hari }} Malam</div>
                    </td>
                    <td style="padding: 15px; text-align: right; font-weight: 500; color: var(--text-dark);">
                        Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td style="padding: 20px 15px; text-align: right; font-weight: 600; color: var(--text-dark); font-size: 1.1rem;">Total Tagihan</td>
                    <td style="padding: 20px 15px; text-align: right; font-weight: 700; color: var(--primary-color); font-size: 1.4rem;">
                        Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Tombol Aksi -->
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('reservasi.saya') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 30px; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.3s;" onmouseover="this.style.backgroundColor='var(--primary-dark)'" onmouseout="this.style.backgroundColor='var(--primary-color)'">
                Cek Semua Reservasi Saya <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </a>
            
            @if($reservation->status === 'pending')
            <p style="margin-top: 15px; font-size: 0.9rem; color: var(--text-muted);">
                * Mohon tunggu admin untuk memverifikasi bukti pembayaran Anda. Invoice ini akan otomatis berstatus LUNAS jika disetujui.
            </p>
            @endif
        </div>
    </div>
</div>
@endsection
