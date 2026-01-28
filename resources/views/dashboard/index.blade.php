@extends('layouts.app')

@section('title', 'Dashboard - Aplikasi Listrik Pascabayar')

@section('content')
<div class="page-title">
    <i class="fas fa-tachometer-alt"></i> Dashboard
    <span class="text-muted fs-6">/ Selamat datang, {{ auth()->user()->nama_lengkap }}</span>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #0d6efd;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pelanggan</h6>
                        <h2 class="mb-0">{{ $stats['total_pelanggan'] }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #198754;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Penggunaan Bulan Ini</h6>
                        <h2 class="mb-0">{{ $stats['total_penggunaan'] }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tagihan Belum Bayar</h6>
                        <h2 class="mb-0">{{ $stats['total_tagihan_belum_bayar'] }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-file-invoice-dollar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pendapatan Bulan Ini</h6>
                        <h2 class="mb-0">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</h2>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Penggunaan -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Penggunaan Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Periode</th>
                                <th>Total kWh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_penggunaan as $p)
                                <tr>
                                    <td>
                                        <strong>{{ $p->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $p->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td>{{ $p->periode }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $p->total_kwh }} kWh</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan Jatuh Tempo -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exclamation-triangle"></i> Tagihan Jatuh Tempo (7 Hari Ke Depan)
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Jatuh Tempo</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihan_jatuh_tempo as $t)
                                <tr>
                                    <td>
                                        <strong>{{ $t->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $t->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $t->jatuh_tempo->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada tagihan jatuh tempo</td>
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
            <div class="card-header">
                <i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_pembayaran as $pb)
                                <tr>
                                    <td>{{ $pb->tanggal_bayar->format('d M Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $pb->tagihan->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $pb->tagihan->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td>Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $pb->metode_bayar }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada pembayaran</td>
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
