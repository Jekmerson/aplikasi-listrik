<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Listrik Pascabayar')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0d47a1 0%, #1976d2 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        
        .sidebar .nav-link i {
            width: 25px;
        }
        
        .navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 2px solid #f0f0f0;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            padding: 5px 10px;
            font-weight: 500;
        }
        
        .btn {
            border-radius: 6px;
            padding: 8px 16px;
        }
        
        .table {
            font-size: 0.9rem;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar p-0">
                <div class="position-sticky">
                    <div class="text-center py-4 text-white">
                        <i class="fas fa-bolt fa-3x mb-2"></i>
                        <h5 class="mb-0">PLN Pascabayar</h5>
                        <small>v1.0</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        
                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                                    <i class="fas fa-users"></i> Pelanggan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('penggunaan.*') ? 'active' : '' }}" href="{{ route('penggunaan.index') }}">
                                    <i class="fas fa-chart-line"></i> Penggunaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tagihan.*') ? 'active' : '' }}" href="{{ route('tagihan.index') }}">
                                    <i class="fas fa-file-invoice-dollar"></i> Tagihan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}" href="{{ route('pembayaran.index') }}">
                                    <i class="fas fa-money-bill-wave"></i> Pembayaran
                                </a>
                            </li>
                            
                            <li class="nav-item mt-3">
                                <h6 class="text-white-50 px-3 mb-2">LAPORAN</h6>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.penggunaan') ? 'active' : '' }}" href="{{ route('laporan.penggunaan') }}">
                                    <i class="fas fa-file-alt"></i> Lap. Penggunaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.pembayaran') ? 'active' : '' }}" href="{{ route('laporan.pembayaran') }}">
                                    <i class="fas fa-receipt"></i> Lap. Pembayaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.tunggakan') ? 'active' : '' }}" href="{{ route('laporan.tunggakan') }}">
                                    <i class="fas fa-exclamation-triangle"></i> Lap. Tunggakan
                                </a>
                            </li>
                        @endif
                        
                        @if(auth()->user()->isPelanggan())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('my-account') ? 'active' : '' }}" href="{{ route('my-account') }}">
                                    <i class="fas fa-user"></i> Akun Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('my-usage') ? 'active' : '' }}" href="{{ route('my-usage') }}">
                                    <i class="fas fa-chart-line"></i> Penggunaan Saya
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('my-bills') ? 'active' : '' }}" href="{{ route('my-bills') }}">
                                    <i class="fas fa-file-invoice"></i> Tagihan Saya
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light sticky-top mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle fa-lg"></i>
                                        <span class="ms-2">{{ auth()->user()->nama_lengkap }}</span>
                                        <span class="badge bg-primary ms-1">{{ auth()->user()->level->nama_level }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li>
                                            <span class="dropdown-item-text">
                                                <small class="text-muted">{{ auth()->user()->email }}</small>
                                            </span>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="py-3">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // DataTable initialization
        $(document).ready(function() {
            if ($('.data-table').length) {
                $('.data-table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
