@extends('layouts.app')

@section('title', 'Dashboard MTs Al-Ihsan')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card page-card dashboard-hero">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h4 class="fw-bold mb-2">Selamat datang, {{ session('user_name', 'Administrator') }}!</h4>
                        <p class="text-muted mb-3">Cek ringkasan harian, data siswa, dan aktivitas sekolah secara cepat dari satu tampilan.</p>
                        <div class="d-flex flex-wrap gap-2 dashboard-quick-info">
                            <span class="badge badge-soft">Kelas: {{ $stats['kelas'] }}</span>
                            <span class="badge badge-soft">Siswa: {{ $stats['siswa'] }}</span>
                            <span class="badge badge-soft">Total Absensi: {{ $stats['absensi'] }}</span>
                            <span class="badge badge-soft">Pelanggaran: {{ $stats['pelanggaran'] }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="dashboard-hero-icon">
                            <i class="bi bi-kanban-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <h3 class="fw-bold mb-0">{{ $todayAbsensi }}</h3>
                </div>
                <div class="icon-pill bg-success-subtle text-success"><i class="bi bi-calendar2-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1">Pelanggaran Terbaru</p>
                    <h3 class="fw-bold mb-0">{{ $recentViolations->count() }}</h3>
                </div>
                <div class="icon-pill bg-warning-subtle text-warning"><i class="bi bi-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Tahun Ajaran Aktif</h5>
                    <span class="badge badge-soft rounded-pill">{{ $activeYear ? 'Aktif' : 'Belum ditetapkan' }}</span>
                </div>
                <p class="mb-3 text-muted">
                    @if($activeYear)
                        {{ $activeYear->tahun }} - Semester {{ $activeYear->semester }}
                    @else
                        Data tahun ajaran belum ada. Lengkapi di pengaturan sekolah.
                    @endif
                </p>
                <a href="{{ route('pengaturan.index') }}" class="btn btn-sm btn-primary">Atur Tahun Ajaran</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Absensi Hari Ini</h5>
                    <span class="badge bg-success rounded-pill">{{ $todayAbsensi }} data</span>
                </div>
                @if($todayAbsensi > 0)
                    <div class="d-flex flex-column gap-2">
                        @foreach($todayStatusCounts as $status => $count)
                            <div class="d-flex justify-content-between align-items-center status-pill">
                                <span class="text-capitalize">{{ $status ?? 'Lainnya' }}</span>
                                <strong>{{ $count }}</strong>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mb-0 text-muted">Belum ada absensi untuk hari ini. Pastikan guru mengisi kehadiran di menu Absensi.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card page-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Pelanggaran Terbaru</h5>
                    <span class="badge bg-warning text-dark rounded-pill">{{ $recentViolations->count() }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentViolations as $violation)
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $violation->siswa->nama ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $violation->jenisPelanggaran->nama ?? 'Jenis belum tersedia' }}</small>
                            </div>
                            <small class="text-muted">{{ optional($violation->tanggal)->format('d M') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Tidak ada pelanggaran terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-6">
        <div class="card page-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Siswa Terbaru</h5>
                    <span class="text-muted">{{ $recentStudents->count() }} item</span>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentStudents as $siswa)
                        <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $siswa->nama }}</div>
                                <small class="text-muted">{{ $siswa->kelas->nama_kelas ?? '-' }}</small>
                            </div>
                            <span class="badge bg-info text-dark rounded-pill">Baru</span>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Belum ada data siswa.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card page-card h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">Menu Cepat</h5>
                <div class="row g-3">
                    <div class="col-6"><a href="{{ route('siswa.index') }}" class="btn btn-outline-primary w-100">Data Siswa</a></div>
                    <div class="col-6"><a href="{{ route('absensi.index') }}" class="btn btn-outline-success w-100">Absensi</a></div>
                    <div class="col-6"><a href="{{ route('pelanggaran.index') }}" class="btn btn-outline-warning w-100">Pelanggaran</a></div>
                    <div class="col-6"><a href="{{ route('pengaturan.index') }}" class="btn btn-outline-secondary w-100">Pengaturan</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
