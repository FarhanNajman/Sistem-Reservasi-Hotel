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
            <li class="nav-item {{ Request::is('reservasi/lacak') ? 'active' : '' }}">
                <a href="{{ url('/reservasi/lacak') }}">Lacak Reservasi</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/login') }}" class="nav-btn">Login</a>
            </li>
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
                    <li><a href="{{ url('/reservasi/lacak') }}">Lacak Reservasi</a></li>
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
    </script>
    @yield('scripts')
</body>
</html>
