@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Siswa</h2>
        <p class="text-muted mb-0">Kelola semua siswa, lihat detail, dan lakukan pembaruan data dengan cepat.</p>
    </div>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary rounded-pill px-4">Tambah Siswa</a>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card page-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Total Siswa</small>
                    <h4 class="fw-bold mb-0">{{ $siswas->total() }}</h4>
                </div>
                <i class="bi bi-people-fill fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card page-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Aktif</small>
                    <h4 class="fw-bold mb-0">{{ $siswas->where('status', 1)->count() }}</h4>
                </div>
                <i class="bi bi-check-circle-fill fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card page-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Nonaktif</small>
                    <h4 class="fw-bold mb-0">{{ $siswas->where('status', 0)->count() }}</h4>
                </div>
                <i class="bi bi-slash-circle-fill fs-2 text-secondary"></i>
            </div>
        </div>
    </div>
</div>

<div class="card page-card">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
            <div>
                <div class="text-muted">Menampilkan {{ $siswas->count() }} dari {{ $siswas->total() }} siswa</div>
                <div class="text-muted">Halaman {{ $siswas->currentPage() }} / {{ $siswas->lastPage() }}</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('siswa.exportPdf') }}" class="btn btn-outline-danger btn-sm">Export PDF</a>
                <a href="{{ route('siswa.exportXlsx') }}" class="btn btn-outline-success btn-sm">Export XLSX</a>
                <a href="{{ route('siswa.create') }}" class="btn btn-outline-primary btn-sm">Tambah Siswa</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Kembali ke Dashboard</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                        <tr>
                            <td class="fw-semibold">{{ $siswa->nis }}</td>
                            <td>
                                <div class="fw-semibold">{{ $siswa->nama }}</div>
                                <small class="text-muted">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                            </td>
                            <td>{{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
                            <td>{{ $siswa->no_hp_ortu ?? '-' }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $siswa->status ? 'success' : 'secondary' }}">
                                    {{ $siswa->status ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1 flex-wrap">
                                    <a href="{{ route('siswa.show', $siswa) }}" class="btn btn-sm btn-outline-info">Lihat</a>
                                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" data-confirm-message="Hapus siswa ini?" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
            <div class="text-muted">Gunakan tombol aksi untuk melihat, mengubah, atau menghapus siswa.</div>
            <div>{!! $siswas->links() !!}</div>
        </div>
    </div>
</div>
@endsection
