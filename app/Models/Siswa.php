<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama',
        'kelas_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp_ortu',
        'foto',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'boolean',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id');
    }

    public function keterlambatan(): HasMany
    {
        return $this->hasMany(Keterlambatan::class, 'siswa_id');
    }

    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'siswa_id');
    }

    public function suratIzin(): HasMany
    {
        return $this->hasMany(SuratIzin::class, 'siswa_id');
    }
}
