@extends('layouts.app')

@section('title', 'Edit Keterlambatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Edit Keterlambatan</h3>
                <form method="POST" action="{{ route('keterlambatan.update', $keterlambatan) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-select">
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ $keterlambatan->siswa_id == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $keterlambatan->tanggal?->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Datang</label>
                        <input type="time" name="jam_datang" class="form-control" value="{{ $keterlambatan->jam_datang }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" name="alasan" class="form-control" value="{{ $keterlambatan->alasan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $keterlambatan->keterangan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('keterlambatan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
