@extends('layouts.app')

@section('title', 'Edit Izin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Edit Izin</h3>
                <form method="POST" action="{{ route('izin.update', $izin) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-select">
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ $izin->siswa_id == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $izin->tanggal?->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Izin</label>
                        <select name="jenis_izin" class="form-select">
                            <option value="pulang" {{ $izin->jenis_izin == 'pulang' ? 'selected' : '' }}>Pulang</option>
                            <option value="biasa" {{ $izin->jenis_izin == 'biasa' ? 'selected' : '' }}>Biasa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <select name="alasan_pulang" class="form-select">
                            <option value="">- Pilih alasan -</option>
                            <option value="sakit" {{ $izin->alasan_pulang == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="keluarga" {{ $izin->alasan_pulang == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                            <option value="lomba" {{ $izin->alasan_pulang == 'lomba' ? 'selected' : '' }}>Lomba</option>
                            <option value="lainnya" {{ $izin->alasan_pulang == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ $izin->keterangan }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('izin.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
