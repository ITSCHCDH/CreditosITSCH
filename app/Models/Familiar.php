<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Familiar extends Model
{
    use HasFactory;

    //Nombre de la tabla para la que va a funcionar el modelo
    protected $connection = 'creditos';
    protected $table = "familiares";

    protected $fillable = [
        'id_alu',
        'no_control',
        'nombre',
        'edad',
        'parentesco',
        'escolaridad',
        'relacion',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
