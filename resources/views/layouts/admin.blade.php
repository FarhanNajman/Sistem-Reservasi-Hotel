<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'N★JM Hotel - Admin Panel')</title>
    
    <!-- Link CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navigation Bar Admin -->
    <nav class="navbar" id="mainNavbar">
        <a href="{{ route('admin.dashboard') }}" class="nav-logo">
            <img src="{{ asset('gambar/logo/logoSudut.png') }}" alt="N★JM Hotel Logo" style="height: 120px; width: 140; object-fit: contain;">
        </a>
        
        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ url('/reservasi_hotel') }}">Beranda</a>
            </li>
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            </li>
            <li class="nav-item {{ Request::is('admin/reservations') ? 'active' : '' }}">
                <a href="{{ route('admin.reservations') }}">Kelola Reservasi</a>
            </li>
            <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
                <a href="{{ route('admin.users') }}">Daftar Pengguna</a>
            </li>
            
            <li class="nav-item" style="color: var(--text-muted); font-weight:500; display:flex; align-items:center; gap:6px;">
                <i data-lucide="shield" style="width:16px; color:var(--primary-color);"></i>
                {{ Auth::user()->username }} <span style="color:#d4af37;">(Admin)</span>
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-btn">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px; min-height: calc(100vh - 80px - 320px);">
        @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col footer-about">
                <h3>N★JM Hotel (Admin)</h3>
                <p>Halaman ini dikhususkan untuk administrator mengelola data hotel.</p>
                <p><i data-lucide="map-pin" style="display:inline; width:16px; margin-right:5px; vertical-align:middle;"></i> Jl. Kapalo Koto, Pauh, Padang</p>
            </div>
            
            <div class="footer-col footer-contact">
                <h3>Hubungi Kami</h3>
                <p><i data-lucide="phone" style="width:16px;"></i> +6281372747968</p>
                <p><i data-lucide="mail" style="width:16px;"></i> NajmHotelRacing@gmail.com</p>
                <p><i data-lucide="clock" style="width:16px;"></i> Resepsionis 24 Jam</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} N★JM Hotel - Hak Akses Administrator.</p>
        </div>
    </footer>

    <!-- Flash Messages (Toasts) -->
    @if(session('success'))
        <div class="alert-toast alert-success" id="successToast">
            <i data-lucide="check-circle" style="color: #10b981; width: 20px; height: 20px;"></i>
            <p>{{ session('success') }}</p>
            <button class="close-toast" onclick="document.getElementById('successToast').remove()"><i data-lucide="x" style="width: 16px; height: 16px;"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-toast alert-error" id="errorToast">
            <i data-lucide="alert-circle" style="color: #ef4444; width: 20px; height: 20px;"></i>
            <p>{{ session('error') }}</p>
            <button class="close-toast" onclick="document.getElementById('errorToast').remove()"><i data-lucide="x" style="width: 16px; height: 16px;"></i></button>
        </div>
    @endif

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();

        // Efek navbar mengecil saat scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Auto close toasts setelah 4 detik
        setTimeout(function() {
            const successToast = document.getElementById('successToast');
            if (successToast) {
                successToast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                successToast.style.opacity = '0';
                successToast.style.transform = 'translateY(20px)';
                setTimeout(() => successToast.remove(), 500);
            }
            
            const errorToast = document.getElementById('errorToast');
            if (errorToast) {
                errorToast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                errorToast.style.opacity = '0';
                errorToast.style.transform = 'translateY(20px)';
                setTimeout(() => errorToast.remove(), 500);
            }
        }, 4000);
    </script>
    @yield('scripts')
</body>
</html>
