<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    //Base de datos de la conexión
    protected $table = 'grupos';

    //Campos que se pueden modificar
    protected $fillable=['gpo_Nombre','id_Carrera','status'];

}
