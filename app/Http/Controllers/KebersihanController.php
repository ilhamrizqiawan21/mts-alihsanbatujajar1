<?php

namespace App\Http\Controllers;

use App\Models\KebersihanKelas;
use App\Models\Kelas;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KebersihanController extends Controller
{
    public function index(Request $request): View
    {
        $query = KebersihanKelas::query()->with(['kelas', 'tahunAjaran'])->latest();

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->paginate(10)->appends($request->query());
        $kelas = Kelas::query()->orderBy('nama_kelas')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('kebersihan.index', compact('records', 'kelas', 'activeYear', 'request'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $query = KebersihanKelas::query()->with(['kelas', 'tahunAjaran'])->latest();

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->get();
        $pdf = Pdf::loadView('exports.kebersihan', compact('records'));

        return $pdf->download('kebersihan.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $query = KebersihanKelas::query()->with(['kelas', 'tahunAjaran'])->latest();

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $records = $query->get();
        $rows = [];

        foreach ($records as $record) {
            $rows[] = [
                $record->kelas?->nama_kelas ?? '-',
                $record->tanggal?->format('Y-m-d') ?? '-',
                $record->nilai_lantai,
                $record->nilai_sampah,
                $record->nilai_rak,
                $record->nilai_penataan,
                $record->nilai_lantai + $record->nilai_sampah + $record->nilai_rak + $record->nilai_penataan,
                $record->keterangan ?? '-',
            ];
        }

        return XlsxExporter::download('kebersihan.xlsx', ['Kelas', 'Tanggal', 'Nilai Lantai', 'Nilai Sampah', 'Nilai Rak', 'Nilai Penataan', 'Total Nilai', 'Keterangan'], $rows);
    }

    public function edit(KebersihanKelas $kebersihan): View
    {
        $kelas = Kelas::query()->orderBy('nama_kelas')->get();

        return view('kebersihan.edit', compact('kebersihan', 'kelas'));
    }

    public function update(Request $request, KebersihanKelas $kebersihan): RedirectResponse
    {
        $data = $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tanggal' => ['required', 'date'],
            'nilai_lantai' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_sampah' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_rak' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_penataan' => ['required', 'integer', 'min:0', 'max:5'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $kebersihan->update($data);

        return redirect()->route('kebersihan.index')->with('success', 'Data kebersihan kelas berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tanggal' => ['required', 'date'],
            'nilai_lantai' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_sampah' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_rak' => ['required', 'integer', 'min:0', 'max:5'],
            'nilai_penataan' => ['required', 'integer', 'min:0', 'max:5'],
            'keterangan' => ['nullable', 'string'],
        ]);

        KebersihanKelas::create($data);

        return redirect()->route('kebersihan.index')->with('success', 'Data kebersihan kelas berhasil disimpan.');
    }

    public function destroy(KebersihanKelas $kebersihan): RedirectResponse
    {
        $kebersihan->delete();

        return redirect()->route('kebersihan.index')->with('success', 'Data kebersihan kelas berhasil dihapus.');
    }
}
