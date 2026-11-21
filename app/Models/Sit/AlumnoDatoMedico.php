<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AlumnoDatoMedico extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='alumno_datos_medicos';
    protected $guarded=[];
    protected function casts(): array { return ['discapacidad'=>'boolean']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class,'alumno_id'); }
}
