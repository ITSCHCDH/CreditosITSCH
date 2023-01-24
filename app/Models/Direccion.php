<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $table="direcciones";
    //Datos que se mostraran en los objetos Jasón
    protected $fillable=['id_alu','direccion','colonia','cp','municipio','estado'];
}
