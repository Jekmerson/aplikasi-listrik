@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-file-invoice-dollar"></i> Tagihan Listrik Saya
    </h1>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-user"></i> {{ $pelanggan->nama_pelanggan }} - {{ $pelanggan->id_pelanggan }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>
                <p class="mb-0"><strong>Daya Listrik:</strong> {{ $pelanggan->dayaListrik->daya_watt }} VA</p>
            </div>
            <div class="col-md-6 text-end">
                <p class="mb-1"><strong>Tarif per kWh:</strong> Rp {{ number_format($pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</p>
                <p class="mb-0">
                    <span class="badge bg-{{ $pelanggan->status == 'Aktif' ? 'success' : 'danger' }}">
                        {{ $pelanggan->status }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

@php
    $belumBayar = $tagihan->whereIn('status_bayar', ['Belum Bayar', 'Terlambat']);
    $sudahBayar = $tagihan->where('status_bayar', 'Sudah Bayar');
    $totalBelumBayar = $belumBayar->sum(function($t) {
        return $t->total_tagihan + $t->denda;
    });
    $totalSudahBayar = $sudahBayar->sum(function($t) {
        return $t->pembayaran->first() ? $t->pembayaran->first()->jumlah_bayar : 0;
    });
@endphp

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #dc3545;">
            <div class="card-body">
                <h6 class="text-muted mb-2">Tagihan Belum Bayar</h6>
                <h3 class="mb-0 text-danger">{{ $belumBayar->count() }}</h3>
                <small class="text-muted">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #198754;">
            <div class="card-body">
                <h6 class="text-muted mb-2">Tagihan Sudah Bayar</h6>
                <h3 class="mb-0 text-success">{{ $sudahBayar->count() }}</h3>
                <small class="text-muted">Rp {{ number_format($totalSudahBayar, 0, ',', '.') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #0dcaf0;">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Tagihan</h6>
                <h3 class="mb-0 text-info">{{ $tagihan->count() }}</h3>
                <small class="text-muted">Keseluruhan Periode</small>
            </div>
        </div>
    </div>
</div>

@if($belumBayar->count() > 0)
    <div class="card border-danger mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-circle"></i> Tagihan Belum Bayar - SEGERA BAYAR!
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
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
                        @foreach($belumBayar as $t)
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
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="4" class="text-end">TOTAL YANG HARUS DIBAYAR:</th>
                            <th colspan="3">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="alert alert-warning mt-3 mb-0">
                <i class="fas fa-info-circle"></i> <strong>Info Pembayaran:</strong> 
                Silakan hubungi kantor PLN terdekat atau datang langsung untuk melakukan pembayaran tagihan.
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Semua Tagihan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Tanggal Tagihan</th>
                        <th>Total kWh</th>
                        <th>Tagihan</th>
                        <th>Denda</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $index => $item)
                        <tr class="{{ $item->status_bayar == 'Terlambat' ? 'table-warning' : '' }}">
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $item->penggunaan->periode }}</strong></td>
                            <td>{{ $item->tanggal_tagihan->format('d/m/Y') }}</td>
                            <td>{{ number_format($item->penggunaan->total_kwh, 0, ',', '.') }} kWh</td>
                            <td>Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                            <td>
                                @if($item->denda > 0)
                                    <span class="text-danger">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <strong>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($item->status_bayar == 'Sudah Bayar')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($item->status_bayar == 'Terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                @if($item->pembayaran)
                                    {{ $item->pembayaran->tanggal_bayar->format('d/m/Y H:i') }}
                                    <br><small class="text-muted">{{ $item->pembayaran->metode_bayar }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada tagihan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
