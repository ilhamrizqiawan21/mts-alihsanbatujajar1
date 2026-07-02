<?php

namespace App\Http\Controllers;

use App\Models\KebersihanKelas;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KebersihanController extends Controller
{
    public function index(): View
    {
        $records = KebersihanKelas::query()->with(['kelas', 'tahunAjaran'])->latest()->get();
        $kelas = Kelas::query()->orderBy('nama_kelas')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('kebersihan.index', compact('records', 'kelas', 'activeYear'));
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
}
