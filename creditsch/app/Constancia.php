<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $table = "constancia";
    protected $fillable = [
    	'profesion_jefe_depto','jefe_depto','jefe_depto_enunciado','profesion_jefe_division','jefe_division','division_enuciado','division_enunciado','profesion_certificador','certificador','certificador_enunciado','carrera','carrera_nom_completo'
    ];
}
