<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
class DepartamentoAcademico extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_departamentos_academicos';
    protected $guarded=[];
    protected function casts(): array { return ['es_transversal'=>'boolean','activo'=>'boolean']; }
}
