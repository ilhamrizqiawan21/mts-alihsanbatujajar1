@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-1">Edit Kelas</h2>
                <p class="text-muted">Perbarui data kelas yang dipilih.</p>
                <form method="POST" action="{{ route('kelas.update', $kelas) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control" value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
