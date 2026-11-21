<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
class Municipio extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_municipios';
    protected $guarded=[];
}
