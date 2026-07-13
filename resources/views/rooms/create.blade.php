@extends('layouts.admin')

@section('title', 'Tambah Kamar - N★JM Hotel')

@section('content')
<div>
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
                <select name="tipe_kamar" id="tipe_kamar" required>
                    <option value="" disabled selected>Pilih Tipe Kamar</option>
                    <option value="Standard Room" {{ old('tipe_kamar') == 'Standard Room' ? 'selected' : '' }}>Standard Room</option>
                    <option value="Deluxe Room" {{ old('tipe_kamar') == 'Deluxe Room' ? 'selected' : '' }}>Deluxe Room</option>
                    <option value="VIP Room" {{ old('tipe_kamar') == 'VIP Room' ? 'selected' : '' }}>VIP Room</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lantai">Lantai</label>
                <select name="lantai" id="lantai" required>
                    <option value="" disabled selected>Pilih Lantai</option>
                    <option value="1" {{ old('lantai') == '1' ? 'selected' : '' }}>Lantai 1</option>
                    <option value="2" {{ old('lantai') == '2' ? 'selected' : '' }}>Lantai 2</option>
                    <option value="3" {{ old('lantai') == '3' ? 'selected' : '' }}>Lantai 3</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nomor_kamar">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" id="nomor_kamar" value="{{ old('nomor_kamar') }}" inputmode="numeric" pattern="[0-9]{1,2}" maxlength="2" placeholder="" required>
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
                <label for="denah_kamar_upload">Unggah Gambar Denah Kamar</label>
                <div class="file-upload-wrapper">
                    <label for="denah_kamar_upload" class="file-upload-button" title="Pilih gambar denah">
                        <svg viewBox="0 0 24 24" aria-hidden="true" role="img">
                            <path fill="#0f172a" d="M5 20h14a2 2 0 002-2v-7h-2v7H5v-7H3v7a2 2 0 002 2Zm11-10l-3-3-3 3h2v4h2v-4h2Zm-6-6h6V2H10a2 2 0 0 0-2 2v4h2V4Zm8 3V4h1.5L17 7ZM9 7V4H7.5L9 7Z"/>
                        </svg>
                    </label>
                    <span class="file-upload-name" id="denahKamarFileName">Tidak ada file dipilih</span>
                    <button type="button" class="file-upload-clear" id="clearDenahKamarCreate" title="Batal pilih gambar denah">×</button>
                    <input type="file" name="denah_kamar_upload" id="denah_kamar_upload" accept="image/*">
                </div>
            </div>

            <div class="preview-image-wrapper hidden" id="denahPreviewWrapper">
                <img src="" id="denahPreviewImage" alt="Preview Denah Kamar">
            </div>

            <div class="form-group">
                <label>Fasilitas Kamar</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="WiFi Gratis" {{ in_array('WiFi Gratis', old('fasilitas', [])) ? 'checked' : '' }}> WiFi Gratis</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="AC" {{ in_array('AC', old('fasilitas', [])) ? 'checked' : '' }}> AC</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="TV Kabel" {{ in_array('TV Kabel', old('fasilitas', [])) ? 'checked' : '' }}> TV Kabel</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Kamar Mandi Dalam" {{ in_array('Kamar Mandi Dalam', old('fasilitas', [])) ? 'checked' : '' }}> Kamar Mandi Dalam</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Sarapan Pagi" {{ in_array('Sarapan Pagi', old('fasilitas', [])) ? 'checked' : '' }}> Sarapan Pagi</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Layanan Kamar 24 Jam" {{ in_array('Layanan Kamar 24 Jam', old('fasilitas', [])) ? 'checked' : '' }}> Layanan Kamar 24 Jam</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Kulkas Mini" {{ in_array('Kulkas Mini', old('fasilitas', [])) ? 'checked' : '' }}> Kulkas Mini</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Pembuat Kopi/Teh" {{ in_array('Pembuat Kopi/Teh', old('fasilitas', [])) ? 'checked' : '' }}> Pembuat Kopi/Teh</label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; text-transform: none; color: var(--text-dark);"><input type="checkbox" name="fasilitas[]" value="Brankas" {{ in_array('Brankas', old('fasilitas', [])) ? 'checked' : '' }}> Brankas</label>
                </div>
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
    const denahFileInput = document.getElementById('denah_kamar_upload');
    const denahFileNameDisplay = document.getElementById('denahKamarFileName');
    const denahPreviewImage = document.getElementById('denahPreviewImage');
    const denahPreviewWrapper = document.getElementById('denahPreviewWrapper');
    const denahClearButton = document.getElementById('clearDenahKamarCreate');

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
