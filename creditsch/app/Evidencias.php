<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evidencias extends Model
{
    //Nombre de la tabla
    protected $table="evidencia";
    //Datos visibles para los objetos json
    protected $fillable=['status','nom_imagen','responsable','valida','id_nom_actividad'];
}
