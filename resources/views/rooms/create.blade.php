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

        <form action="{{ route('rooms.store') }}" method="POST">
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
                <label for="foto_kamar">URL / Path Foto Kamar</label>
                <input type="text" name="foto_kamar" id="foto_kamar" value="{{ old('foto_kamar') }}">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Tambah Kamar</button>
            <a href="{{ url('/reservasi_hotel') }}" class="btn-link" style="margin-left:12px;">Batal</a>
        </form>
    </div>
</div>
@endsection
