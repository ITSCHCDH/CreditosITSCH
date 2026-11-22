<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sit\Alumno;

class Personales extends Model
{
    use HasFactory;

    protected $connection = 'creditos';
    protected $table="personales";

    protected $fillable = [
        'id_alu',
        'no_control',
        'trab',
        'casa',
        'num_person',
        'parentesco',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'no_control', 'no_control');
    }
}