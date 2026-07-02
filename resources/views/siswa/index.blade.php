@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Siswa</h2>
        <p class="text-muted mb-0">Kelola data siswa MTs Al-Ihsan</p>
    </div>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary rounded-pill px-4">Tambah Siswa</a>
</div>

<div class="card page-card">
    <div class="card-body p-4">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>
                            <div class="fw-semibold">{{ $siswa->nama }}</div>
                            <small class="text-muted">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                        </td>
                        <td>{{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $siswa->status ? 'success' : 'secondary' }}">
                                {{ $siswa->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
