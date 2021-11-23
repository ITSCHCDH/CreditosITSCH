<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receptor extends Model
{
    protected $table = "receptores";

    protected $fillable = [
    	"mensaje_id","visto","fecha_visto","user_id"
    ];
}
