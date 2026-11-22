<?php

namespace App\Models\Sit;

use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidenciaAlumno extends Model
{
    use SitReadOnlyModel;

    protected $connection = 'sit';
    protected $table = 'residencia_alumnos';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'fecha_solicitud' => 'date',
            'fecha_asignacion' => 'date',
            'fecha_inicio' => 'date',
            'fecha_termino' => 'date',
            'anteproyecto_data' => 'array',
            'cronograma_oficial_data' => 'array',
        ];
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
