<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(): View
    {
        $absensis = Absensi::query()->with('siswa')->latest()->get();
        $siswas = Siswa::query()->with('kelas')->orderBy('nama')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('absensi.index', compact('absensis', 'siswas', 'activeYear'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:H,I,S,A'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Absensi::create($data);

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }
}
