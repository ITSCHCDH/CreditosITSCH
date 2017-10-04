<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
    //Nombre de la tabla
    protected $table="nom_creditos";
    //Datos visibles para los objetos json
    protected $fillable=['nombre'];
}
