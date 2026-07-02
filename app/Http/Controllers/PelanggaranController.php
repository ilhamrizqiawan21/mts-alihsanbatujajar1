<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    public function index(): View
    {
        $pelanggarans = Pelanggaran::query()->with(['siswa', 'jenisPelanggaran'])->latest()->get();
        $siswas = Siswa::query()->orderBy('nama')->get();
        $jenisPelanggaran = JenisPelanggaran::query()->orderBy('nama')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('pelanggaran.index', compact('pelanggarans', 'siswas', 'jenisPelanggaran', 'activeYear'));
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
}
