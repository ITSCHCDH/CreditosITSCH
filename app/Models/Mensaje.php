<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = "mensajes";

    protected $fillable = [
    	"creador_id","mensaje","notificacion"
    ];
}
