<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    protected $table = "constancia_folios";

    protected $fillable = ["no_control", "no_folio"];
}
