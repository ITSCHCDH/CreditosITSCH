<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivoreprobacion extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $table="motivosreprobacion";
    //Datos que se mostraran en los objetos Jasón
    protected $fillable=['no_control','materia','grup_cla','lse_clave','num_tema','motivos','comentario'];
}
