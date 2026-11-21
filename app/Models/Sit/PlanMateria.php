<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PlanMateria extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='plan_materias';
    protected $guarded=[];
    protected function casts(): array { return ['obligatoria'=>'boolean','semestre_recomendado'=>'integer','fila'=>'integer','columna'=>'integer']; }
    public function planEstudio(): BelongsTo { return $this->belongsTo(PlanEstudio::class,'plan_estudio_id'); }
    public function materia(): BelongsTo { return $this->belongsTo(Materia::class,'materia_id'); }
}
