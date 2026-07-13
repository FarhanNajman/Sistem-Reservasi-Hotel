@extends('layouts.app')

@section('title', 'N★JM Hotel - Daftar Akun Baru')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="{{ asset('gambar/logo/logo1.png') }}" alt="Logo Utama">
            <h2>Buat Akun Baru</h2>
            <p>Daftar sekarang untuk memesan kamar dengan lebih mudah</p>
        </div>

        <form action="{{ url('/register') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Pilih username unik" value="{{ old('username') }}" required autofocus>
                    <i data-lucide="user"></i>
                </div>
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" placeholder="contoh@domain.com" value="{{ old('email') }}" required>
                    <i data-lucide="mail"></i>
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    <i data-lucide="lock"></i>
                    <button type="button" class="password-toggle" id="passwordToggle" aria-label="Tampilkan password">
                        <i data-lucide="eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-btn">
                <i data-lucide="user-plus"></i>
                Daftar Sekarang
            </button>
        </form>

        <div class="auth-footer">
            <p>Sudah memiliki akun? <a href="{{ url('/login') }}">Masuk Disini</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');

        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Ubah icon Lucide
            passwordToggle.innerHTML = type === 'text' 
                ? '<i data-lucide="eye-off"></i>' 
                : '<i data-lucide="eye"></i>';
            
            // Re-render icon lucide yang berubah secara dinamis
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
</script>
@endsection
