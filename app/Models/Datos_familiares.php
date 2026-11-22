<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Datos_familiares extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $connection = 'creditos';
    protected $table="datos_familiares";

    protected $fillable = [
        'id_alu',
        'no_control',
        'dificultades',
        'ligado',
        'ligado_por',
        'edu',
        'carrera',
        'otro_dato',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
