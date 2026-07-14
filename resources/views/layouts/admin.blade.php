<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'N★JM Hotel - Admin Panel')</title>
    
    <!-- Link CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        body {
            margin: 0;
            background-color: #f4f6f9;
            padding-left: 260px;
        }
        .admin-sidebar {
            width: 260px;
            background-color: #1e1e2d;
            color: #a2a3b7;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            left: 0;
            top: 0;
        }
        .sidebar-logo {
            padding: 20px;
            text-align: center;
            background-color: #1a1a27;
            border-bottom: 1px solid #2b2b40;
        }
        .sidebar-logo img {
            height: 60px;
            max-width: 100%;
            object-fit: contain;
        }
        .sidebar-menu {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #a2a3b7;
            text-decoration: none;
            transition: 0.3s;
            gap: 12px;
            font-weight: 500;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #1b1b29;
            color: #d4af37;
            border-left-color: #d4af37;
        }
        .sidebar-link i {
            width: 20px;
            height: 20px;
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #2b2b40;
            background-color: #1a1a27;
        }
        .admin-main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }
        .admin-content {
            flex: 1;
            padding: 30px;
        }
    </style>
</head>
<body>
 
    <!-- Sidebar Admin -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('gambar/logo/logoSudut.png') }}" alt="N★JM Hotel Logo" style="filter: brightness(0) invert(1);">
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ url('/reservasi_hotel') }}" class="sidebar-link">
                <i data-lucide="home"></i> Beranda Website
            </a>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('admin.reservations') }}" class="sidebar-link {{ Request::is('admin/reservations') ? 'active' : '' }}">
                <i data-lucide="calendar-check"></i> Kelola Reservasi
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link {{ Request::is('admin/users') ? 'active' : '' }}">
                <i data-lucide="users"></i> Daftar Pengguna
            </a>
            <a href="{{ route('admin.statistik') }}" class="sidebar-link {{ Request::is('admin/statistik') ? 'active' : '' }}">
                <i data-lucide="bar-chart-2"></i> Statistik Hunian
            </a>
        </nav>

        <div class="sidebar-footer">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; color: #fff;">
                <div style="width: 35px; height: 35px; border-radius: 50%; background-color: #d4af37; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1e1e2d;">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 0.95rem;">{{ Auth::user()->username }}</div>
                    <div style="font-size: 0.8rem; color: #a2a3b7;">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 6px; cursor: pointer; transition: 0.3s; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;" onmouseover="this.style.backgroundColor='#ef4444'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ef4444';">
                    <i data-lucide="log-out" style="width: 16px; height: 16px;"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="admin-main">
        <main class="admin-content">
            @yield('content')
        </main>

        <!-- Footer Admin -->
        <footer style="background: white; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 0.9rem;">
            &copy; {{ date('Y') }} N★JM Hotel - Admin Panel
        </footer>
    </div>

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
