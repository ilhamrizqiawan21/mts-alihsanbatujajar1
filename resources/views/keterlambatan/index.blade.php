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
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="nama" class="form-control form-control-sm" placeholder="Cari nama siswa" value="{{ $request->nama ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-select form-select-sm">
                            <option value="">Semua kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ ($request->kelas_id ?? '') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="bulan" class="form-select form-select-sm">
                            <option value="">Semua bulan</option>
                            @for($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}" {{ ($request->bulan ?? '') == $month ? 'selected' : '' }}>{{ \Illuminate\Support\Carbon::create(2000, $month, 1)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                        <a href="{{ route('keterlambatan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('keterlambatan.exportPdf', request()->query()) }}" class="btn btn-sm btn-outline-danger">Export PDF</a>
                        <a href="{{ route('keterlambatan.exportXlsx', request()->query()) }}" class="btn btn-sm btn-outline-success">Export XLSX</a>
                    </div>
                </form>
                <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Alasan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $index => $record)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $records->firstItem() + $index }}</td>
                                <td>{{ $record->siswa?->nama ?? '-' }}</td>
                                <td>{{ $record->siswa?->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $record->tanggal?->format('d-m-Y') }}</td>
                                <td>{{ $record->jam_datang }}</td>
                                <td>{{ $record->alasan ?? '-' }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1 flex-wrap">
                                        <a href="{{ route('keterlambatan.edit', $record) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form action="{{ route('keterlambatan.destroy', $record) }}" method="POST" data-confirm-message="Hapus data keterlambatan ini?" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data keterlambatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
