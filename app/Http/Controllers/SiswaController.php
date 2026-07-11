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
    public function index(Request $request): View
    {
        $query = $this->filteredQuery($request)->with('kelas');

        $studentStats = [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('status', true)->count(),
            'inactive' => (clone $query)->where('status', false)->count(),
        ];

        $siswas = (clone $query)
            ->latest('id')
            ->paginate(10)
            ->appends($request->query());
        $kelasList = Kelas::query()->orderBy('nama_kelas')->get();
        $filters = $request->only(['q', 'kelas_id', 'status']);

        return view('siswa.index', compact('siswas', 'kelasList', 'studentStats', 'filters'));
    }

    public function exportPdf(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $siswas = $this->filteredQuery($request)->with('kelas')->latest('id')->get();
        $pdf = Pdf::loadView('exports.siswa', compact('siswas'));

        return $pdf->download('siswa.pdf');
    }

    public function exportXlsx(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $siswas = $this->filteredQuery($request)->with('kelas')->latest('id')->get();
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

    private function filteredQuery(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Siswa::query();

        if ($request->filled('q')) {
            $keyword = (string) $request->string('q')->trim();

            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('nis', 'like', '%' . $keyword . '%')
                    ->orWhere('no_hp_ortu', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', (bool) $request->integer('status'));
        }

        return $query;
    }
}
