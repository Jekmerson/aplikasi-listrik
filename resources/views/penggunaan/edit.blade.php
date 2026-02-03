@extends('layouts.app')

@section('title', 'Edit Penggunaan Listrik')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-edit"></i> Edit Penggunaan Listrik</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('penggunaan.index') }}">Penggunaan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penggunaan.update', $penggunaan->id_penggunaan) }}" id="formPenggunaan">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <input type="text" class="form-control" 
                               value="{{ $penggunaan->pelanggan->id_pelanggan }} - {{ $penggunaan->pelanggan->nama_pelanggan }}" 
                               disabled>
                        <input type="hidden" name="id_pelanggan" value="{{ $penggunaan->id_pelanggan }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bulan</label>
                            <input type="text" class="form-control" 
                                   value="{{ DateTime::createFromFormat('!m', $penggunaan->bulan)->format('F') }}" 
                                   disabled>
                            <input type="hidden" name="bulan" value="{{ $penggunaan->bulan }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="text" class="form-control" value="{{ $penggunaan->tahun }}" disabled>
                            <input type="hidden" name="tahun" value="{{ $penggunaan->tahun }}">
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Catatan:</strong> Pelanggan dan periode tidak dapat diubah. Jika salah, hapus dan buat baru.
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Meter Awal <span class="text-danger">*</span></label>
                        <input type="number" name="meter_awal" id="meter_awal" class="form-control" 
                               value="{{ old('meter_awal', $penggunaan->meter_awal) }}" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meter Akhir <span class="text-danger">*</span></label>
                        <input type="number" name="meter_akhir" id="meter_akhir" class="form-control" 
                               value="{{ old('meter_akhir', $penggunaan->meter_akhir) }}" required min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Penggunaan (kWh)</label>
                        <input type="text" id="total_kwh" class="form-control" 
                               value="{{ $penggunaan->meter_akhir - $penggunaan->meter_awal }}" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto calculate total kWh
    function calculateKwh() {
        const meterAwal = parseFloat($('#meter_awal').val()) || 0;
        const meterAkhir = parseFloat($('#meter_akhir').val()) || 0;
        const totalKwh = meterAkhir - meterAwal;
        
        if (totalKwh < 0) {
            $('#total_kwh').val('Error: Meter akhir harus lebih besar dari meter awal');
            $('#meter_akhir').addClass('is-invalid');
        } else {
            $('#total_kwh').val(totalKwh.toFixed(2) + ' kWh');
            $('#meter_akhir').removeClass('is-invalid');
        }
    }

    $('#meter_awal, #meter_akhir').on('input', calculateKwh);

    // Validasi saat submit
    $('#formPenggunaan').on('submit', function(e) {
        const meterAwal = parseFloat($('#meter_awal').val()) || 0;
        const meterAkhir = parseFloat($('#meter_akhir').val()) || 0;
        
        if (meterAkhir <= meterAwal) {
            e.preventDefault();
            alert('Meter akhir harus lebih besar dari meter awal!');
            return false;
        }
    });

    // Initial calculation
    calculateKwh();
</script>
@endpush
