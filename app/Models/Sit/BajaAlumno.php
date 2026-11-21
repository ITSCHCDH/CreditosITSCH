<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BajaAlumno extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='baja_alumnos';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_baja'=>'date','fecha_autorizacion'=>'datetime']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class,'alumno_id'); }
}
