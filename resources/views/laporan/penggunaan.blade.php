@extends('layouts.app')

@section('title', 'Laporan Penggunaan Listrik')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-file-alt"></i> Laporan Penggunaan Listrik</h1>
</div>

<div class="card">
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
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
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
            <div class="col-md-5 text-end">
                <label class="form-label">&nbsp;</label><br>
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </form>

        <hr>

        <!-- Report Content -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Periode</th>
                        <th>Daya</th>
                        <th>Meter Awal</th>
                        <th>Meter Akhir</th>
                        <th>Total kWh</th>
                        <th>Tarif/kWh</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_kwh = 0; $total_biaya = 0; @endphp
                    @forelse($data as $index => $p)
                        @php
                            $biaya = $p->total_kwh * $p->pelanggan->dayaListrik->tarif->tarif_per_kwh;
                            $total_kwh += $p->total_kwh;
                            $total_biaya += $biaya;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->pelanggan->id_pelanggan }}</td>
                            <td>{{ $p->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $p->periode }}</td>
                            <td>{{ $p->pelanggan->dayaListrik->daya_watt }} VA</td>
                            <td class="text-end">{{ number_format($p->meter_awal, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p->meter_akhir, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p->total_kwh, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($p->pelanggan->dayaListrik->tarif->tarif_per_kwh, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($biaya, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="7" class="text-end">TOTAL:</th>
                            <th class="text-end">{{ number_format($total_kwh, 0, ',', '.') }} kWh</th>
                            <th></th>
                            <th class="text-end">Rp {{ number_format($total_biaya, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
