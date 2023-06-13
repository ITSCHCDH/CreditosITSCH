<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpoTutorias extends Model
{
    use HasFactory;
    protected $table = 'gpo_tutorias';

    //Campos de la tabla que se puede editar desde el formulario
    protected $fillable=[
        'gpo_Nombre','no_Control',
    ];
}
