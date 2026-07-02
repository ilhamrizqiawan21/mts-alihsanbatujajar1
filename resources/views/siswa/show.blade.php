@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card page-card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-column flex-md-row">
                    <div>
                        <h2 class="fw-bold mb-1">Detail Siswa</h2>
                        <p class="text-muted mb-0">Informasi lengkap dan terbaru tentang siswa.</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">NIS</label>
                        <div class="fw-semibold">{{ $siswa->nis ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama</label>
                        <div class="fw-semibold">{{ $siswa->nama ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kelas</label>
                        <div class="fw-semibold">{{ $siswa->kelas?->nama_kelas ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Jenis Kelamin</label>
                        <div class="fw-semibold">{{ $siswa->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tempat / Tanggal Lahir</label>
                        <div class="fw-semibold">{{ $siswa->tempat_lahir ?? '-' }} / {{ optional($siswa->tanggal_lahir)->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <div>
                            <span class="badge bg-{{ $siswa->status ? 'success' : 'secondary' }}">
                                {{ $siswa->status ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nomor HP Orang Tua</label>
                        <div class="fw-semibold">{{ $siswa->no_hp_ortu ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted">Alamat</label>
                        <div class="fw-semibold">{{ $siswa->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
