<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avances extends Model
{
    //Nombre de la tabla
    protected $table="avance";
    //Datos visibles para los objetos json
    protected $fillable=['no_control','id_credito','por_credito'];
}
