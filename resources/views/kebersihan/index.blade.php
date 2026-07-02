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
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ $record->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $record->tanggal?->format('d-m-Y') }}</td>
                                <td>{{ $record->nilai_lantai + $record->nilai_sampah + $record->nilai_rak + $record->nilai_penataan }}</td>
                                <td>{{ $record->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data kebersihan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
