<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(): View
    {
        $kelas = Kelas::query()->latest()->paginate(10);

        return view('kelas.index', compact('kelas'));
    }

    public function exportPdf(): \Symfony\Component\HttpFoundation\Response
    {
        $kelas = Kelas::query()->latest()->get();
        $pdf = Pdf::loadView('exports.kelas', compact('kelas'));

        return $pdf->download('kelas.pdf');
    }

    public function exportXlsx(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $kelas = Kelas::query()->latest()->get();
        $rows = [];

        foreach ($kelas as $item) {
            $rows[] = [$item->nama_kelas, $item->wali_kelas ?? '-'];
        }

        return XlsxExporter::download('kelas.xlsx', ['Nama Kelas', 'Wali Kelas'], $rows);
    }

    public function create(): View
    {
        return view('kelas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:20'],
            'wali_kelas' => ['nullable', 'string', 'max:100'],
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kelas): View
    {
        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas): View
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas): RedirectResponse
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:20'],
            'wali_kelas' => ['nullable', 'string', 'max:100'],
        ]);

        $kelas->update($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas): RedirectResponse
    {
        try {
            $kelas->delete();

            return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), '1451') || str_contains($e->getMessage(), 'foreign key')) {
                return redirect()->route('kelas.index')->withErrors([
                    'kelas' => 'Tidak dapat menghapus kelas karena masih terhubung dengan data lain, misalnya kebersihan kelas.',
                ]);
            }

            throw $e;
        }
    }
}
