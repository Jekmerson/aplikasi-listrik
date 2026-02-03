@extends('layouts.app')

@section('title', 'Detail Tagihan')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-file-invoice"></i> Detail Tagihan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('tagihan.index') }}">Tagihan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Informasi Tagihan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>ID Tagihan</strong></td>
                        <td>: {{ $tagihan->id_tagihan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Periode</strong></td>
                        <td>: {{ $tagihan->penggunaan ? $tagihan->penggunaan->periode : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Tagihan</strong></td>
                        <td>: {{ $tagihan->tanggal_tagihan ? $tagihan->tanggal_tagihan->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: 
                            @if($tagihan->status_bayar == 'Sudah Bayar')
                                <span class="badge bg-success">{{ $tagihan->status_bayar }}</span>
                            @elseif($tagihan->status_bayar == 'Terlambat')
                                <span class="badge bg-danger">{{ $tagihan->status_bayar }}</span>
                            @else
                                <span class="badge bg-warning">{{ $tagihan->status_bayar }}</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <h6><i class="fas fa-user"></i> Data Pelanggan</h6>
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>ID Pelanggan</strong></td>
                        <td>: {{ $tagihan->pelanggan->id_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>: {{ $tagihan->pelanggan->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $tagihan->pelanggan->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Daya Listrik</strong></td>
                        <td>: {{ $tagihan->pelanggan->dayaListrik->daya_watt }} VA</td>
                    </tr>
                </table>

                <hr>

                <h6><i class="fas fa-bolt"></i> Rincian Penggunaan</h6>
                <table class="table table-borderless">
                    @if($tagihan->penggunaan)
                    <tr>
                        <td width="200"><strong>Meter Awal</strong></td>
                        <td>: {{ number_format($tagihan->penggunaan->meter_awal, 0, ',', '.') }} kWh</td>
                    </tr>
                    <tr>
                        <td><strong>Meter Akhir</strong></td>
                        <td>: {{ number_format($tagihan->penggunaan->meter_akhir, 0, ',', '.') }} kWh</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Total Penggunaan</strong></td>
                        <td>: <strong>{{ $tagihan->penggunaan ? number_format($tagihan->penggunaan->total_kwh, 2, ',', '.') : 0 }} kWh</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Tarif per kWh</strong></td>
                        <td>: Rp {{ number_format($tagihan->pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <hr>

                <div class="bg-light p-3 rounded">
                    <div class="row">
                        <div class="col-6">
                            <h5>Total Tagihan</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h4 class="text-primary mb-0">
                                Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>

                @if($tagihan->status_bayar == 'Sudah Bayar' && $tagihan->pembayaran->first())
                @php $pembayaran = $tagihan->pembayaran->first(); @endphp
                <hr>
                <h6><i class="fas fa-check-circle text-success"></i> Informasi Pembayaran</h6>
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>ID Pembayaran</strong></td>
                        <td>: {{ $pembayaran->id_pembayaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Bayar</strong></td>
                        <td>: {{ $pembayaran->tanggal_bayar->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Metode Pembayaran</strong></td>
                        <td>: {{ $pembayaran->metode_bayar }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Bayar</strong></td>
                        <td>: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <div class="text-center mt-3">
                    <a href="{{ route('pembayaran.show', $pembayaran->id_pembayaran) }}" 
                       class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-print"></i> Cetak Struk Pembayaran
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Aksi</h6>
            </div>
            <div class="card-body">
                @if($tagihan->status_bayar != 'Sudah Bayar')
                <a href="{{ route('pembayaran.create', ['id_tagihan' => $tagihan->id_tagihan]) }}" 
                   class="btn btn-success btn-block mb-2 w-100">
                    <i class="fas fa-money-bill"></i> Bayar Tagihan
                </a>
                @endif

                <a href="{{ route('tagihan.index') }}" class="btn btn-secondary btn-block w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if($tagihan->status_bayar == 'Belum Bayar')
        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Status Pembayaran</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Jatuh Tempo:</strong></p>
                <p>{{ $tagihan->jatuh_tempo ? $tagihan->jatuh_tempo->format('d F Y') : '-' }}</p>
                
                @php
                    $jatuhTempo = $tagihan->jatuh_tempo ? $tagihan->jatuh_tempo->timestamp : time();
                    $today = time();
                    $sisaHari = floor(($jatuhTempo - $today) / (60 * 60 * 24));
                @endphp

                @if($sisaHari > 0)
                    <div class="alert alert-info mb-0">
                        Sisa waktu: <strong>{{ $sisaHari }} hari</strong>
                    </div>
                @else
                    <div class="alert alert-danger mb-0">
                        <strong>Lewat {{ abs($sisaHari) }} hari!</strong><br>
                        Kena denda 2%
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
