<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        $tahunAjaran = TahunAjaran::query()->latest()->paginate(10);

        return view('pengaturan.index', compact('tahunAjaran'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tahun' => ['required', 'string', 'max:9'],
            'semester' => ['required', 'in:1,2'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        TahunAjaran::create($data);

        return redirect()->route('pengaturan.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }
}
