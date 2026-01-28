@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-edit"></i> Edit Pelanggan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">ID Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $pelanggan->id_pelanggan }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelanggan" class="form-control" 
                               value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" 
                               value="{{ old('no_telepon', $pelanggan->no_telepon) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ old('email', $pelanggan->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daya Listrik <span class="text-danger">*</span></label>
                        <select name="id_daya_listrik" class="form-select" required>
                            @foreach($dayaListrik as $daya)
                                <option value="{{ $daya->id_daya_listrik }}" 
                                        {{ old('id_daya_listrik', $pelanggan->id_daya_listrik) == $daya->id_daya_listrik ? 'selected' : '' }}>
                                    {{ $daya->daya_watt }} VA - {{ $daya->tarif->nama_tarif }} 
                                    (Rp {{ number_format($daya->tarif->tarif_per_kwh, 0, ',', '.') }}/kWh)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" {{ old('status', $pelanggan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $pelanggan->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="Suspend" {{ old('status', $pelanggan->status) == 'Suspend' ? 'selected' : '' }}>Suspend</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
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
