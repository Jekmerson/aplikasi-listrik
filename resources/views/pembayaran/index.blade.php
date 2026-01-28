@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-money-bill-wave"></i> Data Pembayaran</h1>
    <a href="{{ route('pembayaran.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Input Pembayaran
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="Tunai" {{ request('metode') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="Transfer" {{ request('metode') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="EDC" {{ request('metode') == 'EDC' ? 'selected' : '' }}>EDC</option>
                    <option value="QRIS" {{ request('metode') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Periode</th>
                        <th>Jumlah Bayar</th>
                        <th>Metode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                        <tr>
                            <td><strong>#{{ $p->id_pembayaran }}</strong></td>
                            <td>{{ $p->tanggal_bayar->format('d M Y H:i') }}</td>
                            <td>
                                <strong>{{ $p->tagihan->pelanggan->nama_pelanggan }}</strong><br>
                                <small class="text-muted">{{ $p->tagihan->pelanggan->id_pelanggan }}</small>
                            </td>
                            <td>{{ $p->tagihan->penggunaan->periode }}</td>
                            <td>
                                <strong class="text-success">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $p->metode_bayar }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pembayaran.show', $p->id_pembayaran) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pembayaran.receipt', $p->id_pembayaran) }}" 
                                       class="btn btn-success" title="Cetak Struk" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $pembayaran->links() }}
        </div>
    </div>
</div>
@endsection
