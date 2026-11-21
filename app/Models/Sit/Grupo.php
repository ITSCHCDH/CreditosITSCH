<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Grupo extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='grupos';
    protected $guarded=[];
    protected function casts(): array { return ['horario_detalle'=>'array','activo'=>'boolean','cupo_maximo'=>'integer','cupo_actual'=>'integer']; }
    public function periodoEscolar(): BelongsTo { return $this->belongsTo(PeriodoEscolar::class,'periodo_id'); }
    public function materia(): BelongsTo { return $this->belongsTo(Materia::class,'materia_id'); }
    public function catedratico(): BelongsTo { return $this->belongsTo(Catedratico::class,'catedratico_id'); }
}
