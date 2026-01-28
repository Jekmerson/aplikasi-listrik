@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-user"></i> Detail Pelanggan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user-circle"></i> Informasi Pelanggan
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="40%">ID Pelanggan</td>
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
                        <td>No. Telepon</td>
                        <td>{{ $pelanggan->no_telepon ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $pelanggan->email ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Daya Listrik</td>
                        <td><span class="badge bg-info">{{ $pelanggan->dayaListrik->daya_watt }} VA</span></td>
                    </tr>
                    <tr>
                        <td>Tarif</td>
                        <td>{{ $pelanggan->dayaListrik->tarif->nama_tarif }}</td>
                    </tr>
                    <tr>
                        <td>Tarif/kWh</td>
                        <td>Rp {{ number_format($pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</td>
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
                    <tr>
                        <td>Tgl Registrasi</td>
                        <td>{{ $pelanggan->tanggal_registrasi->format('d M Y') }}</td>
                    </tr>
                </table>

                <div class="d-grid gap-2">
                    <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history"></i> Riwayat Penggunaan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Total kWh</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggan->penggunaan as $p)
                                <tr>
                                    <td>{{ $p->periode }}</td>
                                    <td>{{ number_format($p->meter_awal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($p->meter_akhir, 0, ',', '.') }}</td>
                                    <td>{{ number_format($p->total_kwh, 0, ',', '.') }} kWh</td>
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
                                                <span class="badge bg-success">Sudah Bayar</span>
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
                                    <td colspan="6" class="text-center text-muted">Belum ada riwayat penggunaan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
