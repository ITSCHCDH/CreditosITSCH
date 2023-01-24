<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $table="social";
   
}
