@extends('layouts.app')

@section('title', 'Kelola User - Aplikasi Listrik Pascabayar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">
        <i class="fas fa-user-cog"></i> Kelola User
    </h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar User Sistem</h5>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->username }}</strong>
                            </td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>
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
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('users.show', $user->id_user) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id_user) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id_user != auth()->id())
                                        <form action="{{ route('users.toggle-active', $user->id_user) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }}" 
                                                    title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id_user) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada data user.
            </div>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card stat-card border-danger">
            <div class="card-body">
                <h6 class="text-muted">Total Admin</h6>
                <h3>{{ $users->where('level.nama_level', 'Admin')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-warning">
            <div class="card-body">
                <h6 class="text-muted">Total Operator</h6>
                <h3>{{ $users->where('level.nama_level', 'Operator')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-info">
            <div class="card-body">
                <h6 class="text-muted">Total Pelanggan</h6>
                <h3>{{ $users->where('level.nama_level', 'Pelanggan')->count() }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
