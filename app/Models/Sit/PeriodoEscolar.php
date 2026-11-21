<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
class PeriodoEscolar extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_periodos_escolares';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_inicio'=>'date','fecha_fin'=>'date','fecha_limite_pagos'=>'date','activo'=>'boolean']; }
}
