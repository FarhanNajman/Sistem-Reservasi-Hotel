@extends('layouts.app')

@section('title', 'Tambah Kamar - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Tambah Kamar Baru</h2>
        <p>Tambahkan data kamar baru ke sistem hotel.</p>
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

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="tipe_kamar">Tipe Kamar</label>
                <input type="text" name="tipe_kamar" id="tipe_kamar" value="{{ old('tipe_kamar') }}" required>
            </div>

            <div class="form-group">
                <label for="nomor_kamar">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar') }}" required>
            </div>

            <div class="form-group">
                <label for="kapasitas">Kapasitas</label>
                <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas') }}" required>
            </div>

            <div class="form-group">
                <label for="harga_per_malam">Harga per Malam</label>
                <input type="number" name="harga_per_malam" id="harga_per_malam" value="{{ old('harga_per_malam') }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="penuh" {{ old('status') == 'penuh' ? 'selected' : '' }}>Penuh</option>
                    <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto_kamar_upload">Unggah Foto Kamar</label>
                <input type="file" name="foto_kamar_upload" id="foto_kamar_upload" accept="image/*">
            </div>

            <div class="form-group">
                <label for="foto_kamar">URL / Path Foto Kamar (opsional jika tidak mengunggah)</label>
                <input type="text" name="foto_kamar" id="foto_kamar" value="{{ old('foto_kamar') }}" placeholder="Contoh: gambar/kamar/standard/standard1.jpg atau https://...">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kamar</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" placeholder="Tuliskan fitur utama kamar, suasana, dan pengalaman tamu. Contoh: 'Kamar Deluxe dengan balkon, AC, Wi-Fi cepat, dan pemandangan kota yang menawan.'">{{ old('deskripsi') }}</textarea>
                <p style="margin-top: 6px; color: #6b7280; font-size: 0.95rem;">Ceritakan keunggulan kamar dalam 2-3 kalimat agar tamu mudah membayangkan penginapan.</p>
            </div>

            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin-top: 16px;">
                <button type="submit" class="btn-primary">Tambah Kamar</button>
                <a href="{{ url('/reservasi_hotel') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
