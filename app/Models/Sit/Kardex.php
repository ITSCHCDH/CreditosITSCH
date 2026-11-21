<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Kardex extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='kardex';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_liberacion'=>'date','fecha_especial'=>'date','calificacion_final'=>'decimal:2','convalidacion_aplicada'=>'boolean','acreditada'=>'boolean','creditos_materia'=>'integer']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class,'alumno_id'); }
    public function materia(): BelongsTo { return $this->belongsTo(Materia::class,'materia_id'); }
    public function periodoEscolar(): BelongsTo { return $this->belongsTo(PeriodoEscolar::class,'periodo_id'); }
    public function nivelDesempeno(): BelongsTo { return $this->belongsTo(NivelDesempeno::class,'nivel_desempeno_id'); }
}
