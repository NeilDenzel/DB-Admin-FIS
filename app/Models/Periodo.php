<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periodo extends Model
{
    protected $table = 'periodo';
    protected $primaryKey = 'id_periodo';
    protected $guarded = [];
    public $timestamps = false;

    /** @return HasMany<Matricula, $this> */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class, 'id_periodo', 'id_periodo');
    }
}
