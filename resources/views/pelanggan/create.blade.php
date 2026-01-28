@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="mb-4">
    <h1 class="page-title"><i class="fas fa-user-plus"></i> Tambah Pelanggan Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pelanggan.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">ID Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $nextId }}" disabled>
                        <small class="text-muted">ID akan dibuat otomatis</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelanggan" class="form-control" 
                               value="{{ old('nama_pelanggan') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" 
                               value="{{ old('no_telepon') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Daya Listrik <span class="text-danger">*</span></label>
                        <select name="id_daya_listrik" class="form-select" required>
                            <option value="">Pilih Daya Listrik</option>
                            @foreach($dayaListrik as $daya)
                                <option value="{{ $daya->id_daya_listrik }}" 
                                        {{ old('id_daya_listrik') == $daya->id_daya_listrik ? 'selected' : '' }}>
                                    {{ $daya->daya_watt }} VA - {{ $daya->tarif->nama_tarif }} 
                                    (Rp {{ number_format($daya->tarif->tarif_per_kwh, 0, ',', '.') }}/kWh)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Registrasi <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_registrasi" class="form-control" 
                               value="{{ old('tanggal_registrasi', date('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="create_user_account" 
                                   id="create_user_account" {{ old('create_user_account') ? 'checked' : '' }}>
                            <label class="form-check-label" for="create_user_account">
                                Buat akun user untuk pelanggan ini
                            </label>
                            <div class="form-text">
                                Username: ID Pelanggan, Password default: password123
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
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
