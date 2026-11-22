<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Historial_clinico extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $connection = 'creditos';
    protected $table="historiales_clinicos";
    //Datos que se mostraran en los objetos Jasón
    protected $fillable=[
        'id_alu',
        'no_control',
        'hipertension',
        'enfermedad',
        'diabetes',
        'epilepsia',
        'anorexia',
        'bulimia',
        'sexual',
        'depresion',
        'tristeza',
        'otra_enf',
        'cap_dif',
        'vista',
        'lenguaje',
        'oido',
        'motora',
        'otra_dis',
        'estatura',
        'peso',
        'sangre',
        'serv_med',
        'dia_psico',
        'cuanto_psico',
        'dia_med',
        'cuanto_med',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }

}
