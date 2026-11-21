<?php
namespace App\Models\Sit;
use App\Traits\SitReadOnlyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Catedratico extends Model
{
    use SitReadOnlyModel;
    protected $connection='sit';
    protected $table='catedraticos';
    protected $guarded=[];
    protected function casts(): array { return ['fecha_ingreso'=>'date','activo'=>'boolean']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class,'user_id'); }
    public function carrera(): BelongsTo { return $this->belongsTo(Carrera::class,'carrera_id'); }
}
