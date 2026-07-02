@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card page-card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Tambah Siswa</h2>
                        <p class="text-muted">Masukkan data lengkap siswa baru agar pencatatan lebih mudah.</p>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <form method="POST" action="{{ route('siswa.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" required>
                            @error('nis')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                            @error('nama')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">- Pilih Kelas -</option>
                                @foreach($kelas as $item)
                                    <option value="{{ $item->id }}" @selected(old('kelas_id') == $item->id)>{{ $item->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor HP Orang Tua</label>
                            <input type="text" name="no_hp_ortu" class="form-control" value="{{ old('no_hp_ortu') }}">
                            @error('no_hp_ortu')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" @selected(old('status', '1') == '1')>Aktif</option>
                                <option value="0" @selected(old('status') == '0')>Nonaktif</option>
                            </select>
                            @error('status')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="form-text text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 text-end mt-2">
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
