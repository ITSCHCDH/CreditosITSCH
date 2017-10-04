<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participantes extends Model
{
    //Nombre de la tabla
    protected $table="participantes";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','id_evidencia'];
}
