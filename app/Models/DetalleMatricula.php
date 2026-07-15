<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleMatricula extends Model
{
    protected $table = 'detalle_matricula';
    protected $primaryKey = 'id_detalle';
    protected $guarded = [];
    public $timestamps = false;

    /** @return BelongsTo<Matricula, $this> */
    public function matricula(): BelongsTo
    {
        return $this->belongsTo(Matricula::class, 'id_matricula', 'id_matricula');
    }

    /** @return BelongsTo<Curso, $this> */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'cod_curso', 'cod_curso');
    }
}
