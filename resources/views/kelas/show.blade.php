@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Detail Kelas</h2>
                        <p class="text-muted mb-0">Informasi lengkap data kelas</p>
                    </div>
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama Kelas</label>
                        <div class="fw-semibold">{{ $kelas->nama_kelas ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Wali Kelas</label>
                        <div class="fw-semibold">{{ $kelas->wali_kelas ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
