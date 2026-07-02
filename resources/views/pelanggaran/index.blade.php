@extends('layouts.app')

@section('title', 'Pelanggaran')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Input Pelanggaran</h3>
                <form method="POST" action="{{ route('pelanggaran.store') }}">
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
                        <label class="form-label">Jenis Pelanggaran</label>
                        <select name="jenis_pelanggaran_id" class="form-select">
                            @foreach($jenisPelanggaran as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Riwayat Pelanggaran</h3>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $item)
                            <tr>
                                <td>{{ $item->siswa?->nama ?? '-' }}</td>
                                <td>{{ $item->jenisPelanggaran?->nama ?? '-' }}</td>
                                <td>{{ $item->tanggal?->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada data pelanggaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
