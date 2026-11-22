<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Padres extends Model
{
    use HasFactory;

    //Nombre de la tabla para la que va a funcionar el modelo
    protected $connection = 'creditos';
    protected $table = "padres";

    protected $fillable = [
        'id_alu',
        'no_control',
        'nombre',
        'edad',
        'tel',
        'parentesco',
        'ocupacion',
        'profesion',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
