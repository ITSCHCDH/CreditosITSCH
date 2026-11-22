<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Sit\Carrera;

class Constancia extends Model
{
    protected $table = "constancia";
    protected $fillable = [
    	'profesion_jefe_division','jefe_division','division_enuciado','division_enunciado','carrera','plan_de_estudios'
    ];

    public function sitCarrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera', 'id');
    }
}
