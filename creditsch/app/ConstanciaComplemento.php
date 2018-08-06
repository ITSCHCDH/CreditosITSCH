<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstanciaComplemento extends Model
{
    protected $table = "constancia_complemento";
    protected $fillable = [
    	"institucion_info","enunciado_superior","plan_de_estudio","oficio"
    ];
}
