<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';
    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
        'wali_kelas',
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function kebersihanKelas(): HasMany
    {
        return $this->hasMany(KebersihanKelas::class, 'kelas_id');
    }
}
