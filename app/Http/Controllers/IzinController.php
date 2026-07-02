<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SuratIzin;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IzinController extends Controller
{
    public function index(): View
    {
        $izins = SuratIzin::query()->with(['siswa', 'tahunAjaran'])->latest()->get();
        $siswas = Siswa::query()->orderBy('nama')->get();
        $activeYear = TahunAjaran::query()->where('is_aktif', true)->latest()->first();

        return view('izin.index', compact('izins', 'siswas', 'activeYear'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'jenis_izin' => ['required', 'in:pulang,biasa'],
            'tanggal' => ['required', 'date'],
            'jam_berangkat' => ['nullable', 'date_format:H:i'],
            'alasan_pulang' => ['nullable', 'in:sakit,keluarga,lomba,lainnya'],
            'alasan_biasa' => ['nullable', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        SuratIzin::create($data);

        return redirect()->route('izin.index')->with('success', 'Data izin berhasil disimpan.');
    }
}
