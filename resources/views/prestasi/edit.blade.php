@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Edit Prestasi</h3>
                <form method="POST" action="{{ route('prestasi.update', $prestasi) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-select">
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ $prestasi->siswa_id == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Prestasi</label>
                        <input type="text" name="nama_prestasi" class="form-control" value="{{ $prestasi->nama_prestasi }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat Prestasi</label>
                        <select name="tingkat_prestasi_id" class="form-select">
                            @foreach($tingkatPrestasi as $item)
                                <option value="{{ $item->id }}" {{ $prestasi->tingkat_prestasi_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Juara</label>
                        <input type="text" name="juara" class="form-control" value="{{ $prestasi->juara }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $prestasi->tanggal?->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control" value="{{ $prestasi->penyelenggara }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $prestasi->keterangan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('prestasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
