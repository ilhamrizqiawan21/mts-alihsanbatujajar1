<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TingkatPrestasi extends Model
{
    protected $table = 'tingkat_prestasi';

    public $timestamps = false;

    protected $fillable = [
        'nama',
    ];

    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'tingkat_prestasi_id');
    }
}
