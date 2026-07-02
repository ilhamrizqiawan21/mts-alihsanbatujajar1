<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'poin',
    ];

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'jenis_pelanggaran_id');
    }
}
