<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstanciaComplemento extends Model
{
    protected $table = "constancia_complemento";
    protected $fillable = [
    	"institucion_info","plan_de_estudio",'numero_oficio','profesion_jefe_depto','jefe_depto','jefe_depto_enunciado','imagen_encabezado','imagen_pie','profesion_certificador','certificador','certificador_enunciado'
    ];
}
