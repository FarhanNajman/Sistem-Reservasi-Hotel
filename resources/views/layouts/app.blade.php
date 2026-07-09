<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Pemesanan Kamar Hotel Online Premium di N★JM Hotel. Dapatkan kenyamanan terbaik dengan harga bersahabat.">
    <title>@yield('title', 'N★JM Hotel - Pemesanan Kamar Hotel Online')</title>
    
    <!-- Link CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar" id="mainNavbar">
        <a href="{{ url('/') }}" class="nav-logo">
            <img src="{{ asset('gambar/logo/logoSudut.png') }}" alt="N★JM Hotel Logo" style="height: 120px; width: 140; object-fit: contain;">
        </a>
        
        <ul class="nav-links">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">Beranda</a>
            </li>
            <!-- Lacak Reservasi removed -->
            @auth

    @if(Auth::user()->role == 'admin')

        <li class="nav-item">
            <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/admin/rooms') }}">Kelola Kamar</a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/admin/reservations') }}">Reservasi</a>
        </li>

    @else

        <li class="nav-item">
            <a href="{{ url('/reservasi-saya') }}">Reservasi Saya</a>
        </li>

    @endif

    <li class="nav-item" style="color: var(--text-muted); font-weight:500; display:flex; align-items:center; gap:6px;">
        <i data-lucide="user" style="width:16px; color:var(--primary-color);"></i>

        {{ Auth::user()->username }}

        @if(Auth::user()->role == 'admin')
            <span style="color:#d4af37;">(Admin)</span>
        @endif
    </li>

    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-btn">
                Logout
            </button>
        </form>
    </li>

@else
                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="nav-btn">Login</a>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px; min-height: calc(100vh - 80px - 320px);">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col footer-about">
                <h3>N★JM Hotel</h3>
                <p>Menyediakan akomodasi penginapan mewah, nyaman, dan berkelas dengan pelayanan terbaik di pusat kota. Nikmati suasana hangat bersama kami.</p>
                <p><i data-lucide="map-pin" style="display:inline; width:16px; margin-right:5px; vertical-align:middle;"></i> Jl. Kapalo Koto, Pauh, Padang</p>
            </div>
            
            <div class="footer-col">
                <h3>Info</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <!-- Lacak Reservasi link removed -->
                    <li><a href="{{ url('/admin/login') }}">Login Administrasi</a></li>
                </ul>
            </div>
            
            <div class="footer-col footer-contact">
                <h3>Hubungi Kami</h3>
                <p><i data-lucide="phone" style="width:16px;"></i> +6281372747968</p>
                <p><i data-lucide="mail" style="width:16px;"></i> NajmHotelRacing@gmail.com</p>
                <p><i data-lucide="clock" style="width:16px;"></i> Resepsionis 24 Jam</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} N★JM Hotel. Semua Hak Dilindungi. Dibuat untuk Tugas Proyek Laravel.</p>
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
