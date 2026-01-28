@extends('layouts.app')

@section('title', 'Laporan Tunggakan')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-exclamation-triangle text-danger"></i> Laporan Tunggakan
    </h1>
</div>

<!-- Summary Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pelanggan Nunggak</h6>
                        <h3 class="mb-0 text-danger">{{ $data->count() }}</h3>
                        <small class="text-muted">Pelanggan</small>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-user-times fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card stat-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Tunggakan</h6>
                        <h2 class="mb-0 text-danger">Rp {{ number_format($total_tunggakan, 0, ',', '.') }}</h2>
                        <small class="text-warning">
                            <i class="fas fa-info-circle"></i> Termasuk denda keterlambatan
                        </small>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-hand-holding-usd fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> Data Tunggakan Pelanggan</h5>
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
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Periode</th>
                        <th>Total Tagihan</th>
                        <th>Denda</th>
                        <th>Total Bayar</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr class="{{ $item->status_bayar == 'Terlambat' ? 'table-danger' : '' }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pelanggan->id_pelanggan }}</td>
                            <td>{{ $item->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $item->penggunaan->periode }}</td>
                            <td class="text-end">Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                            <td class="text-end">
                                @if($item->denda > 0)
                                    <span class="text-danger">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                {{ $item->jatuh_tempo->format('d/m/Y') }}
                                @if($item->is_lewat_jatuh_tempo)
                                    <br><small class="text-danger">({{ $item->jatuh_tempo->diffForHumans() }})</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status_bayar == 'Terlambat' ? 'danger' : 'warning' }}">
                                    {{ $item->status_bayar }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-success">
                                <i class="fas fa-check-circle"></i> Tidak ada tunggakan - Semua pelanggan sudah membayar!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="6" class="text-end">TOTAL TUNGGAKAN KESELURUHAN:</th>
                            <th class="text-end" colspan="3">Rp {{ number_format($total_tunggakan, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        @if($data->count() > 0)
            <div class="alert alert-warning mt-3">
                <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> 
                Segera lakukan penagihan kepada pelanggan yang menunggak untuk menghindari kerugian perusahaan.
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
