<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
class NivelDesempeno extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_niveles_desempeno';
    protected $guarded=[];
    protected function casts(): array { return ['orden'=>'integer','acredita'=>'boolean','activo'=>'boolean']; }
}
