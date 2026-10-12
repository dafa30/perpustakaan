<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Pintar - @yield('page_title', 'Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('library/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* CSS tambahan untuk layout admin */
        body { display: flex; min-height: 100vh; flex-direction: column; }
        #app-admin { flex: 1; display: flex; } /* Ubah dari #app menjadi #app-admin untuk menghindari konflik */
        .sidebar {
            width: 250px;
            min-width: 250px;
            background-color: #343a40; /* Dark sidebar */
            color: white;
            padding-top: 1rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: sticky; /* Agar sidebar tidak ikut scroll */
            top: 0;
            left: 0;
            height: 100vh; /* Memastikan sidebar setinggi viewport */
            overflow-y: auto; /* Agar sidebar bisa di-scroll jika kontennya panjang */
        }
        .sidebar .nav-link {
            color: #adb5bd; /* Lighter text */
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: #fff;
            background-color: #007bff; /* Primary blue for active/hover */
            border-radius: 0.25rem;
        }
        .sidebar .nav-item .nav-link.dropdown-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar .nav-item .dropdown-menu {
            position: static !important;
            float: none !important;
            width: 100%;
            margin-top: 0;
            background-color: #495057; /* Darker sub-menu */
            border: none;
            border-radius: 0;
            box-shadow: none;
            padding-left: 1rem;
        }
        /* Submenu uses btn-toggle-nav rather than Bootstrap's .dropdown-menu. */
        .sidebar .btn-toggle-nav {
            margin: 0;
            padding: 0 0 0 1rem;
            background-color: #495057;
        }
        .sidebar .btn-toggle-nav .dropdown-item {
            display: block;
            color: #dee2e6;
            padding: 0.5rem 1rem;
            text-decoration: none;
            white-space: normal;
        }
        .sidebar .btn-toggle-nav .dropdown-item:hover,
        .sidebar .btn-toggle-nav .dropdown-item:focus,
        .sidebar .btn-toggle-nav .dropdown-item.active {
            color: #fff;
            background-color: #6c757d;
        }
        .sidebar .nav-item .dropdown-menu .dropdown-item {
            color: #adb5bd;
            padding: 0.5rem 1rem;
        }
        .sidebar .nav-item .dropdown-menu .dropdown-item:hover {
            background-color: #6c757d;
            color: #fff;
        }
        .content-wrapper {
            flex-grow: 1;
            padding: 1.5rem;
            background-color: #f8f9fa;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            text-align: center;
            width: 100%;
        }
        .navbar-brand-sidebar {
            display: block;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        @media (max-width: 767.98px) {
            #app-admin { flex-direction: column; }
            .sidebar {
                width: 100%;
                min-width: 0;
                height: auto;
                max-height: 50vh;
                position: relative;
            }
            .content-wrapper { padding: 1rem; }
            .content-wrapper > header { align-items: flex-start !important; gap: 1rem; }
            .content-wrapper h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div id="app-admin">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column">
            <a href="{{ route('dashboard') }}" class="navbar-brand-sidebar">Perpustakaan Pintar</a>
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#dataMasterMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::is('anggota*') || Request::is('buku*') || Request::is('kategori-buku*') || Request::is('denda*') ? 'true' : 'false' }}" aria-controls="dataMasterMenu">
                        Data Master
                    </a>
                    <div class="collapse {{ Request::is('anggota*') || Request::is('buku*') || Request::is('kategori-buku*') || Request::is('denda*') ? 'show' : '' }}" id="dataMasterMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a class="dropdown-item {{ Request::is('anggota*') ? 'active' : '' }}" href="{{ route('anggota.index') }}">Anggota</a></li>
                            <li><a class="dropdown-item {{ Request::is('buku*') ? 'active' : '' }}" href="{{ route('buku.index') }}">Buku</a></li>
                            <li><a class="dropdown-item {{ Request::is('kategori-buku*') ? 'active' : '' }}" href="{{ route('kategori-buku.index') }}">Kategori Buku</a></li>
                            <li><a class="dropdown-item {{ Request::is('denda*') ? 'active' : '' }}" href="{{ route('denda.index') }}">Denda</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#transaksiMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ Request::is('peminjaman*') ? 'true' : 'false' }}" aria-controls="transaksiMenu">
                        Transaksi
                    </a>
                    <div class="collapse {{ Request::is('peminjaman*') ? 'show' : '' }}" id="transaksiMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a class="dropdown-item {{ Request::is('peminjaman*') && !Request::is('peminjaman/create') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">Daftar Peminjaman</a></li>
                            <li><a class="dropdown-item" href="{{ route('peminjaman.create') }}">Input Peminjaman</a></li>
                            {{-- Pengembalian akan dihandle di Peminjaman atau Detail Pinjam --}}
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                        Laporan
                    </a>
                </li>
                @if(Auth::user()->isAdmin()) {{-- Hanya Admin yang bisa kelola User Sistem --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        User Sistem
                    </a>
                </li>
                @endif
                <li class="nav-item mt-auto"> {{-- mt-auto untuk push ke bawah --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none text-light text-start w-100">
                            Logout ({{ Auth::user()->nama_user }})
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Konten Utama -->
        <div class="content-wrapper">
            <header class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h1>@yield('page_title', 'Dashboard')</h1>
            </header>

            <main>
                @if(session('welcome'))
                    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080">
                        <div id="welcomeToast" class="toast text-bg-primary border-0" role="status" aria-live="polite" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">Selamat datang, <strong>{{ session('welcome') }}</strong>!</div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                            </div>
                        </div>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div> {{-- Ini adalah penutup untuk div id="app-admin" pertama --}}

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Dafa Adi Raharjo. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="{{ asset('library/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const welcomeToast = document.getElementById('welcomeToast');
            if (welcomeToast) {
                const toast = new bootstrap.Toast(welcomeToast, { autohide: false });
                toast.show();
                window.setTimeout(() => toast.hide(), 3000);
            }
        });
    </script>
</body>
</html>
