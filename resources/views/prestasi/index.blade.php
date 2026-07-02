@extends('layouts.app')

@section('title', 'Prestasi Siswa')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Input Prestasi</h3>
                <form method="POST" action="{{ route('prestasi.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-select">
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Prestasi</label>
                        <input type="text" name="nama_prestasi" class="form-control" placeholder="Contoh: Lomba Debat">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat Prestasi</label>
                        <select name="tingkat_prestasi_id" class="form-select">
                            @foreach($tingkatPrestasi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Juara</label>
                        <input type="text" name="juara" class="form-control" placeholder="Contoh: 1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Daftar Prestasi</h3>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Prestasi</th>
                            <th>Tingkat</th>
                            <th>Juara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ $record->siswa?->nama ?? '-' }}</td>
                                <td>{{ $record->nama_prestasi }}</td>
                                <td>{{ $record->tingkatPrestasi?->nama ?? '-' }}</td>
                                <td>{{ $record->juara ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data prestasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
