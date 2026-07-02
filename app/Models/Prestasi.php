<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'nama_prestasi',
        'tingkat_prestasi_id',
        'juara',
        'tanggal',
        'penyelenggara',
        'foto',
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

    public function tingkatPrestasi(): BelongsTo
    {
        return $this->belongsTo(TingkatPrestasi::class, 'tingkat_prestasi_id');
    }
}
