@extends('layouts.app')

@section('title', 'Pesan Kamar - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Formulir Pemesanan Kamar</h2>
        <p>Lengkapi data di bawah ini untuk mengonfirmasi pesanan kamar Anda.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px; align-items: flex-start; max-width: 1000px; margin: 0 auto;">
        
        <!-- Form Section -->
        <div style="background: white; border-radius: var(--radius-lg); padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <form action="{{ route('reservasi.pesan', $room->id) }}" method="POST">
                @csrf
                
                <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--text-dark); border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">Data Pemesan</h3>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Nama Lengkap Tamu <span style="color: red;">*</span></label>
                    <input type="text" name="nama_tamu" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Alamat Email</label>
                    <input type="email" name="email_tamu" value="{{ Auth::user()->email }}" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; background-color: #fff; font-family: inherit; color: var(--text-dark);">
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Nomor Telepon <span style="color: red;"></span></label>
                    <input type="text" name="telepon_tamu" required placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;">
                </div>

                <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem; color: var(--text-dark); border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">Detail Menginap</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Tanggal Check-in <span style="color: red;"></span></label>
                        <input type="date" name="tanggal_check_in" id="checkin_date" required min="{{ date('Y-m-d') }}" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Tanggal Check-out <span style="color: red;"></span></label>
                        <input type="date" name="tanggal_check_out" id="checkout_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Minta kamar di lantai bawah, extra bed, dll." style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; resize: vertical;"></textarea>
                </div>

                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('rooms.show', $room->id) }}" style="flex: 1; padding: 14px; background-color: #f1f5f9; color: var(--text-dark); text-decoration: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; text-align: center; display: inline-block; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='#f1f5f9'">
                        Batal
                    </a>
                    <button type="submit" style="flex: 2; padding: 14px; background-color: #0f172a; color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#1e293b'" onmouseout="this.style.backgroundColor='#0f172a'">
                        Konfirmasi & Lanjutkan Pembayaran
                    </button>
                </div>
            </form>
        </div>

        <!-- Room Summary Section -->
        <div style="background: white; border-radius: var(--radius-lg); padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); position: sticky; top: 100px;">
            <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 1.25rem; color: var(--text-dark);">Kamar Terpilih</h3>
            
            <div style="border-radius: 8px; overflow: hidden; margin-bottom: 15px;">
                @if($room->foto_kamar)
                    <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="{{ $room->tipe_kamar }}" style="width: 100%; height: 180px; object-fit: cover;">
                @else
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" alt="Default Room Image" style="width: 100%; height: 180px; object-fit: cover;">
                @endif
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px;">{{ $room->tipe_kamar }}</div>
                <div style="color: var(--text-muted); font-size: 0.95rem;">Kamar No. {{ $room->nomor_kamar }} | Lantai {{ $room->lantai }}</div>
            </div>

            <div style="padding: 15px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: var(--text-muted);">Harga / Malam</span>
                    <span style="font-weight: 600;" id="hargaPerMalam" data-harga="{{ $room->harga_per_malam }}">Rp {{ number_format($room->harga_per_malam, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: var(--text-muted);">Durasi Menginap</span>
                    <span style="font-weight: 600;" id="displayDurasi">-</span>
                </div>
                <hr style="border: none; border-top: 1px dashed #cbd5e1; margin: 15px 0;">
                <div style="display: flex; justify-content: space-between; font-size: 1.15rem;">
                    <span style="font-weight: 600; color: var(--text-dark);">Total Tagihan</span>
                    <span style="font-weight: 700; color: var(--primary-color);" id="displayTotal">Rp 0</span>
                </div>
            </div>
            
            <div style="font-size: 0.85rem; color: var(--text-muted); text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i> Pemesanan Aman & Terenkripsi
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkinInput = document.getElementById('checkin_date');
        const checkoutInput = document.getElementById('checkout_date');
        const displayDurasi = document.getElementById('displayDurasi');
        const displayTotal = document.getElementById('displayTotal');
        const hargaPerMalam = parseInt(document.getElementById('hargaPerMalam').getAttribute('data-harga'));

        function calculateTotal() {
            if(checkinInput.value && checkoutInput.value) {
                const start = new Date(checkinInput.value);
                const end = new Date(checkoutInput.value);
                
                // Set time to 0 to properly calculate days regardless of timezone differences
                start.setHours(0,0,0,0);
                end.setHours(0,0,0,0);
                
                const timeDiff = end.getTime() - start.getTime();
                let daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                if (daysDiff <= 0) {
                    checkoutInput.value = ''; // Reset invalid date
                    displayDurasi.textContent = '-';
                    displayTotal.textContent = 'Rp 0';
                    alert("Tanggal Check-out harus setelah tanggal Check-in");
                    return;
                }

                displayDurasi.textContent = daysDiff + ' Malam';
                
                const total = daysDiff * hargaPerMalam;
                displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                displayDurasi.textContent = '-';
                displayTotal.textContent = 'Rp 0';
            }
        }

        checkinInput.addEventListener('change', function() {
            // Auto update min attribute for checkout
            if(this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                const dd = String(nextDay.getDate()).padStart(2, '0');
                const mm = String(nextDay.getMonth() + 1).padStart(2, '0');
                const yyyy = nextDay.getFullYear();
                
                checkoutInput.min = yyyy + '-' + mm + '-' + dd;
                
                if (checkoutInput.value && checkoutInput.value <= this.value) {
                    checkoutInput.value = ''; // Reset checkout if it's earlier than or equal to checkin
                }
            }
            calculateTotal();
        });

        checkoutInput.addEventListener('change', calculateTotal);
    });
</script>
@endsection
