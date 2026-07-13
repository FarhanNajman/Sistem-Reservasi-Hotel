@extends('layouts.app')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 600px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: var(--text-dark); margin-bottom: 10px; font-size: 1.8rem;">Selesaikan Pembayaran</h2>
        <p style="color: var(--text-muted); font-size: 1.05rem;">Silakan scan QR Code di bawah ini menggunakan aplikasi {{ ucfirst($paymentMethod) }} Anda untuk menyelesaikan pembayaran sebesar <strong>Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</strong>.</p>
    </div>

    @if ($errors->any())
        <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
            <ul style="margin: 0; padding-left: 20px; color: #b91c1c;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: white; border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; margin-bottom: 30px;">
        @php
            $qrImages = [
                'gopay' => 'QR_GoPay.jpeg',
                'dana' => 'QR_Dana.jpeg',
                'shopeepay' => 'QR_ShopeePay.jpeg',
            ];
            $qrFileName = $qrImages[strtolower($paymentMethod)] ?? 'QR_GoPay.jpeg';
        @endphp
        <!-- QR Code Image -->
        <div style="margin-bottom: 25px;">
            <img src="{{ asset('gambar/pembayaran/QR/' . $qrFileName) }}" alt="QR Code {{ ucfirst($paymentMethod) }}" style="width: 250px; height: 250px; object-fit: cover; border: 1px solid #e2e8f0; border-radius: 12px; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        </div>
        
        <p style="font-weight: 500; color: var(--text-dark); margin-bottom: 5px;">Kode Reservasi: {{ $reservation->kode_booking }}</p>
        
        <hr style="border: none; border-top: 1px dashed #cbd5e1; margin: 30px 0;">

        <!-- Upload Form -->
        <form action="{{ route('pembayaran.konfirmasi', $reservation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="text-align: left; margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 10px;">Upload Bukti Pembayaran</label>
                <label for="bukti_pembayaran" style="display: block; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 35px 20px; text-align: center; background-color: #f8fafc; cursor: pointer; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.backgroundColor='#f1f5f9';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.backgroundColor='#f8fafc';">
                    <i data-lucide="upload-cloud" style="width: 48px; height: 48px; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <div style="font-weight: 500; color: var(--text-dark); margin-bottom: 5px; font-size: 1.1rem;">Klik untuk memilih file bukti transfer</div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 15px;">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                    <div id="file-name" style="font-weight: 600; color: var(--primary-color); font-size: 0.95rem; background: #e2e8f0; padding: 8px; border-radius: 6px; display: none; width: fit-content; margin: 0 auto;"></div>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" required style="display: none;" onchange="var name = this.files[0] ? this.files[0].name : ''; var el = document.getElementById('file-name'); if(name) { el.textContent = name; el.style.display = 'block'; } else { el.style.display = 'none'; }">
                </label>
            </div>

            <div style="display: flex; gap: 15px;">
                <a href="{{ route('pembayaran.show', $reservation->id) }}" style="flex: 1; padding: 16px; background-color: #f1f5f9; color: var(--text-dark); text-decoration: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> Kembali
                </a>
                <button type="submit" style="flex: 2; padding: 16px; background-color: #0f172a; color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.backgroundColor='#1e293b'" onmouseout="this.style.backgroundColor='#0f172a'">
                    Konfirmasi Pembayaran <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
