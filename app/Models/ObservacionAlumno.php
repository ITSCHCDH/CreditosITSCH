<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

/**
 * Observaciones que edita el módulo STA. Se guardan en creditos porque SIT es
 * únicamente de consulta.
 */
class ObservacionAlumno extends Model
{
    protected $table = 'observaciones_alumnos';

    protected $fillable = ['no_control', 'observaciones'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
