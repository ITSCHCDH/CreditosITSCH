<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function listas(): HasMany { return $this->hasMany(Lista::class, 'grupo_id'); }

    public function scopePeriodoActivoOSeleccionado($query, ?int $periodoId = null)
    {
        if ($periodoId) {
            return $query->where('grupos.periodo_id', $periodoId);
        }

        return $query->whereHas('periodoEscolar', fn ($periodo) => $periodo->where('activo', true));
    }

    public function scopeClave($query, $clave)
    {
        if ($clave !== null && $clave !== '') {
            return $query->where('grupos.clave_grupo', $clave);
        }

        return $query;
    }
}
