<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    protected $primaryKey = 'cod_estudiante';
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    /** @return BelongsTo<Malla, $this> */
    public function malla(): BelongsTo
    {
        return $this->belongsTo(Malla::class, 'id_malla', 'id_malla');
    }

    /** @return HasMany<SituacionAcademica, $this> */
    public function situacionesAcademicas(): HasMany
    {
        return $this->hasMany(SituacionAcademica::class, 'cod_estudiante', 'cod_estudiante');
    }

    /** @return HasMany<Matricula, $this> */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class, 'cod_estudiante', 'cod_estudiante');
    }
}
