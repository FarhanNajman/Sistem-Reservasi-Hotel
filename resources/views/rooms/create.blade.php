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
                <label for="lantai">Lantai</label>
                <select name="lantai" id="lantai" required>
                    <option value="1" {{ old('lantai') == '1' ? 'selected' : '' }}>Lantai 1</option>
                    <option value="2" {{ old('lantai') == '2' ? 'selected' : '' }}>Lantai 2</option>
                    <option value="3" {{ old('lantai') == '3' ? 'selected' : '' }}>Lantai 3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nomor_kamar">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar') }}" placeholder="Contoh: 05" required>
                <p style="margin-top: 6px; color: #6b7280; font-size: 0.95rem;">Nomor kamar akan otomatis diawali dengan angka lantai yang dipilih, misalnya lantai 2 menjadi 205.</p>
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
                <div class="file-upload-wrapper">
                    <label for="foto_kamar_upload" class="file-upload-button" title="Pilih gambar">
                        <svg viewBox="0 0 24 24" aria-hidden="true" role="img">
                            <path fill="#0f172a" d="M5 20h14a2 2 0 002-2v-7h-2v7H5v-7H3v7a2 2 0 002 2Zm11-10l-3-3-3 3h2v4h2v-4h2Zm-6-6h6V2H10a2 2 0 0 0-2 2v4h2V4Zm8 3V4h1.5L17 7ZM9 7V4H7.5L9 7Z"/>
                        </svg>
                    </label>
                    <span class="file-upload-name" id="fotoKamarFileName">Tidak ada file dipilih</span>
                    <button type="button" class="file-upload-clear" id="clearFotoKamarCreate" title="Batal pilih gambar">×</button>
                    <input type="file" name="foto_kamar_upload" id="foto_kamar_upload" accept="image/*">
                </div>
            </div>

            <div class="preview-image-wrapper hidden">
                <img src="" id="previewImage" alt="Preview Foto Kamar">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kamar</label>
                <textarea name="deskripsi" id="deskripsi" rows="6" placeholder="Tuliskan fitur utama kamar, suasana, dan pengalaman tamu. Contoh: 'Kamar Deluxe dengan balkon, AC, Wi-Fi cepat, dan pemandangan kota yang menawan.'">{{ old('deskripsi') }}</textarea>
                <p style="margin-top: 6px; color: #6b7280; font-size: 0.95rem;">Ceritakan keunggulan kamar dalam 2-3 kalimat agar tamu mudah membayangkan penginapan.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Tambah Kamar</button>
                <a href="{{ url('/reservasi_hotel') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    const createFileInput = document.getElementById('foto_kamar_upload');
    const createFileNameDisplay = document.getElementById('fotoKamarFileName');
    const createPreviewImage = document.getElementById('previewImage');
    const createPreviewWrapper = document.querySelector('.preview-image-wrapper');
    const createClearButton = document.getElementById('clearFotoKamarCreate');

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
            clearUploadSelection(createFileInput, createPreviewWrapper, createPreviewImage, createFileNameDisplay);
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

    if (createFileInput && createFileNameDisplay && createPreviewImage && createPreviewWrapper) {
        createFileInput.addEventListener('change', function (event) {
            previewUpload(event, createPreviewImage, createFileNameDisplay, createPreviewWrapper);
        });
    }

    if (createClearButton) {
        createClearButton.addEventListener('click', function () {
            clearUploadSelection(createFileInput, createPreviewWrapper, createPreviewImage, createFileNameDisplay);
        });
    }
</script>
@endsection
