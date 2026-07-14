@extends('layouts.app')

@section('title', 'N★JM Hotel - Masuk Ke Akun')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="{{ asset('gambar/logo/logo1.png') }}" alt="Logo Utama">
            <h2>Selamat Datang</h2>
            <p>Silakan masuk untuk melanjutkan reservasi Anda</p>
        </div>

        <form action="{{ url('/login') }}" method="POST" class="auth-form">
            @csrf

            <div class="login-type-toggle" role="tablist" aria-label="Pilih tipe login">
                <button type="button" class="login-type-btn {{ old('login_type', 'user') === 'user' ? 'active' : '' }}" data-login-type="user">
                    <i data-lucide="user-circle"></i>
                    User
                </button>
                <button type="button" class="login-type-btn {{ old('login_type') === 'admin' ? 'active' : '' }}" data-login-type="admin">
                    <i data-lucide="shield-check"></i>
                    Admin
                </button>
                <input type="hidden" name="login_type" id="login_type" value="{{ old('login_type', 'user') }}">
            </div>
            @error('login_type')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Masukkan username Anda" value="{{ old('username') }}" required autofocus>
                    <i data-lucide="user"></i>
                </div>
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
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
                <i data-lucide="log-in"></i>
                Masuk
            </button>
        </form>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ url('/register') }}">Daftar Sekarang</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');
        const loginTypeInput = document.getElementById('login_type');
        const loginTypeButtons = document.querySelectorAll('.login-type-btn');

        loginTypeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const selectedType = this.getAttribute('data-login-type');

                loginTypeButtons.forEach(function(btn) {
                    btn.classList.toggle('active', btn === button);
                });

                if (loginTypeInput) {
                    loginTypeInput.value = selectedType;
                }
            });
        });

        if (passwordToggle) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                passwordToggle.innerHTML = type === 'text' 
                    ? '<i data-lucide="eye-off"></i>' 
                    : '<i data-lucide="eye"></i>';

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        }
    });
</script>
@endsection
