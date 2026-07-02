<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MTs Al-Ihsan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @php $isAuthenticated = session()->has('user_id'); @endphp

    @if($isAuthenticated)
        <div class="app-shell">
            <aside class="sidebar d-none d-lg-flex">
                <a href="{{ route('dashboard') }}" class="brand text-decoration-none text-white">
                    <img src="{{ asset('logo-sekolah.png') }}" alt="Logo MTs Al-Ihsan" class="brand-icon">
                    <div>
                        <div class="fw-bold">SIPESAN</div>
                        <small class="opacity-75">Sistem Pencatatan Siswa</small>
                    </div>
                </a>

                <nav class="nav-links">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}" href="{{ route('siswa.index') }}"><i class="bi bi-people"></i> Siswa</a>
                    <a class="sidebar-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}" href="{{ route('kelas.index') }}"><i class="bi bi-building"></i> Kelas</a>
                    <a class="sidebar-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}" href="{{ route('absensi.index') }}"><i class="bi bi-calendar2-check"></i> Absensi</a>
                    <a class="sidebar-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}" href="{{ route('pelanggaran.index') }}"><i class="bi bi-exclamation-triangle"></i> Pelanggaran</a>
                    <a class="sidebar-link {{ request()->routeIs('izin.*') ? 'active' : '' }}" href="{{ route('izin.index') }}"><i class="bi bi-envelope-paper"></i> Izin</a>
                    <a class="sidebar-link {{ request()->routeIs('kebersihan.*') ? 'active' : '' }}" href="{{ route('kebersihan.index') }}"><i class="bi bi-droplet"></i> Kebersihan</a>
                    <a class="sidebar-link {{ request()->routeIs('keterlambatan.*') ? 'active' : '' }}" href="{{ route('keterlambatan.index') }}"><i class="bi bi-clock-history"></i> Keterlambatan</a>
                    <a class="sidebar-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}" href="{{ route('prestasi.index') }}"><i class="bi bi-award"></i> Prestasi</a>
                    <a class="sidebar-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" href="{{ route('pengaturan.index') }}"><i class="bi bi-gear"></i> Pengaturan</a>
                </nav>

                <div class="sidebar-footer">
                    <div class="small text-white-50">Login sebagai</div>
                    <div class="fw-semibold">{{ session('user_name', 'Administrator') }}</div>
                    <a class="btn btn-outline-light btn-sm w-100 mt-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </aside>

            <div class="content-area">
                <header class="topbar">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <h5 class="fw-bold mb-0">@yield('title', 'Dashboard')</h5>
                            <small class="text-muted">Sistem informasi Pencatatan Siswa</small>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a class="btn btn-outline-secondary btn-sm d-lg-none" data-bs-toggle="offcanvas" href="#mobileMenu" role="button">Menu</a>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}</div>
                                <div class="d-none d-md-block">
                                    <div class="fw-semibold">{{ session('user_name', 'Administrator') }}</div>
                                    <small class="text-muted">{{ session('user_role', 'Admin') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="page-content">
                    @if(session('success'))
                        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <footer class="footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <span>© {{ date('Y') }} MTs Al-Ihsan. All rights reserved.</span>
                        <span>Built for school administration and reporting.</span>
                    </div>
                </footer>
            </div>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <nav class="nav-links">
                    <a class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}" href="{{ route('siswa.index') }}">Siswa</a>
                    <a class="sidebar-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}" href="{{ route('kelas.index') }}">Kelas</a>
                    <a class="sidebar-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}" href="{{ route('absensi.index') }}">Absensi</a>
                    <a class="sidebar-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}" href="{{ route('pelanggaran.index') }}">Pelanggaran</a>
                    <a class="sidebar-link {{ request()->routeIs('izin.*') ? 'active' : '' }}" href="{{ route('izin.index') }}">Izin</a>
                    <a class="sidebar-link {{ request()->routeIs('kebersihan.*') ? 'active' : '' }}" href="{{ route('kebersihan.index') }}">Kebersihan</a>
                    <a class="sidebar-link {{ request()->routeIs('keterlambatan.*') ? 'active' : '' }}" href="{{ route('keterlambatan.index') }}">Keterlambatan</a>
                    <a class="sidebar-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}" href="{{ route('prestasi.index') }}">Prestasi</a>
                    <a class="sidebar-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}" href="{{ route('pengaturan.index') }}">Pengaturan</a>
                </nav>
            </div>
        </div>
    @else
        <div class="auth-shell">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
