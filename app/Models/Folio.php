<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Folio extends Model
{
    protected $table = "constancia_folios";

    protected $fillable = ["no_control", "no_folio"];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
