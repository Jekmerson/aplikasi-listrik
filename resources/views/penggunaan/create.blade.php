@extends('layouts.app')

@section('title', 'Input Penggunaan Listrik')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-plus"></i> Input Penggunaan Listrik</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('penggunaan.index') }}">Penggunaan</a></li>
            <li class="breadcrumb-item active">Input</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penggunaan.store') }}" id="formPenggunaan">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id_pelanggan }}" 
                                        data-daya="{{ $p->dayaListrik->daya_watt }}"
                                        {{ old('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>
                                    {{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }} ({{ $p->dayaListrik->daya_watt }} VA)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bulan <span class="text-danger">*</span></label>
                            <select name="bulan" class="form-select" required>
                                <option value="">Pilih Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('bulan', date('n')) == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <select name="tahun" class="form-select" required>
                                @for($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ old('tahun', date('Y')) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meter Awal <span class="text-danger">*</span></label>
                        <input type="number" name="meter_awal" id="meter_awal" class="form-control" 
                               value="{{ old('meter_awal') }}" required min="0">
                        <button type="button" class="btn btn-sm btn-secondary mt-2" id="btnGetLatestMeter">
                            <i class="fas fa-sync"></i> Ambil dari Meter Akhir Bulan Lalu
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meter Akhir <span class="text-danger">*</span></label>
                        <input type="number" name="meter_akhir" id="meter_akhir" class="form-control" 
                               value="{{ old('meter_akhir') }}" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Penggunaan (kWh)</label>
                        <input type="text" id="total_kwh" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto calculate total kWh
    $('#meter_awal, #meter_akhir').on('input', function() {
        var awal = parseInt($('#meter_awal').val()) || 0;
        var akhir = parseInt($('#meter_akhir').val()) || 0;
        var total = akhir - awal;
        
        if (total > 0) {
            $('#total_kwh').val(total.toLocaleString('id-ID') + ' kWh');
        } else {
            $('#total_kwh').val('');
        }
    });

    // Get latest meter from previous month
    $('#btnGetLatestMeter').click(function() {
        var pelangganId = $('#id_pelanggan').val();
        
        if (!pelangganId) {
            alert('Pilih pelanggan terlebih dahulu');
            return;
        }

        $.get('/penggunaan/latest-meter/' + pelangganId, function(data) {
            if (data.meter_akhir > 0) {
                $('#meter_awal').val(data.meter_akhir);
                $('#meter_awal').trigger('input');
            } else {
                alert('Tidak ada data penggunaan sebelumnya');
            }
        });
    });
});
</script>
@endpush
