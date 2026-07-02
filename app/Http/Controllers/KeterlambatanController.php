<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Keterlambatan;
use App\Models\Siswa;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeterlambatanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Keterlambatan::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

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
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('keterlambatan.index', compact('records', 'siswas', 'kelasList', 'activeYear', 'request'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = Keterlambatan::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

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
        $pdf = Pdf::loadView('exports.keterlambatan', compact('records'));

        return $pdf->download('keterlambatan.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = Keterlambatan::query()->with(['siswa.kelas', 'tahunAjaran'])->latest();

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
                $record->tanggal?->format('Y-m-d') ?? '-',
                $record->jam_datang,
                $record->alasan ?? '-',
                $record->keterangan ?? '-',
            ];
        }

        return XlsxExporter::download('keterlambatan.xlsx', ['Siswa', 'Kelas', 'Tanggal', 'Jam Datang', 'Alasan', 'Keterangan'], $rows);
    }

    public function edit(Keterlambatan $keterlambatan): View
    {
        $siswas = Siswa::query()->orderBy('nama')->get();

        return view('keterlambatan.edit', compact('keterlambatan', 'siswas'));
    }

    public function update(Request $request, Keterlambatan $keterlambatan): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tanggal' => ['required', 'date'],
            'jam_datang' => ['required', 'date_format:H:i'],
            'alasan' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $keterlambatan->update($data);

        return redirect()->route('keterlambatan.index')->with('success', 'Data keterlambatan berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tanggal' => ['required', 'date'],
            'jam_datang' => ['required', 'date_format:H:i'],
            'alasan' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Keterlambatan::create($data);

        return redirect()->route('keterlambatan.index')->with('success', 'Data keterlambatan berhasil disimpan.');
    }

    public function destroy(Keterlambatan $keterlambatan): RedirectResponse
    {
        $keterlambatan->delete();

        return redirect()->route('keterlambatan.index')->with('success', 'Data keterlambatan berhasil dihapus.');
    }
}
