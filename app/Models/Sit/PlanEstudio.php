<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PlanEstudio extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_plan_estudios';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_inicio'=>'date','fecha_fin'=>'date','activo'=>'boolean','creditos_totales'=>'integer','duracion_semestres'=>'integer']; }
    public function carrera(): BelongsTo { return $this->belongsTo(Carrera::class,'carrera_id'); }
    public function planMaterias(): HasMany { return $this->hasMany(PlanMateria::class,'plan_estudio_id'); }
}
