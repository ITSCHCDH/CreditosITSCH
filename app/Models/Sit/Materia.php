<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Materia extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_materias';
    protected $guarded=[];
    protected function casts(): array { return ['creditos'=>'integer','horas_teoria'=>'integer','horas_practica'=>'integer','num_temas'=>'integer','activo'=>'boolean']; }
    public function departamentoAcademico(): BelongsTo { return $this->belongsTo(DepartamentoAcademico::class,'departamento_responsable_id'); }
}
