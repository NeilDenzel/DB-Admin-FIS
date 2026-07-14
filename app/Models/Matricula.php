<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matricula extends Model
{
    protected $table = 'matricula';
    protected $primaryKey = 'id_matricula';

    const CREATED_AT = 'fecha_matricula';
    const UPDATED_AT = null;

    /** @return BelongsTo<Estudiante, $this> */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'cod_estudiante', 'cod_estudiante');
    }

    /** @return BelongsTo<Periodo, $this> */
    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class, 'id_periodo', 'id_periodo');
    }

    /** @return HasMany<DetalleMatricula, $this> */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleMatricula::class, 'id_matricula', 'id_matricula');
    }
}
