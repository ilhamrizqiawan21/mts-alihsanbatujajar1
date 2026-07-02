<?php

namespace App\Http\Controllers;

use App\Models\Keterlambatan;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeterlambatanController extends Controller
{
    public function index(): View
    {
        $records = Keterlambatan::query()->with(['siswa', 'tahunAjaran'])->latest()->get();
        $siswas = Siswa::query()->orderBy('nama')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('keterlambatan.index', compact('records', 'siswas', 'activeYear'));
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
}
