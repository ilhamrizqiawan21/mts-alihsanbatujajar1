<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaran;
use App\Models\TingkatPrestasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Prestasi::query()->with(['siswa.kelas', 'tingkatPrestasi'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->paginate(10)->appends($request->query());
        $siswas = Siswa::query()->orderBy('nama')->get();
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();
        $tingkatPrestasi = TingkatPrestasi::query()->orderBy('id')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('prestasi.index', compact('records', 'siswas', 'kelasList', 'tingkatPrestasi', 'activeYear', 'request'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = Prestasi::query()->with(['siswa.kelas', 'tingkatPrestasi'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->get();
        $pdf = Pdf::loadView('exports.prestasi', compact('records'));

        return $pdf->download('prestasi.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = Prestasi::query()->with(['siswa.kelas', 'tingkatPrestasi'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', fn ($q) => $q->where('nama', 'like', '%' . $request->nama . '%'));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->get();
        $rows = [];

        foreach ($records as $record) {
            $rows[] = [
                $record->siswa?->nama ?? '-',
                $record->siswa?->kelas?->nama_kelas ?? '-',
                $record->nama_prestasi,
                $record->tingkatPrestasi?->nama ?? '-',
                $record->juara ?? '-',
                $record->tanggal?->format('Y-m-d') ?? '-',
                $record->penyelenggara ?? '-',
                $record->keterangan ?? '-',
            ];
        }

        return XlsxExporter::download('prestasi.xlsx', ['Siswa', 'Kelas', 'Prestasi', 'Tingkat', 'Juara', 'Tanggal', 'Penyelenggara', 'Keterangan'], $rows);
    }

    public function edit(Prestasi $prestasi): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();
        $tingkatPrestasi = TingkatPrestasi::query()->orderBy('id')->get();

        return view('prestasi.edit', compact('prestasi', 'siswas', 'tingkatPrestasi'));
    }

    public function update(Request $request, Prestasi $prestasi): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'nama_prestasi' => ['required', 'string', 'max:200'],
            'tingkat_prestasi_id' => ['required', 'integer', 'exists:tingkat_prestasi,id'],
            'juara' => ['nullable', 'string', 'max:50'],
            'tanggal' => ['required', 'date'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $prestasi->update($data);

        return redirect()->route('prestasi.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'nama_prestasi' => ['required', 'string', 'max:200'],
            'tingkat_prestasi_id' => ['required', 'integer', 'exists:tingkat_prestasi,id'],
            'juara' => ['nullable', 'string', 'max:50'],
            'tanggal' => ['required', 'date'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Prestasi::create($data);

        return redirect()->route('prestasi.index')->with('success', 'Data prestasi berhasil disimpan.');
    }

    public function destroy(Prestasi $prestasi): RedirectResponse
    {
        $prestasi->delete();

        return redirect()->route('prestasi.index')->with('success', 'Data prestasi berhasil dihapus.');
    }
}
