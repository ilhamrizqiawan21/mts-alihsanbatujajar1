@extends('layouts.app')

@section('title', 'Keterlambatan')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Input Keterlambatan</h3>
                <form method="POST" action="{{ route('keterlambatan.store') }}">
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
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Datang</label>
                        <input type="time" name="jam_datang" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <input type="text" name="alasan" class="form-control" placeholder="Contoh: macet">
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
                <h3 class="fw-bold mb-3">Riwayat Keterlambatan</h3>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ $record->siswa?->nama ?? '-' }}</td>
                                <td>{{ $record->tanggal?->format('d-m-Y') }}</td>
                                <td>{{ $record->jam_datang }}</td>
                                <td>{{ $record->alasan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data keterlambatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
