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
                <span style="color: var(--text-muted);">Kode Reservasi</span>
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
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.1rem; color: var(--text-dark);">Metode Pembayaran</h3>
            
            <form action="{{ route('pembayaran.scan', $reservation->id) }}" method="GET">
                
                <!-- E-Wallet Accordion -->
                <div style="border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 25px; overflow: hidden; background: white;">
                    <!-- Header -->
                    <div id="ewallet-header" style="padding: 15px 20px; display: flex; flex-direction: column; cursor: pointer; user-select: none;" onclick="toggleEwallet()">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="font-weight: 600; color: var(--text-dark); font-size: 1.1rem;">E-wallet</span>
                            <i id="ewallet-chevron" data-lucide="chevron-down" style="width: 24px; height: 24px; color: var(--text-dark); transition: transform 0.3s;"></i>
                        </div>
                        <!-- Collapsed Icons -->
                        <div id="ewallet-icons" style="display: flex; gap: 15px;">
                            <img src="{{ asset('gambar/pembayaran/Gopay.jpg') }}" alt="GoPay" style="width: 40px; height: 40px; border-radius: 8px; object-fit: contain; border: 1px solid #f1f5f9;">
                            <img src="{{ asset('gambar/pembayaran/Dana.jpg') }}" alt="DANA" style="width: 40px; height: 40px; border-radius: 8px; object-fit: contain; border: 1px solid #f1f5f9;">
                            <img src="{{ asset('gambar/pembayaran/shopeePay.jpg') }}" alt="ShopeePay" style="width: 40px; height: 40px; border-radius: 8px; object-fit: contain; border: 1px solid #f1f5f9;">
                        </div>
                    </div>
                    
                    <!-- Expanded Body -->
                    <div id="ewallet-body" style="display: none; padding: 0 20px 10px 20px;">
                        
                        <!-- GoPay -->
                        <label for="gopay" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-top: 1px solid #f1f5f9; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="{{ asset('gambar/pembayaran/Gopay.jpg') }}" alt="GoPay" style="width: 45px; height: 45px; object-fit: contain; border-radius: 8px; border: 1px solid #f1f5f9;">
                                <div>
                                    <span style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 4px;">GoPay</span>
                                    
                                
                                    </span>
                                </div>
                            </div>
                            <input type="radio" id="gopay" name="payment_method" value="gopay" checked style="width: 22px; height: 22px; accent-color: var(--text-dark); cursor: pointer;">
                        </label>

                        <!-- DANA -->
                        <label for="dana" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-top: 1px solid #f1f5f9; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="{{ asset('gambar/pembayaran/Dana.jpg') }}" alt="DANA" style="width: 45px; height: 45px; object-fit: contain; border-radius: 8px; border: 1px solid #f1f5f9;">
                                <div>
                                    <span style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 4px;">DANA</span>
                                    
                                        
                                    </span>
                                </div>
                            </div>
                            <input type="radio" id="dana" name="payment_method" value="dana" style="width: 22px; height: 22px; accent-color: var(--text-dark); cursor: pointer;">
                        </label>

                        <!-- ShopeePay -->
                        <label for="shopeepay" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-top: 1px solid #f1f5f9; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="{{ asset('gambar/pembayaran/shopeePay.jpg') }}" alt="ShopeePay" style="width: 45px; height: 45px; object-fit: contain; border-radius: 8px; border: 1px solid #f1f5f9;">
                                <div>
                                    <span style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 4px;">ShopeePay</span>
                                    
                                </div>
                            </div>
                            <input type="radio" id="shopeepay" name="payment_method" value="shopeepay" style="width: 22px; height: 22px; accent-color: var(--text-dark); cursor: pointer;">
                        </label>
                    </div>
                </div>
                
                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('reservasi.pesan', $reservation->room_id) }}" style="flex: 1; padding: 16px; background-color: #f1f5f9; color: var(--text-dark); text-decoration: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'">
                        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> Kembali
                    </a>
                    <button type="submit" style="flex: 2; padding: 16px; background-color: #0f172a; color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.backgroundColor='#1e293b'" onmouseout="this.style.backgroundColor='#0f172a'">
                        Lanjut ke Pembayaran <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleEwallet() {
        const body = document.getElementById('ewallet-body');
        const chevron = document.getElementById('ewallet-chevron');
        const icons = document.getElementById('ewallet-icons');
        
        if (body.style.display === 'none') {
            body.style.display = 'block';
            chevron.style.transform = 'rotate(180deg)';
            icons.style.display = 'none';
            // Also focus the first radio to make it active visually
            document.getElementById('gopay').checked = true;
        } else {
            body.style.display = 'none';
            chevron.style.transform = 'rotate(0deg)';
            icons.style.display = 'flex';
        }
    }
</script>
@endsection
