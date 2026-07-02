@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Kelas</h2>
        <p class="text-muted mb-0">Daftar kelas dan wali kelas</p>
    </div>
    <a href="{{ route('kelas.create') }}" class="btn btn-primary rounded-pill px-4">Tambah Kelas</a>
</div>

<div class="card page-card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-1">Daftar Kelas</h5>
                <p class="text-muted small mb-0">Kelola data kelas beserta wali kelas</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('kelas.exportPdf') }}" class="btn btn-outline-danger btn-sm">Export PDF</a>
                <a href="{{ route('kelas.exportXlsx') }}" class="btn btn-outline-success btn-sm">Export XLSX</a>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">{{ $kelas->total() }} data</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th class="text-end" style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $item)
                        <tr>
                            <td class="fw-semibold text-muted">{{ $kelas->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_kelas }}</div>
                                <small class="text-muted">Data kelas terdaftar</small>
                            </td>
                            <td>{{ $item->wali_kelas ?? '-' }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('kelas.show', $item->id) }}" class="btn btn-sm btn-outline-info">Detail</a>
                                    <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data kelas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kelas->hasPages())
            <div class="mt-4 d-flex justify-content-end">
                {{ $kelas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
