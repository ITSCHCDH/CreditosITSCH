<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionTutores extends Model
{
    use HasFactory;
    //Nombre de la tabla para la que va a funcionar el modelo
    protected $table="asignaciones_tutores";

    //Datos que se permitira modificar en el modelo
    protected $fillable=['gtu_grupo','tut_clave','gtu_tipo','gtu_semestre','gtu_año','gtu_observaciones'];

}
