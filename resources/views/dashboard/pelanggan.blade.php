@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-user-circle"></i> Dashboard Pelanggan
    </h1>
    <p class="text-muted">Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
</div>

<!-- Pelanggan Info Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-id-card"></i> Informasi Akun
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="45%">ID Pelanggan</td>
                        <td><strong>{{ $pelanggan->id_pelanggan }}</strong></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><strong>{{ $pelanggan->nama_pelanggan }}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $pelanggan->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Daya Listrik</td>
                        <td><span class="badge bg-info">{{ $pelanggan->dayaListrik->daya_watt }} VA</span></td>
                    </tr>
                    <tr>
                        <td>Tarif/kWh</td>
                        <td><strong>Rp {{ number_format($pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            @if($pelanggan->status == 'Aktif')
                                <span class="badge bg-success">{{ $pelanggan->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $pelanggan->status }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="card stat-card" style="border-left-color: #dc3545;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Tagihan Belum Bayar</h6>
                                <h2 class="mb-0">{{ $stats['total_tagihan_belum_bayar'] }}</h2>
                                <small class="text-danger">Tagihan</small>
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-file-invoice fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card" style="border-left-color: #ffc107;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Belum Dibayar</h6>
                                <h3 class="mb-0 text-danger">Rp {{ number_format($stats['total_nominal_belum_bayar'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($stats['penggunaan_bulan_ini'])
                <div class="col-md-12">
                    <div class="card stat-card" style="border-left-color: #198754;">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-bolt"></i> Penggunaan Bulan Ini ({{ $stats['penggunaan_bulan_ini']->periode }})
                            </h6>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <p class="mb-1 text-muted">Meter Awal</p>
                                    <h4>{{ number_format($stats['penggunaan_bulan_ini']->meter_awal, 0, ',', '.') }}</h4>
                                </div>
                                <div class="col-4 text-center">
                                    <p class="mb-1 text-muted">Meter Akhir</p>
                                    <h4>{{ number_format($stats['penggunaan_bulan_ini']->meter_akhir, 0, ',', '.') }}</h4>
                                </div>
                                <div class="col-4 text-center">
                                    <p class="mb-1 text-muted">Total</p>
                                    <h4 class="text-success">{{ number_format($stats['penggunaan_bulan_ini']->total_kwh, 0, ',', '.') }} kWh</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tagihan Belum Bayar -->
@if($tagihan_belum_bayar->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-circle"></i> Tagihan Belum Bayar - SEGERA BAYAR!
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Total kWh</th>
                                    <th>Tagihan</th>
                                    <th>Denda</th>
                                    <th>Total Bayar</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tagihan_belum_bayar as $t)
                                    <tr>
                                        <td><strong>{{ $t->penggunaan->periode }}</strong></td>
                                        <td>{{ number_format($t->penggunaan->total_kwh, 0, ',', '.') }} kWh</td>
                                        <td>Rp {{ number_format($t->total_tagihan, 0, ',', '.') }}</td>
                                        <td>
                                            @if($t->denda > 0)
                                                <span class="text-danger">Rp {{ number_format($t->denda, 0, ',', '.') }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-danger">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            {{ $t->jatuh_tempo->format('d M Y') }}
                                            @if($t->is_lewat_jatuh_tempo)
                                                <br><span class="badge bg-danger">TERLAMBAT</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $t->status_bayar == 'Terlambat' ? 'danger' : 'warning' }}">
                                                {{ $t->status_bayar }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-info-circle"></i> <strong>Info:</strong> Silakan hubungi kantor PLN terdekat atau datang langsung untuk melakukan pembayaran tagihan.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <!-- Riwayat Penggunaan 6 Bulan Terakhir -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-history"></i> Riwayat Penggunaan 6 Bulan Terakhir
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Total kWh</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggunaan_6bulan as $p)
                                <tr>
                                    <td><strong>{{ $p->periode }}</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($p->total_kwh, 0, ',', '.') }} kWh</span>
                                    </td>
                                    <td>
                                        @if($p->tagihan)
                                            Rp {{ number_format($p->tagihan->total_tagihan, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->tagihan)
                                            @if($p->tagihan->status_bayar == 'Sudah Bayar')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif($p->tagihan->status_bayar == 'Terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @else
                                                <span class="badge bg-warning">Belum Bayar</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada riwayat penggunaan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="fas fa-receipt"></i> Riwayat Pembayaran Terakhir
            </div>
            <div class="card-body">
                @forelse($riwayat_pembayaran as $pb)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $pb->tagihan->penggunaan->periode }}</strong><br>
                                <small class="text-muted">{{ $pb->tanggal_bayar->format('d M Y H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <strong class="text-success">Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}</strong><br>
                                <span class="badge bg-primary">{{ $pb->metode_bayar }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada riwayat pembayaran</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
