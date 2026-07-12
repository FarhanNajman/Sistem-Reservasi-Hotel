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
                <input type="file" name="foto_kamar_upload" id="foto_kamar_upload" accept="image/*">
            </div>

            <div class="form-group">
                <label for="foto_kamar">URL / Path Foto Kamar (opsional jika tidak mengunggah)</label>
                <input type="text" name="foto_kamar" id="foto_kamar" value="{{ old('foto_kamar', $room->foto_kamar) }}" placeholder="Contoh: gambar/kamar/vip/vip1.jpg atau https://...">
            </div>

            @if($room->foto_kamar)
                <div class="form-group">
                    <label>Preview Foto Saat Ini</label>
                    <img src="{{ filter_var($room->foto_kamar, FILTER_VALIDATE_URL) ? $room->foto_kamar : asset($room->foto_kamar) }}" alt="Foto Kamar {{ $room->nomor_kamar }}" style="max-width: 100%; border-radius: 12px; margin-top: 10px; display: block;">
                </div>
            @endif

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kamar</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" placeholder="Tuliskan fitur utama kamar, suasana, dan pengalaman tamu. Contoh: 'Kamar Deluxe dengan balkon, AC, Wi-Fi cepat, dan pemandangan kota yang menawan.'">{{ old('deskripsi', $room->deskripsi) }}</textarea>
                <p style="margin-top: 6px; color: #6b7280; font-size: 0.95rem;">Gunakan deskripsi singkat dan menarik agar tamu bisa melihat nilai lebih kamar ini.</p>
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('rooms.show', $room->id) }}" class="btn-link" style="margin-left:12px;">Batal</a>
        </form>
    </div>
</div>
@endsection
