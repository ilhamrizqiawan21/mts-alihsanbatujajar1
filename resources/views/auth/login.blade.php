@extends('layouts.app')

@section('title', 'Masuk ke Sistem')

@section('content')
<div class="auth-card">
    <div class="row g-0">
        <div class="col-lg-6 auth-hero">
            <div class="d-flex flex-column h-100 justify-content-between">
                <div>
                    <span class="badge rounded-pill bg-white text-primary mb-3">Sistem Informasi Madrasah</span>
                    <h2 class="fw-bold mb-3">Kelola data sekolah dengan cepat dan aman.</h2>
                    <p class="mb-0 text-white-50">Pantau siswa, absensi, pelanggaran, prestasi, dan kebutuhan administrasi sekolah dalam satu dashboard modern.</p>
                </div>
                <div class="mt-4">
                    <div class="d-flex align-items-center gap-2 text-white-50">
                        <i class="bi bi-shield-lock"></i>
                        <span>Autentikasi sederhana untuk admin dan operator</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 p-4 p-lg-5">
            <div class="d-flex flex-column h-100 justify-content-center">
                <div class="text-center mb-4">
                    <div class="auth-brand-icon mx-auto mb-3">AI</div>
                    <h4 class="fw-bold mb-1">Masuk ke MTs Al-Ihsan</h4>
                    <p class="text-muted mb-0">Silakan gunakan akun Anda untuk melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input name="username" value="{{ old('username') }}" class="form-control form-control-lg" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input name="password" type="password" class="form-control form-control-lg" placeholder="Masukkan password" required>
                    </div>
                    <button class="btn btn-primary btn-lg w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
