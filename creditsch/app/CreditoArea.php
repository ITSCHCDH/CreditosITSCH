<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditoArea extends Model
{
    protected $table = "creditos_areas";

    protected $fillable = [
    	"credito_id","credito_area"
    ];
}
