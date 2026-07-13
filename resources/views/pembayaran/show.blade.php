@extends('layouts.app')

@section('title', 'Pembayaran - N★JM Hotel')

@section('content')
<div class="detail-container" style="padding-top: 40px; padding-bottom: 40px;">
    <div style="max-width: 600px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 64px; height: 64px; background-color: rgba(212, 175, 55, 0.1); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <i data-lucide="credit-card" style="width: 32px; height: 32px; color: var(--primary-color);"></i>
            </div>
            <h2 style="margin-top: 0; color: var(--text-dark);">Selesaikan Pembayaran</h2>
            <p style="color: var(--text-muted);">Selesaikan pembayaran untuk mengonfirmasi reservasi Anda.</p>
        </div>

        <div style="background: white; border-radius: var(--radius-lg); padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
            
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.1rem; color: var(--text-dark); border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">Ringkasan Pesanan</h3>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="color: var(--text-muted);">Kode Booking</span>
                <span style="font-weight: 600; color: var(--text-dark);">{{ $reservation->kode_booking }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="color: var(--text-muted);">Tipe Kamar</span>
                <span style="font-weight: 600; color: var(--text-dark);">{{ $reservation->room->tipe_kamar }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="color: var(--text-muted);">Check-in</span>
                <span style="font-weight: 500; color: var(--text-dark);">{{ \Carbon\Carbon::parse($reservation->tanggal_check_in)->format('d M Y') }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="color: var(--text-muted);">Check-out</span>
                <span style="font-weight: 500; color: var(--text-dark);">{{ \Carbon\Carbon::parse($reservation->tanggal_check_out)->format('d M Y') }}</span>
            </div>

            <hr style="border: none; border-top: 1px dashed #cbd5e1; margin: 20px 0;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                <span style="color: var(--text-dark); font-weight: 500; font-size: 1.1rem;">Total Pembayaran</span>
                <span style="font-weight: 700; color: var(--primary-color); font-size: 1.5rem;">Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div style="background: white; border-radius: var(--radius-lg); padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.1rem; color: var(--text-dark);">Metode Pembayaran (Simulasi)</h3>
            
            <form action="{{ route('pembayaran.proses', $reservation->id) }}" method="POST">
                @csrf
                
                <div style="border: 1px solid var(--primary-color); border-radius: 8px; padding: 15px; margin-bottom: 20px; background-color: rgba(212, 175, 55, 0.05); display: flex; align-items: center; cursor: pointer;">
                    <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" checked style="margin-right: 15px; width: 18px; height: 18px;">
                    <label for="bank_transfer" style="flex: 1; cursor: pointer;">
                        <span style="display: block; font-weight: 600; color: var(--text-dark);">Transfer Bank (Virtual Account)</span>
                        <span style="display: block; font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Instan dan otomatis diverifikasi</span>
                    </label>
                    <i data-lucide="building-2" style="color: var(--primary-color);"></i>
                </div>
                
                <button type="submit" style="width: 100%; padding: 16px; background-color: #0f172a; color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.backgroundColor='#1e293b'" onmouseout="this.style.backgroundColor='#0f172a'">
                    Bayar Sekarang <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
