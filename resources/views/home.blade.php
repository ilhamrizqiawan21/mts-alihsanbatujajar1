@extends('layouts.app')

@section('title', 'Dashboard MTs Al-Ihsan')

@section('content')
<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">Total Kelas</p>
                    <h3 class="fw-bold mb-0">{{ $stats['kelas'] }}</h3>
                </div>
                <div class="icon-pill bg-primary-subtle text-primary"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">Total Siswa</p>
                    <h3 class="fw-bold mb-0">{{ $stats['siswa'] }}</h3>
                </div>
                <div class="icon-pill bg-info-subtle text-info"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">Absensi Hari Ini</p>
                    <h3 class="fw-bold mb-0">{{ $stats['absensi'] }}</h3>
                </div>
                <div class="icon-pill bg-success-subtle text-success"><i class="bi bi-calendar2-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">Pelanggaran</p>
                    <h3 class="fw-bold mb-0">{{ $stats['pelanggaran'] }}</h3>
                </div>
                <div class="icon-pill bg-warning-subtle text-warning"><i class="bi bi-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="card page-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Tahun Ajaran Aktif</h5>
                    <span class="badge badge-soft rounded-pill">{{ $activeYear ? 'Aktif' : 'Belum ditetapkan' }}</span>
                </div>
                <p class="mb-0 text-muted">
                    @if($activeYear)
                        {{ $activeYear->tahun }} - Semester {{ $activeYear->semester }}
                    @else
                        Belum ada data tahun ajaran aktif. Anda dapat menambahkan data melalui menu pengaturan.
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <h5 class="card-title">Siswa Terbaru</h5>
                <ul class="list-group list-group-flush">
                    @forelse($recentStudents as $siswa)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span>{{ $siswa->nama }}</span>
                            <small class="text-muted">{{ $siswa->kelas->nama_kelas ?? '-' }}</small>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Belum ada data siswa.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-12">
        <div class="card page-card">
            <div class="card-body">
                <h5 class="card-title">Menu Cepat</h5>
                <div class="row g-3">
                    <div class="col-md-3"><a href="{{ route('siswa.index') }}" class="btn btn-outline-primary w-100">Data Siswa</a></div>
                    <div class="col-md-3"><a href="{{ route('absensi.index') }}" class="btn btn-outline-success w-100">Absensi</a></div>
                    <div class="col-md-3"><a href="{{ route('prestasi.index') }}" class="btn btn-outline-warning w-100">Prestasi</a></div>
                    <div class="col-md-3"><a href="{{ route('pengaturan.index') }}" class="btn btn-outline-secondary w-100">Pengaturan</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
