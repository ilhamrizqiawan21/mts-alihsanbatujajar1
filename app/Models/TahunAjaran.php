<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'semester',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'tahun_ajaran_id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'tahun_ajaran_id');
    }

    public function keterlambatan(): HasMany
    {
        return $this->hasMany(Keterlambatan::class, 'tahun_ajaran_id');
    }

    public function kebersihanKelas(): HasMany
    {
        return $this->hasMany(KebersihanKelas::class, 'tahun_ajaran_id');
    }

    public function suratIzin(): HasMany
    {
        return $this->hasMany(SuratIzin::class, 'tahun_ajaran_id');
    }

    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'tahun_ajaran_id');
    }
}
