@extends('layouts.app')

@section('title', 'Data Penggunaan Listrik')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-chart-line"></i> Data Penggunaan Listrik</h1>
    <a href="{{ route('penggunaan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Input Penggunaan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
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
                        <th>Pelanggan</th>
                        <th>Periode</th>
                        <th>Meter Awal</th>
                        <th>Meter Akhir</th>
                        <th>Total kWh</th>
                        <th>Estimasi Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penggunaan as $p)
                        <tr>
                            <td>
                                <strong>{{ $p->pelanggan->nama_pelanggan }}</strong><br>
                                <small class="text-muted">{{ $p->pelanggan->id_pelanggan }}</small>
                            </td>
                            <td>{{ $p->periode }}</td>
                            <td>{{ number_format($p->meter_awal, 0, ',', '.') }}</td>
                            <td>{{ number_format($p->meter_akhir, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info">{{ number_format($p->total_kwh, 0, ',', '.') }} kWh</span>
                            </td>
                            <td>
                                Rp {{ number_format($p->total_kwh * $p->pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($p->tagihan)
                                    @if($p->tagihan->status_bayar == 'Sudah Bayar')
                                        <span class="badge bg-success">Sudah Bayar</span>
                                    @elseif($p->tagihan->status_bayar == 'Terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-warning">Belum Bayar</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Ada Tagihan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('penggunaan.show', $p->id_penggunaan) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('penggunaan.edit', $p->id_penggunaan) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data penggunaan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $penggunaan->links() }}
        </div>
    </div>
</div>
@endsection
