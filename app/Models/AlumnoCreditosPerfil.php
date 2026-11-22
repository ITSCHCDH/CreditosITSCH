<?php

namespace App\Models;

use App\Models\Sit\Alumno as SitAlumno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumnoCreditosPerfil extends Model
{
    protected $connection = 'creditos';
    protected $table = 'alumno_creditos_perfil';

    protected $fillable = [
        'no_control',
        'estatus_creditos',
        'ficha_completada',
        'foto',
        'observaciones_tutoria',
        'sem_med',
        'observaciones_med',
        'sem_psic',
        'observaciones_psic',
    ];

    protected function casts(): array
    {
        return [
            'ficha_completada' => 'boolean',
            'sem_med' => 'integer',
            'sem_psic' => 'integer',
        ];
    }

    public function sitAlumno(): BelongsTo
    {
        return $this->belongsTo(SitAlumno::class, 'no_control', 'no_control');
    }

    public static function obtenerOCrear(string $noControl): self
    {
        return static::query()->firstOrCreate(['no_control' => $noControl]);
    }
}
