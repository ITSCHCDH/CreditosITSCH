<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Social extends Model
{
    use HasFactory;

     //Nombre de la tabla para la que va a funcionar el modelo
    protected $connection = 'creditos';
    protected $table="social";

    protected $fillable = [
        'id_alu',
        'no_control',
        'rel_comp',
        'comp_por',
        'rel_amig',
        'amig_por',
        'pareja',
        'rel_prof',
        'prof_por',
        'rel_auto_ac',
        'auto_ac_por',
        'tiempo_lib',
        'recreativa',
        'planes_in',
        'metas_vida',
        'yo_soy',
        'caracter',
        'me_gusta',
        'aspiraciones',
        'miedo',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}
