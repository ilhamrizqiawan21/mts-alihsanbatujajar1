<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\TingkatPrestasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrestasiController extends Controller
{
    public function index(): View
    {
        $records = Prestasi::query()->with(['siswa', 'tingkatPrestasi'])->latest()->get();
        $siswas = Siswa::query()->orderBy('nama')->get();
        $tingkatPrestasi = TingkatPrestasi::query()->orderBy('id')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('prestasi.index', compact('records', 'siswas', 'tingkatPrestasi', 'activeYear'));
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
}
