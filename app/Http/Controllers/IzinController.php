<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SuratIzin;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IzinController extends Controller
{
    public function index(Request $request): View
    {
        $query = SuratIzin::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $izins = $query->paginate(10)->appends($request->query());
        $siswas = Siswa::query()->orderBy('nama')->get();
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('izin.index', compact('izins', 'siswas', 'kelasList', 'activeYear', 'request'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = SuratIzin::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $izins = $query->get();
        $pdf = Pdf::loadView('exports.izin', compact('izins'));

        return $pdf->download('izin.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = SuratIzin::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $izins = $query->get();
        $rows = [];

        foreach ($izins as $item) {
            $rows[] = [
                $item->siswa?->nama ?? '-',
                $item->siswa?->kelas?->nama_kelas ?? '-',
                $item->tanggal?->format('Y-m-d') ?? '-',
                ucfirst($item->jenis_izin),
                $item->alasan_pulang ?? $item->alasan_biasa ?? '-',
                $item->keterangan ?? '-',
            ];
        }

        return XlsxExporter::download('izin.xlsx', ['Siswa', 'Kelas', 'Tanggal', 'Jenis Izin', 'Alasan', 'Keterangan'], $rows);
    }

    public function edit(SuratIzin $izin): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();

        return view('izin.edit', compact('izin', 'siswas', 'kelasList'));
    }

    public function update(Request $request, SuratIzin $izin): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'jenis_izin' => ['required', 'in:pulang,biasa'],
            'tanggal' => ['required', 'date'],
            'jam_berangkat' => ['nullable', 'date_format:H:i'],
            'alasan_pulang' => ['nullable', 'in:sakit,keluarga,lomba,lainnya'],
            'alasan_biasa' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $izin->update($data);

        return redirect()->route('izin.index')->with('success', 'Data izin berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'jenis_izin' => ['required', 'in:pulang,biasa'],
            'tanggal' => ['required', 'date'],
            'jam_berangkat' => ['nullable', 'date_format:H:i'],
            'alasan_pulang' => ['nullable', 'in:sakit,keluarga,lomba,lainnya'],
            'alasan_biasa' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        SuratIzin::create($data);

        return redirect()->route('izin.index')->with('success', 'Data izin berhasil disimpan.');
    }

    public function destroy(SuratIzin $izin): RedirectResponse
    {
        $izin->delete();

        return redirect()->route('izin.index')->with('success', 'Data izin berhasil dihapus.');
    }
}
