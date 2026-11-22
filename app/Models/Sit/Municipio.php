<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Municipio extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='cat_municipios';
    protected $guarded=[];
    public function estado(): BelongsTo { return $this->belongsTo(Estado::class, 'estado_id'); }
    public function complementos(): HasMany { return $this->hasMany(AlumnoComplemento::class, 'municipio_id'); }
}
