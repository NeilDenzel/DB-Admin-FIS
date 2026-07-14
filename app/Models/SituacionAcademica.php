<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SituacionAcademica extends Model
{
    protected $table = 'situacion_academica';
    protected $primaryKey = 'id_situacion';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    /** @return BelongsTo<Estudiante, $this> */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'cod_estudiante', 'cod_estudiante');
    }

    /** @return BelongsTo<Curso, $this> */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'cod_curso', 'cod_curso');
    }

    /** @return BelongsTo<EstadoAcademico, $this> */
    public function estadoAcademico(): BelongsTo
    {
        return $this->belongsTo(EstadoAcademico::class, 'id_estado', 'id_estado');
    }
}
