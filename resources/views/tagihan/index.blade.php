@extends('layouts.app')

@section('title', 'Data Tagihan')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-file-invoice-dollar"></i> Data Tagihan</h1>
</div>

<div class="card">
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Belum Bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="Sudah Bayar" {{ request('status') == 'Sudah Bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-2">
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
                        <th>ID Tagihan</th>
                        <th>Pelanggan</th>
                        <th>Periode</th>
                        <th>Total Tagihan</th>
                        <th>Denda</th>
                        <th>Total Bayar</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $t)
                        <tr>
                            <td><strong>#{{ $t->id_tagihan }}</strong></td>
                            <td>
                                <strong>{{ $t->pelanggan->nama_pelanggan }}</strong><br>
                                <small class="text-muted">{{ $t->pelanggan->id_pelanggan }}</small>
                            </td>
                            <td>{{ $t->penggunaan->periode }}</td>
                            <td>Rp {{ number_format($t->total_tagihan, 0, ',', '.') }}</td>
                            <td>
                                @if($t->denda > 0)
                                    <span class="text-danger">Rp {{ number_format($t->denda, 0, ',', '.') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <strong>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                {{ $t->jatuh_tempo->format('d M Y') }}
                                @if($t->is_lewat_jatuh_tempo)
                                    <br><span class="badge bg-danger">Lewat Tempo</span>
                                @endif
                            </td>
                            <td>
                                @if($t->status_bayar == 'Sudah Bayar')
                                    <span class="badge bg-success">{{ $t->status_bayar }}</span>
                                @elseif($t->status_bayar == 'Terlambat')
                                    <span class="badge bg-danger">{{ $t->status_bayar }}</span>
                                @else
                                    <span class="badge bg-warning">{{ $t->status_bayar }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tagihan.show', $t->id_tagihan) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($t->status_bayar != 'Sudah Bayar')
                                        <a href="{{ route('pembayaran.create', ['id_tagihan' => $t->id_tagihan]) }}" 
                                           class="btn btn-success" title="Bayar">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data tagihan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $tagihan->links() }}
        </div>
    </div>
</div>
@endsection
