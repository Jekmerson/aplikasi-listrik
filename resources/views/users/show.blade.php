@extends('layouts.app')

@section('title', 'Detail User - Aplikasi Listrik Pascabayar')

@section('content')
<div class="mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> Detail User
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Username</th>
                        <td>: <strong>{{ $user->username }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $user->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>: 
                            @if($user->level->nama_level == 'Admin')
                                <span class="badge bg-danger">
                                    <i class="fas fa-crown"></i> {{ $user->level->nama_level }}
                                </span>
                            @elseif($user->level->nama_level == 'Operator')
                                <span class="badge bg-warning">
                                    <i class="fas fa-user-tie"></i> {{ $user->level->nama_level }}
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="fas fa-user"></i> {{ $user->level->nama_level }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>: {{ $user->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>: {{ $user->updated_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    
                    @if($user->id_user != auth()->id())
                        <form action="{{ route('users.toggle-active', $user->id_user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }} w-100">
                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i> 
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} User
                            </button>
                        </form>
                        
                        <form action="{{ route('users.destroy', $user->id_user) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info mb-0">
                            <small>
                                <i class="fas fa-info-circle"></i> 
                                Anda tidak dapat menonaktifkan atau menghapus akun Anda sendiri.
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
