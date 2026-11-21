<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Carrera extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_carreras';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_inicio'=>'date','fecha_fin'=>'date','activo'=>'boolean','creditos_totales'=>'integer','duracion_semestres'=>'integer']; }
    public function alumnos(): HasMany { return $this->hasMany(Alumno::class,'carrera_id'); }
    public function planesEstudio(): HasMany { return $this->hasMany(PlanEstudio::class,'carrera_id'); }
}
