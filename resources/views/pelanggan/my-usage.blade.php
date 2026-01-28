@extends('layouts.app')

@section('title', 'Penggunaan Saya')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-chart-line"></i> Riwayat Penggunaan Listrik Saya
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

@if($penggunaan->count() > 0)
    <div class="row mb-4">
        @php
            $totalKwh = $penggunaan->sum('total_kwh');
            $rataRata = $penggunaan->avg('total_kwh');
            $tertinggi = $penggunaan->max('total_kwh');
        @endphp
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #0dcaf0;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Penggunaan</h6>
                    <h3 class="mb-0 text-info">{{ number_format($totalKwh, 0, ',', '.') }} kWh</h3>
                    <small class="text-muted">Keseluruhan Periode</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #198754;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Rata-rata per Bulan</h6>
                    <h3 class="mb-0 text-success">{{ number_format($rataRata, 0, ',', '.') }} kWh</h3>
                    <small class="text-muted">{{ $penggunaan->count() }} Periode</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #ffc107;">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Penggunaan Tertinggi</h6>
                    <h3 class="mb-0 text-warning">{{ number_format($tertinggi, 0, ',', '.') }} kWh</h3>
                    <small class="text-muted">Puncak Penggunaan</small>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list"></i> Riwayat Penggunaan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Meter Awal</th>
                        <th>Meter Akhir</th>
                        <th>Total Penggunaan</th>
                        <th>Tagihan</th>
                        <th>Status Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penggunaan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->periode }}</strong>
                            </td>
                            <td class="text-end">{{ number_format($item->meter_awal, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($item->meter_akhir, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <span class="badge bg-info">{{ number_format($item->total_kwh, 0, ',', '.') }} kWh</span>
                            </td>
                            <td class="text-end">
                                @if($item->tagihan)
                                    Rp {{ number_format($item->tagihan->total_tagihan, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->tagihan)
                                    @if($item->tagihan->status_bayar == 'Sudah Bayar')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($item->tagihan->status_bayar == 'Terlambat')
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
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada riwayat penggunaan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
