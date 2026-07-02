<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();

        $selectedKelas = $request->input('kelas_id');
        $selectedMonth = $request->input('bulan', now()->month);
        $selectedYear = $request->input('tahun', $activeYear?->tahun ? explode('/', $activeYear->tahun)[0] : now()->year);

        $query = Siswa::query()->with('kelas')->orderBy('nama');

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        $siswas = $query->get();

        $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;
        $monthLabel = Carbon::create($selectedYear, $selectedMonth, 1)->translatedFormat('F Y');

        $attendanceMap = [];

        foreach ($siswas as $siswa) {
            $records = Absensi::query()
                ->where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $activeYear?->id)
                ->whereMonth('tanggal', $selectedMonth)
                ->whereYear('tanggal', $selectedYear)
                ->get()
                ->keyBy(fn ($item) => $item->tanggal->format('Y-m-d'));

            $attendanceMap[$siswa->id] = $records;
        }

        return view('absensi.index', compact(
            'siswas',
            'kelasList',
            'activeYear',
            'selectedKelas',
            'selectedMonth',
            'selectedYear',
            'daysInMonth',
            'monthLabel',
            'attendanceMap'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();
        $statuses = $request->input('status', []);

        foreach ($statuses as $siswaId => $dates) {
            foreach ($dates as $date => $status) {
                if ($status === '') {
                    Absensi::query()
                        ->where('siswa_id', $siswaId)
                        ->where('tahun_ajaran_id', $activeYear?->id)
                        ->whereDate('tanggal', $date)
                        ->delete();

                    continue;
                }

                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'tahun_ajaran_id' => $activeYear?->id,
                        'tanggal' => $date,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }

    public function exportPdf(Request $request)
    {
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();
        $selectedKelas = $request->input('kelas_id');
        $selectedMonth = $request->input('bulan', now()->month);
        $selectedYear = $request->input('tahun', $activeYear?->tahun ? explode('/', $activeYear->tahun)[0] : now()->year);

        $query = Siswa::query()->with('kelas')->orderBy('nama');

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        $siswas = $query->get();
        $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth;
        $monthLabel = Carbon::create($selectedYear, $selectedMonth, 1)->translatedFormat('F Y');

        $attendanceMap = [];

        foreach ($siswas as $siswa) {
            $records = Absensi::query()
                ->where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $activeYear?->id)
                ->whereMonth('tanggal', $selectedMonth)
                ->whereYear('tanggal', $selectedYear)
                ->get()
                ->keyBy(fn ($item) => $item->tanggal->format('Y-m-d'));

            $attendanceMap[$siswa->id] = $records;
        }

        $pdf = Pdf::loadView('absensi.export-pdf', compact(
            'siswas',
            'activeYear',
            'selectedKelas',
            'selectedMonth',
            'selectedYear',
            'daysInMonth',
            'monthLabel',
            'attendanceMap'
        ));

        return $pdf->download('absensi-' . $selectedYear . '-' . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}
