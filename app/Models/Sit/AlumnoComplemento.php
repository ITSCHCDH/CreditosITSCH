<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AlumnoComplemento extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='alumno_complementos';
    protected $guarded=[];
    protected function casts(): array { return ['ingreso_familiar_mensual'=>'decimal:2','ingreso_propio_mensual'=>'decimal:2','personas_dependientes'=>'integer','trabaja_actualmente'=>'boolean']; }
    public function alumno(): BelongsTo { return $this->belongsTo(Alumno::class,'alumno_id'); }
}
