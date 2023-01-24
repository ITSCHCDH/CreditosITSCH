<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_clinico extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $table="historiales_clinicos";
    //Datos que se mostraran en los objetos Jasón
    protected $fillable=['id_alu','enfermedad','cap_dif','estatura','peso','sangre','serv_med'];

}
