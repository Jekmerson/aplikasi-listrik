@extends('layouts.app')

@section('title', 'Detail Penggunaan Listrik')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-chart-line"></i> Detail Penggunaan Listrik</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('penggunaan.index') }}">Penggunaan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Informasi Penggunaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>ID Penggunaan</strong></td>
                        <td>: #{{ $penggunaan->id_penggunaan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Periode</strong></td>
                        <td>: {{ $penggunaan->periode }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Catat</strong></td>
                        <td>: {{ $penggunaan->tanggal_catat ? $penggunaan->tanggal_catat->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                </table>

                <hr>

                <h6><i class="fas fa-user"></i> Data Pelanggan</h6>
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>ID Pelanggan</strong></td>
                        <td>: {{ $penggunaan->pelanggan->id_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>: {{ $penggunaan->pelanggan->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $penggunaan->pelanggan->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Daya Listrik</strong></td>
                        <td>: {{ $penggunaan->pelanggan->dayaListrik->daya_watt }} VA</td>
                    </tr>
                    <tr>
                        <td><strong>Tarif</strong></td>
                        <td>: {{ $penggunaan->pelanggan->dayaListrik->tarif->nama_tarif }}</td>
                    </tr>
                </table>

                <hr>

                <h6><i class="fas fa-tachometer-alt"></i> Rincian Meter</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">Meter Awal</h6>
                                <h3 class="text-primary mb-0">{{ number_format($penggunaan->meter_awal, 0, ',', '.') }}</h3>
                                <small class="text-muted">kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">Meter Akhir</h6>
                                <h3 class="text-primary mb-0">{{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}</h3>
                                <small class="text-muted">kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h6>Total Penggunaan</h6>
                                <h3 class="mb-0">{{ number_format($penggunaan->total_kwh, 0, ',', '.') }}</h3>
                                <small>kWh</small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h6><i class="fas fa-calculator"></i> Estimasi Biaya</h6>
                @php
                    $tarif = $penggunaan->pelanggan->dayaListrik->tarif;
                    $biayaListrik = $penggunaan->total_kwh * $tarif->tarif_per_kwh;
                    $biayaBeban = $tarif->biaya_beban;
                    $total = $biayaListrik + $biayaBeban;
                @endphp
                <table class="table table-bordered">
                    <tr>
                        <td>Pemakaian {{ number_format($penggunaan->total_kwh, 0, ',', '.') }} kWh × Rp {{ number_format($tarif->tarif_per_kwh, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($biayaListrik, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Biaya Beban</td>
                        <td class="text-end">Rp {{ number_format($biayaBeban, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-primary">
                        <td><strong>Total Estimasi</strong></td>
                        <td class="text-end"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Aksi</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('penggunaan.edit', $penggunaan->id_penggunaan) }}" 
                   class="btn btn-warning btn-block mb-2 w-100">
                    <i class="fas fa-edit"></i> Edit Penggunaan
                </a>

                <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary btn-block w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if($penggunaan->tagihan)
        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Tagihan Terkait</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>ID Tagihan:</strong> #{{ $penggunaan->tagihan->id_tagihan }}</p>
                <p class="mb-2"><strong>Total:</strong> Rp {{ number_format($penggunaan->tagihan->total_tagihan, 0, ',', '.') }}</p>
                <p class="mb-2">
                    <strong>Status:</strong>
                    @if($penggunaan->tagihan->status_bayar == 'Sudah Bayar')
                        <span class="badge bg-success">{{ $penggunaan->tagihan->status_bayar }}</span>
                    @elseif($penggunaan->tagihan->status_bayar == 'Terlambat')
                        <span class="badge bg-danger">{{ $penggunaan->tagihan->status_bayar }}</span>
                    @else
                        <span class="badge bg-warning">{{ $penggunaan->tagihan->status_bayar }}</span>
                    @endif
                </p>
                <a href="{{ route('tagihan.show', $penggunaan->tagihan->id_tagihan) }}" 
                   class="btn btn-info btn-sm w-100">
                    <i class="fas fa-eye"></i> Lihat Detail Tagihan
                </a>
            </div>
        </div>
        @else
        <div class="card mt-3 border-warning">
            <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Belum Ada Tagihan</h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">Tagihan untuk penggunaan ini belum dibuat oleh sistem.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
