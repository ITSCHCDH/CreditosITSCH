<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $table = "constancia";
    protected $fillable = [
    	'profesion_jefe_division','jefe_division','division_enuciado','division_enunciado','carrera','carrera_nom_completo'
    ];
}
