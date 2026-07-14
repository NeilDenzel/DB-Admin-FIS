<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'curso';
    protected $primaryKey = 'cod_curso';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    /** @return BelongsTo<Malla, $this> */
    public function malla(): BelongsTo
    {
        return $this->belongsTo(Malla::class, 'id_malla', 'id_malla');
    }

    /** @return HasMany<SituacionAcademica, $this> */
    public function situacionesAcademicas(): HasMany
    {
        return $this->hasMany(SituacionAcademica::class, 'cod_curso', 'cod_curso');
    }

    /** @return BelongsToMany<Curso, $this> */
    public function prerrequisitos(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,
            'prerrequisito',
            'cod_curso',
            'cod_prerrequisito'
        );
    }

    /** @return BelongsToMany<Curso, $this> */
    public function cursosQueLoRequieren(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,
            'prerrequisito',
            'cod_prerrequisito',
            'cod_curso'
        );
    }
}
