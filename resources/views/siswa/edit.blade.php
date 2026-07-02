@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-1">Edit Siswa</h2>
                <p class="text-muted">Perbarui data siswa yang dipilih.</p>
                <form method="POST" action="{{ route('siswa.update', $siswa) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">- Pilih Kelas -</option>
                                @foreach($kelas as $item)
                                    <option value="{{ $item->id }}" @selected(old('kelas_id', $siswa->kelas_id) == $item->id)>{{ $item->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'P')>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" @selected(old('status', $siswa->status) == 1)>Aktif</option>
                                <option value="0" @selected(old('status', $siswa->status) == 0)>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $siswa->alamat) }}">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
