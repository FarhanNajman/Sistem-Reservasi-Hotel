@extends('layouts.app')

@section('title', 'Edit Kamar - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Edit Kamar</h2>
        <p>Ubah detail Kamar No. {{ $room->nomor_kamar }}</p>
    </div>

    <div style="background: white; padding: 20px; border-radius: var(--radius-lg);">
        @if ($errors->any())
            <div style="color: red; margin-bottom: 10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="tipe_kamar">Tipe Kamar</label>
                <input type="text" name="tipe_kamar" id="tipe_kamar" value="{{ old('tipe_kamar', $room->tipe_kamar) }}" required>
            </div>

            <div class="form-group">
                <label for="nomor_kamar">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar', $room->nomor_kamar) }}" required>
            </div>

            <div class="form-group">
                <label for="kapasitas">Kapasitas</label>
                <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', $room->kapasitas) }}" required>
            </div>

            <div class="form-group">
                <label for="harga_per_malam">Harga per Malam</label>
                <input type="number" name="harga_per_malam" id="harga_per_malam" value="{{ old('harga_per_malam', $room->harga_per_malam) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="tersedia" {{ old('status', $room->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="penuh" {{ old('status', $room->status) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    <option value="perbaikan" {{ old('status', $room->status) == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto_kamar_upload">Unggah Foto Kamar</label>
                <div class="file-upload-wrapper">
                    <label for="foto_kamar_upload" class="file-upload-button">Pilih File</label>
                    <span class="file-upload-name" id="fotoKamarFileName">Tidak ada file dipilih</span>
                    <input type="file" name="foto_kamar_upload" id="foto_kamar_upload" accept="image/*">
                </div>
            </div>

            @if($room->foto_kamar)
                <div class="form-group">
                    <label>Preview Foto Saat Ini</label>
                    <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="Foto Kamar {{ $room->nomor_kamar }}" style="max-width: 320px; width: 100%; border-radius: 12px; margin-top: 10px; display: block; object-fit: cover;">
                </div>
            @endif

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kamar</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" placeholder="Tuliskan fitur utama kamar, suasana, dan pengalaman tamu. Contoh: 'Kamar Deluxe dengan balkon, AC, Wi-Fi cepat, dan pemandangan kota yang menawan.'">{{ old('deskripsi', $room->deskripsi) }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin-top: 16px;">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('rooms.show', $room->id) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    const fileInput = document.getElementById('foto_kamar_upload');
    const fileNameDisplay = document.getElementById('fotoKamarFileName');

    if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function () {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Tidak ada file dipilih';
            fileNameDisplay.textContent = fileName;
        });
    }
</script>
@endsection
