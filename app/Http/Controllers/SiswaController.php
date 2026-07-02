<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Support\XlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        $siswas = Siswa::query()->with('kelas')->latest()->paginate(10);

        return view('siswa.index', compact('siswas'));
    }

    public function exportPdf(): \Symfony\Component\HttpFoundation\Response
    {
        $siswas = Siswa::query()->with('kelas')->latest()->get();
        $pdf = Pdf::loadView('exports.siswa', compact('siswas'));

        return $pdf->download('siswa.pdf');
    }

    public function exportXlsx(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $siswas = Siswa::query()->with('kelas')->latest()->get();
        $rows = [];

        foreach ($siswas as $siswa) {
            $rows[] = [
                $siswa->nis,
                $siswa->nama,
                $siswa->kelas?->nama_kelas ?? '-',
                $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-'),
                $siswa->tempat_lahir ?? '-',
                $siswa->tanggal_lahir?->format('Y-m-d') ?? '-',
                $siswa->alamat ?? '-',
                $siswa->no_hp_ortu ?? '-',
                $siswa->status ? 'Aktif' : 'Nonaktif',
            ];
        }

        return XlsxExporter::download('siswa.xlsx', ['NIS', 'Nama', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'No HP Orang Tua', 'Status'], $rows);
    }

    public function create(): View
    {
        $kelas = Kelas::query()->orderBy('nama_kelas')->get();

        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:100'],
            'kelas_id' => ['nullable', 'integer', 'exists:kelas,id'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:50'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp_ortu' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'boolean'],
        ]);

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa): View
    {
        $siswa->load('kelas');

        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        $kelas = Kelas::query()->orderBy('nama_kelas')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa): RedirectResponse
    {
        $data = $request->validate([
            'nis' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:100'],
            'kelas_id' => ['nullable', 'integer', 'exists:kelas,id'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:50'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_hp_ortu' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'boolean'],
        ]);

        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
