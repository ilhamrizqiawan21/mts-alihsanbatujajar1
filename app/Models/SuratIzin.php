<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratIzin extends Model
{
    protected $table = 'surat_izin';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'jenis_izin',
        'tanggal',
        'jam_berangkat',
        'alasan_pulang',
        'alasan_biasa',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
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
