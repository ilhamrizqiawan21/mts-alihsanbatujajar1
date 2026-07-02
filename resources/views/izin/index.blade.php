@extends('layouts.app')

@section('title', 'Izin Siswa')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Input Izin</h3>
                <form method="POST" action="{{ route('izin.store') }}">
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
                        <label class="form-label">Jenis Izin</label>
                        <select name="jenis_izin" class="form-select">
                            <option value="pulang">Pulang</option>
                            <option value="biasa">Biasa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan</label>
                        <select name="alasan_pulang" class="form-select">
                            <option value="">- Pilih alasan -</option>
                            <option value="sakit">Sakit</option>
                            <option value="keluarga">Keluarga</option>
                            <option value="lomba">Lomba</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
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
                <h3 class="fw-bold mb-3">Riwayat Izin</h3>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($izins as $item)
                            <tr>
                                <td>{{ $item->siswa?->nama ?? '-' }}</td>
                                <td>{{ $item->tanggal?->format('d-m-Y') }}</td>
                                <td>{{ $item->jenis_izin }}</td>
                                <td><span class="badge bg-info">Tercatat</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data izin.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
