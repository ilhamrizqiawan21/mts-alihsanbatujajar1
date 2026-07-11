@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="card page-card mb-4">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Pilih Kelas</label>
                <select class="form-select" onchange="window.location='{{ url('absensi') }}?kelas_id=' + this.value + '&bulan={{ $selectedMonth }}&tahun={{ $selectedYear }}'">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun Pelajaran</label>
                <input type="text" class="form-control" value="{{ $activeYear?->tahun ?? '-' }}" disabled>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Bulan</label>
                <select class="form-select" onchange="window.location='{{ url('absensi') }}?kelas_id={{ $selectedKelas }}&bulan=' + this.value + '&tahun={{ $selectedYear }}'">
                    @for($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                            {{ \Illuminate\Support\Carbon::create(2000, $month, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <a href="{{ route('absensi.exportPdf', ['kelas_id' => $selectedKelas, 'bulan' => $selectedMonth, 'tahun' => $selectedYear]) }}" class="btn btn-outline-danger w-100">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('absensi.store') }}" method="POST" id="attendanceForm">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
    <input type="hidden" name="bulan" value="{{ $selectedMonth }}">
    <input type="hidden" name="tahun" value="{{ $selectedYear }}">
    <div class="card page-card attendance-card">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div>
                    <h3 class="fw-bold mb-1">Input Absensi Bulanan</h3>
                    <p class="text-muted mb-0">{{ $monthLabel }} · {{ $activeYear?->tahun ?? 'Tanpa tahun ajaran aktif' }}</p>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="attendance-legend">
                        <span><strong>H</strong> Hadir</span>
                        <span><strong>I</strong> Izin</span>
                        <span><strong>S</strong> Sakit</span>
                        <span><strong>A</strong> Alfa</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" id="attendanceSubmit">
                        <i class="bi bi-save"></i> <span>Simpan</span>
                    </button>
                </div>
            </div>

            <div class="table-responsive attendance-table-wrap">
                <table class="table table-bordered align-middle mb-0 attendance-table">
                    <thead class="table-light">
                        <tr>
                            <th class="attendance-sticky attendance-no">No.</th>
                            <th class="attendance-sticky attendance-name">Nama Siswa</th>
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                <th class="text-center attendance-day">{{ $day }}</th>
                            @endfor
                        </tr>
                        <tr class="table-secondary">
                            <th colspan="2" class="fw-semibold">Bulk Action</th>
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                <th class="text-center p-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-success btn-bulk" data-status="H" data-day="{{ $day }}">H</button>
                                        <button type="button" class="btn btn-outline-info btn-bulk" data-status="I" data-day="{{ $day }}">I</button>
                                        <button type="button" class="btn btn-outline-warning btn-bulk" data-status="S" data-day="{{ $day }}">S</button>
                                        <button type="button" class="btn btn-outline-danger btn-bulk" data-status="A" data-day="{{ $day }}">A</button>
                                    </div>
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td class="fw-semibold text-muted attendance-sticky attendance-no">{{ $index + 1 }}</td>
                                <td class="attendance-sticky attendance-name">
                                    <div class="fw-semibold">{{ $siswa->nama }}</div>
                                    <small class="text-muted">{{ $siswa->kelas->nama_kelas ?? '-' }}</small>
                                </td>
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $date = \Illuminate\Support\Carbon::create($selectedYear, $selectedMonth, $day)->toDateString();
                                        $record = $attendanceMap[$siswa->id][$date] ?? null;
                                    @endphp
                                    <td class="text-center">
                                        <select class="form-select form-select-sm text-center attendance-select" name="status[{{ $siswa->id }}][{{ $date }}]" data-day="{{ $day }}" aria-label="Absensi {{ $siswa->nama }} tanggal {{ $day }}">
                                            <option value="" {{ is_null($record) ? 'selected' : '' }}>-</option>
                                            <option value="H" {{ ($record->status ?? '') === 'H' ? 'selected' : '' }}>H</option>
                                            <option value="I" {{ ($record->status ?? '') === 'I' ? 'selected' : '' }}>I</option>
                                            <option value="S" {{ ($record->status ?? '') === 'S' ? 'selected' : '' }}>S</option>
                                            <option value="A" {{ ($record->status ?? '') === 'A' ? 'selected' : '' }}>A</option>
                                        </select>
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + $daysInMonth }}" class="text-center text-muted py-4">Belum ada data siswa untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('attendanceForm');
        const submitButton = document.getElementById('attendanceSubmit');

        document.querySelectorAll('.btn-bulk').forEach(function (button) {
            button.addEventListener('click', function () {
                const status = this.dataset.status;
                const day = this.dataset.day;

                document.querySelectorAll('.attendance-select[data-day="' + day + '"]').forEach(function (select) {
                    select.value = status;
                });
            });
        });

        if (form && submitButton) {
            form.addEventListener('submit', function () {
                submitButton.disabled = true;
                submitButton.querySelector('span').textContent = 'Menyimpan...';
                submitButton.insertAdjacentHTML('afterbegin', '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>');
            });
        }
    });
</script>
@endsection
