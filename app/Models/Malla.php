<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Malla extends Model
{
    protected $table = 'malla';
    protected $primaryKey = 'id_malla';
    public $timestamps = false;

    /** @return HasMany<Curso, $this> */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'id_malla', 'id_malla');
    }

    /** @return HasMany<Estudiante, $this> */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class, 'id_malla', 'id_malla');
    }
}
