@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-users"></i> Data Pelanggan</h1>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pelanggan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Search & Filter -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="Suspend" {{ request('status') == 'Suspend' ? 'selected' : '' }}>Suspend</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Pelanggan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Daya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $p)
                        <tr>
                            <td><strong>{{ $p->id_pelanggan }}</strong></td>
                            <td>{{ $p->nama_pelanggan }}</td>
                            <td>{{ Str::limit($p->alamat, 40) }}</td>
                            <td>{{ $p->no_telepon ?: '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $p->dayaListrik->daya_watt }} VA</span>
                            </td>
                            <td>
                                @if($p->status == 'Aktif')
                                    <span class="badge bg-success">{{ $p->status }}</span>
                                @elseif($p->status == 'Nonaktif')
                                    <span class="badge bg-secondary">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pelanggan.show', $p->id_pelanggan) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $pelanggan->links() }}
        </div>
    </div>
</div>
@endsection
