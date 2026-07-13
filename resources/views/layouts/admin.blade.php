<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'N★JM Hotel - Admin Panel')</title>
    
    <!-- Link CSS Utama -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Optional: custom admin styles if needed in future -->
    <style>
        .navbar.admin-navbar {
            background-color: #1a1a2e; /* Darker theme for admin */
        }
        .navbar.admin-navbar .nav-links a {
            color: #f1f1f1;
        }
        .navbar.admin-navbar .nav-item.active a {
            color: #d4af37;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">

    <!-- Navigation Bar Admin -->
    <nav class="navbar admin-navbar" id="mainNavbar">
        <a href="{{ route('admin.dashboard') }}" class="nav-logo">
            <span style="color: #d4af37; font-size: 1.5rem; font-weight: bold; margin-left: 20px;">N★JM Admin</span>
        </a>
        
        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ url('/') }}">Ke Halaman Depan</a>
            </li>
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">Kelola Kamar</a>
            </li>
            
            <li class="nav-item" style="color: #e2e8f0; font-weight:500; display:flex; align-items:center; gap:6px;">
                <i data-lucide="shield" style="width:16px; color:#d4af37;"></i>
                {{ Auth::user()->username }}
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-btn" style="background: transparent; border: 1px solid #d4af37; color: #d4af37;">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px; min-height: calc(100vh - 80px - 80px); padding: 20px;">
        @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer style="background: #1a1a2e; color: #94a3b8; text-align: center; padding: 20px 0; font-size: 0.9rem;">
        <p>&copy; {{ date('Y') }} N★JM Hotel - Admin Panel.</p>
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
