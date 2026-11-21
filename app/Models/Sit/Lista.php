<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Lista extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='listas';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_registro'=>'date','calificacion_final'=>'decimal:2','faltas_totales'=>'integer']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class,'alumno_id'); }
    public function grupo(): BelongsTo { return $this->belongsTo(Grupo::class,'grupo_id'); }
    public function catedratico(): BelongsTo { return $this->belongsTo(Catedratico::class,'catedratico_id'); }
    public function listaUnidades(): HasMany { return $this->hasMany(ListaUnidad::class,'lista_id'); }
}
