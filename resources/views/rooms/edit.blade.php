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

        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
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
                    <option value="perbaikan" {{ old('status', $room->status) == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $room->deskripsi) }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('rooms.show', $room->id) }}" class="btn-link" style="margin-left:12px;">Batal</a>
        </form>
    </div>
</div>
@endsection
