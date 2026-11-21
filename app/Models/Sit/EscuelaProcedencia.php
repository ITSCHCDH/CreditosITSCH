<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
class EscuelaProcedencia extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_escuelas_procedencia';
    protected $guarded=[];
}
