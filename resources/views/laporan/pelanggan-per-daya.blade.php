@extends('layouts.app')

@section('title', 'Laporan Pelanggan per Daya Listrik')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-chart-pie"></i> Laporan Pelanggan per Daya Listrik
    </h1>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #17a2b8;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Kategori Daya</h6>
                        <h3 class="mb-0 text-info">{{ $data->count() }}</h3>
                        <small class="text-muted">Kategori</small>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-bolt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pelanggan</h6>
                        <h3 class="mb-0 text-success">{{ $data->sum('jumlah') }}</h3>
                        <small class="text-muted">Pelanggan</small>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Kategori Terbanyak</h6>
                        @php
                            $terbanyak = $data->sortByDesc('jumlah')->first();
                        @endphp
                        <h4 class="mb-0 text-warning">
                            @if($terbanyak)
                                {{ $terbanyak->dayaListrik->daya_watt }} VA
                            @else
                                -
                            @endif
                        </h4>
                        <small class="text-muted">
                            @if($terbanyak)
                                {{ $terbanyak->jumlah }} Pelanggan
                            @endif
                        </small>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-star fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-table"></i> Distribusi Pelanggan per Daya Listrik</h5>
        <button onclick="window.print()" class="btn btn-sm btn-light">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Daya Listrik (VA)</th>
                        <th>Tarif per kWh</th>
                        <th>Jumlah Pelanggan</th>
                        <th>Persentase</th>
                        <th>Visualisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPelanggan = $data->sum('jumlah');
                    @endphp
                    @forelse($data->sortByDesc('jumlah') as $index => $item)
                        @php
                            $persentase = $totalPelanggan > 0 ? ($item->jumlah / $totalPelanggan) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->dayaListrik->daya_watt }} VA</strong>
                            </td>
                            <td>
                                Rp {{ number_format($item->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info fs-6">{{ $item->jumlah }} Pelanggan</span>
                            </td>
                            <td class="text-center">
                                <strong>{{ number_format($persentase, 1) }}%</strong>
                            </td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $persentase }}%"
                                         aria-valuenow="{{ $persentase }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ number_format($persentase, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="3" class="text-end">TOTAL KESELURUHAN:</th>
                            <th class="text-center">{{ $totalPelanggan }} Pelanggan</th>
                            <th class="text-center">100%</th>
                            <th></th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        @if($data->count() > 0)
            <div class="alert alert-info mt-3">
                <i class="fas fa-lightbulb"></i> <strong>Informasi:</strong>
                Laporan ini menampilkan distribusi pelanggan berdasarkan kategori daya listrik yang digunakan.
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    .sidebar, .btn, .card-header .btn, nav, .alert, .no-print {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 20px !important;
    }
}
</style>
@endsection
