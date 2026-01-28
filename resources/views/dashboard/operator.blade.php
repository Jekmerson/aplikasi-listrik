@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-0">
            <i class="fas fa-headset"></i> Operator Dashboard
        </h1>
        <p class="text-muted">Selamat datang, {{ auth()->user()->nama_lengkap }} - <span class="text-primary">{{ now()->format('l, d F Y') }}</span></p>
    </div>
    <div class="badge bg-primary p-2">
        <i class="fas fa-user-cog"></i> Operator
    </div>
</div>

<!-- Today's Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card stat-card" style="border-left-color: #0d6efd;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pelanggan Aktif</h6>
                        <h2 class="mb-0">{{ $stats['pelanggan_aktif'] }}</h2>
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
                        <h6 class="text-muted mb-2">Input Penggunaan Hari Ini</h6>
                        <h2 class="mb-0">{{ $stats['penggunaan_hari_ini'] }}</h2>
                        <small class="text-success"><i class="fas fa-check"></i> Tercatat</small>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
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
                        <h2 class="mb-0">{{ $stats['tagihan_belum_bayar'] }}</h2>
                        <small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Perlu Follow Up</small>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-file-invoice fa-3x opacity-50"></i>
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
                        <h6 class="text-muted mb-2">Pembayaran Hari Ini</h6>
                        <h2 class="mb-0">{{ $stats['pembayaran_hari_ini'] }}</h2>
                        <small class="text-muted">Rp {{ number_format($stats['total_pembayaran_hari_ini'], 0, ',', '.') }}</small>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-bolt"></i> Quick Actions</h6>
                <div class="btn-group" role="group">
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Pelanggan
                    </a>
                    <a href="{{ route('penggunaan.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Input Penggunaan
                    </a>
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-warning">
                        <i class="fas fa-money-check"></i> Proses Pembayaran
                    </a>
                    <a href="{{ route('tagihan.index') }}" class="btn btn-info">
                        <i class="fas fa-file-invoice"></i> Lihat Tagihan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Penggunaan Hari Ini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-chart-line"></i> Penggunaan Hari Ini ({{ $penggunaan_hari_ini->count() }})
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($penggunaan_hari_ini as $p)
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <div>
                            <strong>{{ $p->pelanggan->nama_pelanggan }}</strong><br>
                            <small class="text-muted">{{ $p->pelanggan->id_pelanggan }} - {{ $p->periode }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info">{{ $p->total_kwh }} kWh</span><br>
                            <small>{{ $p->tanggal_catat->format('H:i') }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada input penggunaan hari ini</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pembayaran Hari Ini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-money-bill-wave"></i> Pembayaran Hari Ini ({{ $pembayaran_hari_ini->count() }})
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($pembayaran_hari_ini as $pb)
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                        <div>
                            <strong>{{ $pb->tagihan->pelanggan->nama_pelanggan }}</strong><br>
                            <small class="text-muted">{{ $pb->tagihan->pelanggan->id_pelanggan }}</small>
                        </div>
                        <div class="text-end">
                            <strong class="text-success">Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}</strong><br>
                            <span class="badge bg-primary">{{ $pb->metode_bayar }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada pembayaran hari ini</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Tagihan Jatuh Tempo Minggu Ini -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <i class="fas fa-exclamation-triangle"></i> Tagihan Jatuh Tempo 7 Hari Ke Depan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Jatuh Tempo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihan_jatuh_tempo as $t)
                                <tr>
                                    <td>
                                        <strong>{{ $t->pelanggan->nama_pelanggan }}</strong><br>
                                        <small class="text-muted">{{ $t->pelanggan->id_pelanggan }}</small>
                                    </td>
                                    <td>{{ $t->penggunaan->periode }}</td>
                                    <td><strong>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <small class="text-danger">{{ $t->jatuh_tempo->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('pembayaran.create', ['id_tagihan' => $t->id_tagihan]) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-money-bill"></i> Bayar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada tagihan jatuh tempo</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pembayaran per Metode Hari Ini -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-chart-bar"></i> Pembayaran per Metode
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        @forelse($pembayaran_per_metode as $metode)
                            <tr>
                                <td>{{ $metode->metode_bayar }}</td>
                                <td class="text-end">
                                    <span class="badge bg-info">{{ $metode->jumlah }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
