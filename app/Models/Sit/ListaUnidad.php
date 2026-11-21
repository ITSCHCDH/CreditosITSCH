<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ListaUnidad extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='lista_unidades';
    protected $guarded=[];
    protected function casts(): array { return ['calificacion'=>'decimal:2','faltas'=>'integer','corte'=>'integer','numero_unidad'=>'integer','oportunidad'=>'integer']; }
    public function lista(): BelongsTo { return $this->belongsTo(Lista::class,'lista_id'); }
}
