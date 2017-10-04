<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    //Nombre de la tabla
    protected $table="alumnos";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','password','nombre','carrera','status'];
}
