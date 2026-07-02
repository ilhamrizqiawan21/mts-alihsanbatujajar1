@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-1">Tambah Kelas</h2>
                <p class="text-muted">Masukkan data kelas baru.</p>
                <form method="POST" action="{{ route('kelas.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary ms-2">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
