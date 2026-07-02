<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keterlambatan extends Model
{
    protected $table = 'keterlambatan';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'tanggal',
        'jam_datang',
        'alasan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_datang' => 'string',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
