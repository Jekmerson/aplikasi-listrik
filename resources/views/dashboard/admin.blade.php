@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-0">
            <i class="fas fa-user-shield"></i> Admin Dashboard
        </h1>
        <p class="text-muted">Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
    </div>
    <div class="badge bg-danger p-2">
        <i class="fas fa-crown"></i> Administrator
    </div>
</div>

<!-- Statistics Cards Row 1 -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card" style="border-left-color: #0d6efd;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pelanggan</h6>
                        <h2 class="mb-0">{{ $stats['total_pelanggan'] }}</h2>
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i> {{ $stats['pelanggan_aktif'] }} Aktif
                        </small>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card" style="border-left-color: #198754;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total User</h6>
                        <h2 class="mb-0">{{ $stats['total_user'] }}</h2>
                        <small class="text-muted">User Aktif</small>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-user-shield fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tagihan Belum Bayar</h6>
                        <h2 class="mb-0">{{ $stats['total_tagihan_belum_bayar'] }}</h2>
                        <small class="text-danger">
                            <i class="fas fa-exclamation-triangle"></i> {{ $stats['total_tagihan_terlambat'] }} Terlambat
                        </small>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-file-invoice-dollar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card stat-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Tunggakan</h6>
                        <h3 class="mb-0 text-danger">Rp {{ number_format($stats['total_tunggakan'], 0, ',', '.') }}</h3>
                        <small class="text-muted">Belum dibayar</small>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-exclamation-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards Row 2 -->
<div class="row mb-4">
    <div class="col-lg-6 col-md-6">
        <div class="card stat-card" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pendapatan Bulan Ini</h6>
                        <h3 class="mb-0 text-success">Rp {{ number_format($stats['total_pendapatan_bulan_ini'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card stat-card" style="border-left-color: #17a2b8;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pendapatan Tahun Ini</h6>
                        <h3 class="mb-0 text-info">Rp {{ number_format($stats['total_pendapatan_tahun_ini'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pelanggan per Daya -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-pie"></i> Distribusi Pelanggan per Daya
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Daya</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggan_per_daya as $data)
                            <tr>
                                <td>{{ $data->dayaListrik->daya_watt }} VA</td>
                                <td class="text-end">
                                    <span class="badge bg-primary">{{ $data->jumlah }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top 5 Tagihan Tertinggi -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-exclamation-triangle"></i> Top 5 Tagihan Belum Bayar Tertinggi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Periode</th>
                                <th>Total Tagihan</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_pelanggan as $t)
                                <tr>
                                    <td>
                                        <strong>{{ $t->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $t->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td>{{ $t->penggunaan->periode }}</td>
                                    <td>
                                        <strong class="text-danger">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $t->jatuh_tempo->format('d M Y') }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Latest Pembayaran -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_pembayaran as $pb)
                                <tr>
                                    <td><strong>#{{ $pb->id_pembayaran }}</strong></td>
                                    <td>{{ $pb->tanggal_bayar->format('d M Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $pb->tagihan->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $pb->tagihan->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td><strong class="text-success">Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $pb->metode_bayar }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
