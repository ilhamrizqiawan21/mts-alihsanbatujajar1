<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $activeYear = null;
        $stats = [
            'kelas' => 0,
            'siswa' => 0,
            'absensi' => 0,
            'pelanggaran' => 0,
        ];
        $recentStudents = collect();
        $recentViolations = collect();
        $todayAbsensi = 0;
        $todayStatusCounts = [];

        try {
            $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();
            $stats = [
                'kelas' => Kelas::query()->count(),
                'siswa' => Siswa::query()->count(),
                'absensi' => Absensi::query()->count(),
                'pelanggaran' => Pelanggaran::query()->count(),
            ];

            $recentStudents = Siswa::query()->with('kelas')->latest()->take(5)->get();
            $recentViolations = Pelanggaran::query()
                ->with(['siswa', 'jenisPelanggaran'])
                ->latest()
                ->take(5)
                ->get();

            $todayAbsensi = Absensi::query()->whereDate('tanggal', now())->count();
            $todayStatusCounts = Absensi::query()
                ->select('status', DB::raw('count(*) as total'))
                ->whereDate('tanggal', now())
                ->groupBy('status')
                ->pluck('total', 'status')
                ->all();
        } catch (\Throwable) {
            // Tetap tampilkan halaman dashboard dengan data kosong sampai tabel server siap.
        }

        return view('home', compact('activeYear', 'stats', 'recentStudents', 'recentViolations', 'todayAbsensi', 'todayStatusCounts'));
    }
}
