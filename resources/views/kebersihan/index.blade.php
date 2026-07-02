@extends('layouts.app')

@section('title', 'Kebersihan Kelas')

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Nilai Kebersihan Kelas</h3>
                <form method="POST" action="{{ route('kebersihan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select">
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="row g-3">
                        @foreach(['nilai_lantai' => 'Lantai', 'nilai_sampah' => 'Sampah', 'nilai_rak' => 'Rak', 'nilai_penataan' => 'Penataan'] as $field => $label)
                            <div class="col-md-6">
                                <label class="form-label">{{ $label }}</label>
                                <select name="{{ $field }}" class="form-select">
                                    @for($i=0; $i<=5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3 mt-3">
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
                <h3 class="fw-bold mb-3">Rekap Kebersihan</h3>
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <select name="kelas_id" class="form-select form-select-sm">
                            <option value="">Semua kelas</option>
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}" {{ ($request->kelas_id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="bulan" class="form-select form-select-sm">
                            <option value="">Semua bulan</option>
                            @for($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}" {{ ($request->bulan ?? '') == $month ? 'selected' : '' }}>{{ \Illuminate\Support\Carbon::create(2000, $month, 1)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                        <a href="{{ route('kebersihan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('kebersihan.exportPdf', request()->query()) }}" class="btn btn-sm btn-outline-danger">Export PDF</a>
                        <a href="{{ route('kebersihan.exportXlsx', request()->query()) }}" class="btn btn-sm btn-outline-success">Export XLSX</a>
                    </div>
                </form>
                <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $index => $record)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $records->firstItem() + $index }}</td>
                                <td>{{ $record->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $record->tanggal?->format('d-m-Y') }}</td>
                                <td>{{ $record->nilai_lantai + $record->nilai_sampah + $record->nilai_rak + $record->nilai_penataan }}</td>
                                <td>{{ $record->keterangan ?? '-' }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1 flex-wrap">
                                        <a href="{{ route('kebersihan.edit', $record) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form action="{{ route('kebersihan.destroy', $record) }}" method="POST" onsubmit="return confirm('Hapus data kebersihan ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data kebersihan.</td></tr>
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
