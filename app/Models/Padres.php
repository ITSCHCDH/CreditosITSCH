<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padres extends Model
{
    use HasFactory;

    //Nombre de la tabla para la que va a funcionar el modelo
    protected $table = "padres";
}
