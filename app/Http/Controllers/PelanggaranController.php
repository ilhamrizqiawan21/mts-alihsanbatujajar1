<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pelanggaran::query()->with(['siswa.kelas', 'jenisPelanggaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pelanggarans = $query->paginate(10)->appends($request->query());
        $siswas = Siswa::query()->orderBy('nama')->get();
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();
        $jenisPelanggaran = JenisPelanggaran::query()->orderBy('nama')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('pelanggaran.index', compact('pelanggarans', 'siswas', 'kelasList', 'jenisPelanggaran', 'activeYear', 'request'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = Pelanggaran::query()->with(['siswa.kelas', 'jenisPelanggaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pelanggarans = $query->get();
        $pdf = Pdf::loadView('exports.pelanggaran', compact('pelanggarans'));

        return $pdf->download('pelanggaran.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = Pelanggaran::query()->with(['siswa.kelas', 'jenisPelanggaran'])->latest();

        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pelanggarans = $query->get();
        $rows = [];

        foreach ($pelanggarans as $item) {
            $rows[] = [
                $item->siswa?->nama ?? '-',
                $item->siswa?->kelas?->nama_kelas ?? '-',
                $item->jenisPelanggaran?->nama ?? '-',
                $item->tanggal?->format('Y-m-d') ?? '-',
                $item->keterangan ?? '-',
            ];
        }

        return XlsxExporter::download('pelanggaran.xlsx', ['Siswa', 'Kelas', 'Jenis Pelanggaran', 'Tanggal', 'Keterangan'], $rows);
    }

    public function edit(Pelanggaran $pelanggaran): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();
        $jenisPelanggaran = JenisPelanggaran::query()->orderBy('nama')->get();

        return view('pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisPelanggaran'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'jenis_pelanggaran_id' => ['required', 'integer', 'exists:jenis_pelanggaran,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $pelanggaran->update($data);

        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'jenis_pelanggaran_id' => ['required', 'integer', 'exists:jenis_pelanggaran,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Pelanggaran::create($data);

        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil disimpan.');
    }

    public function destroy(Pelanggaran $pelanggaran): RedirectResponse
    {
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
