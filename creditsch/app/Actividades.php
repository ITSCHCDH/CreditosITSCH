<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    //Nombre de la tabla
    protected $table="nom_actividad";
    //Datos visibles para los objetos json
    protected $fillable=['nom_actividad','por_cred_actividad','id_actividad'];
}
