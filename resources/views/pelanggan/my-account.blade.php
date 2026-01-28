@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mb-4">
    <h1 class="page-title">
        <i class="fas fa-user-circle"></i> Profil Saya
    </h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <h4>{{ $pelanggan->nama_pelanggan }}</h4>
                <p class="text-muted">{{ $pelanggan->id_pelanggan }}</p>
                <span class="badge bg-{{ $pelanggan->status == 'Aktif' ? 'success' : 'danger' }} fs-6">
                    {{ $pelanggan->status }}
                </span>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-bolt"></i> Informasi Daya Listrik
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Daya Terpasang</td>
                        <td class="text-end">
                            <strong>{{ $pelanggan->dayaListrik->daya_watt }} VA</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Tarif per kWh</td>
                        <td class="text-end">
                            <strong>Rp {{ number_format($pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Pelanggan
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th width="30%">ID Pelanggan</th>
                        <td>{{ $pelanggan->id_pelanggan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $pelanggan->nama_pelanggan }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $pelanggan->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $pelanggan->nomor_telepon ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $pelanggan->status == 'Aktif' ? 'success' : 'danger' }}">
                                {{ $pelanggan->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Ringkasan Penggunaan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Total Penggunaan (Tahun Ini)</h6>
                                @php
                                    $tahunIni = date('Y');
                                    $totalKwhTahunIni = $pelanggan->penggunaan()
                                        ->where('tahun', $tahunIni)
                                        ->sum('total_kwh');
                                @endphp
                                <h3 class="mb-0 text-primary">{{ number_format($totalKwhTahunIni, 0, ',', '.') }} kWh</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Tagihan Belum Bayar</h6>
                                @php
                                    $tagihanBelumBayarList = $pelanggan->tagihan()
                                        ->whereIn('status_bayar', ['Belum Bayar', 'Terlambat'])
                                        ->get();
                                    $tagihanBelumBayar = $tagihanBelumBayarList->count();
                                    $totalBelumBayar = $tagihanBelumBayarList->sum(function($t) {
                                        return $t->total_tagihan + $t->denda;
                                    });
                                @endphp
                                <h3 class="mb-0 text-danger">{{ $tagihanBelumBayar }}</h3>
                                <small class="text-muted">Total: Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($tagihanBelumBayar > 0)
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Perhatian!</strong> Anda memiliki {{ $tagihanBelumBayar }} tagihan yang belum dibayar. 
                Silakan hubungi kantor PLN terdekat untuk melakukan pembayaran.
            </div>
        @endif
    </div>
</div>
@endsection
