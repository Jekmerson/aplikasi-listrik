@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-file-invoice-dollar"></i> Laporan Pembayaran
    </h1>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-filter"></i> Filter Laporan
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.pembayaran') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('laporan.pembayaran') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Card -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pembayaran</h6>
                        <h3 class="mb-0 text-success">{{ $data->count() }}</h3>
                        <small class="text-muted">Transaksi</small>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-receipt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card stat-card" style="border-left-color: #007bff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Nominal Pembayaran</h6>
                        <h2 class="mb-0 text-primary">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</h2>
                        <small class="text-muted">
                            @if(request('dari') && request('sampai'))
                                Periode: {{ date('d/m/Y', strtotime(request('dari'))) }} - {{ date('d/m/Y', strtotime(request('sampai'))) }}
                            @else
                                Semua Periode
                            @endif
                        </small>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pembayaran</h5>
        <button onclick="window.print()" class="btn btn-sm btn-success">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Periode</th>
                        <th>Metode Bayar</th>
                        <th>Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->tanggal_bayar->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->tagihan->pelanggan->id_pelanggan }}</td>
                            <td>{{ $item->tagihan->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $item->tagihan->penggunaan->periode }}</td>
                            <td>
                                <span class="badge bg-{{ $item->metode_bayar == 'Tunai' ? 'success' : 'primary' }}">
                                    {{ $item->metode_bayar }}
                                </span>
                            </td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="6" class="text-end">TOTAL KESELURUHAN:</th>
                            <th class="text-end">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .btn, .card-header .btn, nav, .no-print {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 20px !important;
    }
}
</style>
@endsection
