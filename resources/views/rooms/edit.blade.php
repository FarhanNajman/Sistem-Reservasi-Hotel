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
                <select name="tipe_kamar" id="tipe_kamar" required>
                    <option value="" disabled selected>Pilih Tipe Kamar</option>
                    <option value="Standard Room" {{ old('tipe_kamar', $room->tipe_kamar) == 'Standard Room' ? 'selected' : '' }}>Standard Room</option>
                    <option value="Deluxe Room" {{ old('tipe_kamar', $room->tipe_kamar) == 'Deluxe Room' ? 'selected' : '' }}>Deluxe Room</option>
                    <option value="VIP Room" {{ old('tipe_kamar', $room->tipe_kamar) == 'VIP Room' ? 'selected' : '' }}>VIP Room</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lantai">Lantai</label>
                <select name="lantai" id="lantai" required>
                    <option value="" disabled selected>Pilih Lantai</option>
                    <option value="1" {{ old('lantai', $room->lantai) == '1' ? 'selected' : '' }}>Lantai 1</option>
                    <option value="2" {{ old('lantai', $room->lantai) == '2' ? 'selected' : '' }}>Lantai 2</option>
                    <option value="3" {{ old('lantai', $room->lantai) == '3' ? 'selected' : '' }}>Lantai 3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nomor_kamar">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar', $room->nomor_kamar) }}" inputmode="numeric" pattern="[0-9]{1,2}" maxlength="2" placeholder="Contoh: 05" required>
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
                    <label for="foto_kamar_upload" class="file-upload-button" title="Pilih gambar">
                        <svg viewBox="0 0 24 24" aria-hidden="true" role="img">
                            <path fill="#0f172a" d="M5 20h14a2 2 0 002-2v-7h-2v7H5v-7H3v7a2 2 0 002 2Zm11-10l-3-3-3 3h2v4h2v-4h2Zm-6-6h6V2H10a2 2 0 0 0-2 2v4h2V4Zm8 3V4h1.5L17 7ZM9 7V4H7.5L9 7Z"/>
                        </svg>
                    </label>
                    <span class="file-upload-name" id="fotoKamarFileName">Tidak ada file dipilih</span>
                    <button type="button" class="file-upload-clear" id="clearFotoKamarEdit" title="Batal pilih gambar">×</button>
                    <input type="file" name="foto_kamar_upload" id="foto_kamar_upload" accept="image/*">
                </div>
            </div>

            <div class="preview-image-wrapper hidden">
                <img src="" id="previewImage" alt="Preview Foto Kamar">
            </div>

            <div class="form-group">
                <label for="denah_kamar_upload">Unggah Gambar Denah Kamar</label>
                <div class="file-upload-wrapper">
                    <label for="denah_kamar_upload" class="file-upload-button" title="Pilih gambar denah">
                        <svg viewBox="0 0 24 24" aria-hidden="true" role="img">
                            <path fill="#0f172a" d="M5 20h14a2 2 0 002-2v-7h-2v7H5v-7H3v7a2 2 0 002 2Zm11-10l-3-3-3 3h2v4h2v-4h2Zm-6-6h6V2H10a2 2 0 0 0-2 2v4h2V4Zm8 3V4h1.5L17 7ZM9 7V4H7.5L9 7Z"/>
                        </svg>
                    </label>
                    <span class="file-upload-name" id="denahKamarFileName">Tidak ada file dipilih</span>
                    <button type="button" class="file-upload-clear" id="clearDenahKamarEdit" title="Batal pilih gambar denah">×</button>
                    <input type="file" name="denah_kamar_upload" id="denah_kamar_upload" accept="image/*">
                </div>
            </div>

            <div class="preview-image-wrapper hidden" id="denahPreviewWrapper">
                <img src="" id="denahPreviewImage" alt="Preview Denah Kamar">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kamar</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" placeholder="Tuliskan fitur utama kamar, suasana, dan pengalaman tamu. Contoh: 'Kamar Deluxe dengan balkon, AC, Wi-Fi cepat, dan pemandangan kota yang menawan.'">{{ old('deskripsi', $room->deskripsi) }}</textarea>
            </div>

            <div class="form-actions">
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
    const previewImage = document.getElementById('previewImage');
    const previewWrapper = document.querySelector('.preview-image-wrapper');
    const clearButton = document.getElementById('clearFotoKamarEdit');
    const denahFileInput = document.getElementById('denah_kamar_upload');
    const denahFileNameDisplay = document.getElementById('denahKamarFileName');
    const denahPreviewImage = document.getElementById('denahPreviewImage');
    const denahPreviewWrapper = document.getElementById('denahPreviewWrapper');
    const denahClearButton = document.getElementById('clearDenahKamarEdit');

    function previewUpload(event, previewImage, fileNameDisplay, previewWrapper) {
        const file = event.target.files[0];
        if (!previewImage || !fileNameDisplay || !previewWrapper) return;

        if (file) {
            fileNameDisplay.textContent = file.name;
            previewImage.src = URL.createObjectURL(file);
            previewWrapper.classList.remove('hidden');
            previewWrapper.classList.add('active');
            previewImage.style.display = 'block';
        } else {
            clearUploadSelection(fileInput, previewWrapper, previewImage, fileNameDisplay);
        }
    }

    function clearUploadSelection(fileInput, previewWrapper, previewImage, fileNameDisplay) {
        if (fileInput) fileInput.value = '';
        if (fileNameDisplay) fileNameDisplay.textContent = 'Tidak ada file dipilih';
        if (previewImage) {
            previewImage.src = '';
            previewImage.style.display = 'none';
        }
        if (previewWrapper) {
            previewWrapper.classList.add('hidden');
            previewWrapper.classList.remove('active');
        }
    }

    if (fileInput && fileNameDisplay && previewImage && previewWrapper) {
        fileInput.addEventListener('change', function (event) {
            previewUpload(event, previewImage, fileNameDisplay, previewWrapper);
        });
    }

    if (clearButton) {
        clearButton.addEventListener('click', function () {
            clearUploadSelection(fileInput, previewWrapper, previewImage, fileNameDisplay);
        });
    }

    if (denahFileInput && denahFileNameDisplay && denahPreviewImage && denahPreviewWrapper) {
        denahFileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                denahFileNameDisplay.textContent = 'Tidak ada file dipilih';
                denahPreviewImage.src = '';
                denahPreviewImage.style.display = 'none';
                denahPreviewWrapper.classList.add('hidden');
                denahPreviewWrapper.classList.remove('active');
                return;
            }

            denahFileNameDisplay.textContent = file.name;
            denahPreviewImage.src = URL.createObjectURL(file);
            denahPreviewWrapper.classList.remove('hidden');
            denahPreviewWrapper.classList.add('active');
            denahPreviewImage.style.display = 'block';
        });
    }

    if (denahClearButton) {
        denahClearButton.addEventListener('click', function () {
            if (denahFileInput) denahFileInput.value = '';
            if (denahFileNameDisplay) denahFileNameDisplay.textContent = 'Tidak ada file dipilih';
            if (denahPreviewImage) {
                denahPreviewImage.src = '';
                denahPreviewImage.style.display = 'none';
            }
            if (denahPreviewWrapper) {
                denahPreviewWrapper.classList.add('hidden');
                denahPreviewWrapper.classList.remove('active');
            }
        });
    }
</script>
@endsection
