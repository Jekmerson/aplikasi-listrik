@extends('layouts.app')

@section('title', 'Input Pembayaran')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-money-bill-wave"></i> Input Pembayaran</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Pembayaran</a></li>
            <li class="breadcrumb-item active">Input</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-receipt"></i> Form Pembayaran
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pembayaran.store') }}" id="formPembayaran">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Tagihan <span class="text-danger">*</span></label>
                        <select name="id_tagihan" id="id_tagihan" class="form-select" required>
                            <option value="">-- Pilih Tagihan --</option>
                            @foreach($tagihan as $t)
                                <option value="{{ $t->id_tagihan }}" 
                                        data-total="{{ $t->total_bayar }}"
                                        data-pelanggan="{{ $t->pelanggan->nama_pelanggan }}"
                                        data-periode="{{ $t->penggunaan->periode }}"
                                        {{ $selected_tagihan && $selected_tagihan->id_tagihan == $t->id_tagihan ? 'selected' : '' }}>
                                    #{{ $t->id_tagihan }} - {{ $t->pelanggan->nama_pelanggan }} - 
                                    {{ $t->penggunaan->periode }} - Rp {{ number_format($t->total_bayar, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" 
                               value="{{ old('jumlah_bayar', $selected_tagihan ? $selected_tagihan->total_bayar : '') }}" 
                               required min="0" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_bayar" class="form-select" required>
                            <option value="">Pilih Metode</option>
                            <option value="Tunai" {{ old('metode_bayar') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="Transfer" {{ old('metode_bayar') == 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="EDC" {{ old('metode_bayar') == 'EDC' ? 'selected' : '' }}>EDC (Debit/Credit)</option>
                            <option value="QRIS" {{ old('metode_bayar') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" id="detailTagihan" style="display: none;">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle"></i> Detail Tagihan
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Pelanggan</td>
                        <td><strong id="detail_pelanggan">-</strong></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td><strong id="detail_periode">-</strong></td>
                    </tr>
                    <tr>
                        <td>Total Tagihan</td>
                        <td><strong id="detail_total" class="text-danger">-</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#id_tagihan').change(function() {
        var selected = $(this).find(':selected');
        
        if (selected.val()) {
            var total = selected.data('total');
            var pelanggan = selected.data('pelanggan');
            var periode = selected.data('periode');
            
            $('#jumlah_bayar').val(total);
            $('#detail_pelanggan').text(pelanggan);
            $('#detail_periode').text(periode);
            $('#detail_total').text('Rp ' + total.toLocaleString('id-ID'));
            $('#detailTagihan').show();
        } else {
            $('#detailTagihan').hide();
        }
    });

    // Trigger on page load if tagihan already selected
    if ($('#id_tagihan').val()) {
        $('#id_tagihan').trigger('change');
    }
});
</script>
@endpush
