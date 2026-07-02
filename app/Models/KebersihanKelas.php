<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KebersihanKelas extends Model
{
    protected $table = 'kebersihan_kelas';
    public $timestamps = false;

    protected $fillable = [
        'kelas_id',
        'tahun_ajaran_id',
        'tanggal',
        'nilai_lantai',
        'nilai_sampah',
        'nilai_rak',
        'nilai_penataan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
