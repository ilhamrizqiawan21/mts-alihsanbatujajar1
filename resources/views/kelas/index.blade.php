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

<div class="card page-card">
    <div class="card-body p-4">
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $item)
                    <tr>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>{{ $item->wali_kelas ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">Belum ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
