<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }} | Dashboard Kepdin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend/AdminLTE/dist/css/adminlte.css') }}" />
  </head>

  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">

      {{-- Navbar --}}
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#">
                <i class="bi bi-list"></i>
              </a>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Setting</a>
                  <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button 
                        type="submit" 
                        class="btn btn-default btn-flat float-end"
                        onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      {{-- Sidebar --}}
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="{{ route('kepdin.dashboard') }}" class="brand-link">
            <img src="{{ asset('frontend/AdminLTE/dist/assets/img/AdminLTELogo.png') }}" 
                 alt="Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Kepala Dinas</span>
          </a>
        </div>

        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

              {{-- Dashboard --}}
              {{-- Dashboard --}}
              <li class="nav-item">
                <a href="{{ route('kepdin.dashboard') }}"
                   class="nav-link {{ Route::is('kepdin.dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer2"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
              {{-- Data Aset --}}
              <li class="nav-item">
                <a href="{{ route('laporan.inventaris') }}"
                   class="nav-link {{ Route::is('assets.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam"></i>
                  <p>Data Aset</p>
                </a>
              </li>
              
              {{-- Laporan Kelayakan --}}
              <li class="nav-item">
                <a href="{{ route('kepdin.laporan.index') }}"
                   class="nav-link {{ Route::is('kepdin.laporan.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-clipboard-check"></i>
                  <p>Laporan Kelayakan</p>
                </a>
              </li>
              
              {{-- Laporan Izin --}}
              <li class="nav-item">
                <a href="{{ route('kepdin.penghapusan.index') }}"
                   class="nav-link {{ Route::is('kepdin.penghapusan.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-clipboard-minus"></i>
                  <p>Laporan Izin</p>
                </a>
              </li>
              
              {{-- Laporan ATK --}}
              <li class="nav-item">
                <a href="{{ route('penghapusan_atk.index') }}"
                   class="nav-link {{ Route::is('penghapusan_atk.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>Laporan ATK</p>
                </a>
              </li>


              {{-- laporan perbaikan --}}
              <li class="nav-item">
                <a href="{{ route('laporan.perbaikan') }}"
                   class="nav-link {{ Route::is('perbaikan.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam"></i>
                  <p>laporan perbaikan</p>
                </a>
              </li>

              {{-- laporan stok atk --}}
              <li class="nav-item">
                <a href="{{ route('laporan.report') }}"
                   class="nav-link {{ Route::is('report.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam"></i>
                  <p>laporan stok atk</p>
                </a>
              </li>

              {{-- laporan izin stok atk --}}
              <li class="nav-item">
                <a href="{{ route('kepdin.pengajuan.index') }}"
                   class="nav-link {{ Route::is('report.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam"></i>
                  <p>pengajuan stok atk</p>
                </a>
              </li>


            </ul>
          </nav>
        </div>
      </aside>

      {{-- Main --}}
      <main class="app-main">
        @yield('content')
        @yield('script')
      </main>

      {{-- Footer --}}
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Dinas Arsip & Perpustakaan</div>
        <strong>© 2025 - Sistem Inventaris Aset</strong>
      </footer>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/AdminLTE/dist/js/adminlte.js') }}"></script>
  </body>
</html>
