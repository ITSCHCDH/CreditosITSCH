<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditoArea extends Model
{
    protected $table = "creditos_areas";

    protected $fillable = [
    	"credito_id","credito_area"
    ];
}
