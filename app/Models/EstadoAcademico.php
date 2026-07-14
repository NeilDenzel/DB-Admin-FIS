<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoAcademico extends Model
{
    protected $table = 'estado_academico';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    /** @return HasMany<SituacionAcademica, $this> */
    public function situacionesAcademicas(): HasMany
    {
        return $this->hasMany(SituacionAcademica::class, 'id_estado', 'id_estado');
    }
}
