@extends('template.molde')

@section('title','Mis Grupos')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-chalkboard-user" style="color:#2d6da3"></i>
        Mis Grupos
    </span>
@endsection

@push('styles')
<style>
    .profe-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .profe-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .profe-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .profe-card-body{padding:1.25rem}
    .profe-units{display:flex;flex-wrap:wrap;gap:.45rem}
    .profe-units .btn{border-radius:.6rem;padding:.4rem .8rem;font-size:.84rem}
    .profe-units .btn.active{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .profe-table thead th{background:#f8fafc;color:#102b4a;font-size:.78rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5}
    .profe-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .profe-nota{display:inline-flex;min-width:48px;justify-content:center;padding:.25rem .5rem;border-radius:.5rem;font-weight:700}
    .profe-nota--bien{background:#e7f5ec;color:#1b7a43}.profe-nota--mal{background:#fdeceb;color:#b3261e}
</style>
@endpush

@section('contenido')
    @if($docenteSitPendiente)
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="fa-solid fa-link-slash"></i>
            <strong>Vínculo docente pendiente.</strong> Tu usuario no está vinculado con un catedrático activo en SIT.
        </div>
    @else
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="badge rounded-pill text-bg-primary px-3 py-2">
                <i class="fa-solid fa-user me-1"></i>
                {{ trim(implode(' ', array_filter([$docenteSit->user?->nombre, $docenteSit->user?->apellido_paterno, $docenteSit->user?->apellido_materno]))) ?: 'Docente' }}
            </span>
            <span class="badge rounded-pill text-bg-light border px-3 py-2">Empleado: {{ $docenteSit->numero_empleado }}</span>
            <span class="badge rounded-pill text-bg-light border px-3 py-2">Periodo: {{ $periodoActivo?->nombre ?: 'Sin periodo activo' }}</span>
        </div>
    @endif

    <input type="hidden" id="grupo" readonly>
    <input type="hidden" id="gse_clave" readonly>

    <article class="profe-card mb-3">
        <div class="profe-card-head"><h2><i class="fa-solid fa-filter me-2"></i>Materias y grupos asignados</h2></div>
        <div class="profe-card-body">
            <label class="form-label" for="materia">Materia / Grupo</label>
            <select id="materia" class="form-select" @if($gruposAsignados->isEmpty()) disabled @endif>
                <option value="">Selecciona una materia o grupo</option>
                @foreach($gruposAsignados as $grupo)
                    @php
                        $datoMateria = json_encode([
                            'ret_Clave' => $grupo->materia_id,
                            'ret_NumUnidades' => $grupo->materia?->num_temas,
                            'gse_Clave' => $grupo->id,
                            'gse_Observaciones' => $grupo->clave_grupo,
                        ]);
                    @endphp
                    <option value="{{ $datoMateria }}">
                        {{ $grupo->materia?->nombre ?: 'Materia '.$grupo->materia_id }} · {{ $grupo->clave_grupo }}
                    </option>
                @endforeach
            </select>
        </div>
    </article>

    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <article class="profe-card h-100">
                <div class="profe-card-head"><h2><i class="fa-solid fa-layer-group me-2"></i>Unidades</h2></div>
                <div class="profe-card-body"><div class="profe-units" id="unidades"></div></div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="profe-card h-100">
                <div class="profe-card-head"><h2><i class="fa-solid fa-circle-info me-2"></i>Grupo seleccionado</h2></div>
                <div class="profe-card-body" id="datosFiltro">Selecciona una materia o grupo.</div>
            </article>
        </div>
    </div>

    <article class="profe-card">
        <div class="profe-card-head"><h2><i class="fa-solid fa-clipboard-list me-2"></i>Calificaciones de la unidad</h2></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 profe-table" id="listaCali">
                <thead><tr><th>#</th><th>Control</th><th>Nombre</th><th>Calificación</th><th>Motivo</th><th>Comentario</th><th>Confirmar</th></tr></thead>
                <tbody><tr><td colspan="7"><div class="profe-empty">Selecciona una unidad para cargar las calificaciones.</div></td></tr></tbody>
            </table>
        </div>
    </article>
@endsection

@section('js')
<script type="text/javascript">
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
var unidadActual = '';
$('#materia').on('change', function(){
    var valor=$(this).val(); if(!valor){$('#unidades').empty();$('#datosFiltro').text('Selecciona una materia o grupo.');return;}
    var item=JSON.parse(valor); $('#grupo').val(item.gse_Clave); $('#gse_clave').val(item.gse_Clave);
    $('#datosFiltro').html('<strong>Materia:</strong> '+$('#materia option:selected').text());
    $('#unidades').empty();
    for(var i=1;i<=parseInt(item.ret_NumUnidades||0,10);i++){
        $('#unidades').append('<button type="button" class="btn btn-outline-primary unidad" data-unidad="'+i+'">Unidad '+i+'</button>');
    }
    $('#listaCali tbody').html('<tr><td colspan="7"><div class="profe-empty">Selecciona una unidad para cargar las calificaciones.</div></td></tr>');
});
$(document).on('click','.unidad',function(){
    unidadActual=$(this).data('unidad'); $('.unidad').removeClass('active'); $(this).addClass('active'); cargar();
});
function cargar(){
    var item=JSON.parse($('#materia').val());
    $.ajax({type:'post',dataType:'json',url:"{{ route('listaCali.find') }}",data:{materia:item.ret_Clave,unidad:unidadActual,grupo:item.gse_Clave},
      success:function(datos){
        var filas=datos.listaCali||[],comentarios=datos.coment||[],$tbody=$('#listaCali tbody').empty();
        if(!filas.length){$tbody.append('<tr><td colspan="7"><div class="profe-empty">Esta unidad no tiene calificaciones capturadas.</div></td></tr>');return;}
        $.each(filas,function(i,itemFila){
          var cal=parseFloat(itemFila.lsc_Calificacion),reprobado=cal<70,nombre=[itemFila.alu_Nombre,itemFila.alu_ApePaterno,itemFila.alu_ApeMaterno].filter(Boolean).join(' ');
          if(!reprobado){$tbody.append('<tr><td>'+ (i+1)+'</td><td>'+itemFila.alu_NumControl+'</td><td>'+nombre+'</td><td><span class="profe-nota profe-nota--bien">'+itemFila.lsc_Calificacion+'</span></td><td>—</td><td>—</td><td></td></tr>');return;}
          var registro=comentarios.find(function(c){return c.no_control==itemFila.alu_NumControl});
          $tbody.append('<tr><td>'+ (i+1)+'</td><td>'+itemFila.alu_NumControl+'<input type="hidden" id="alu'+i+'" value="'+itemFila.alu_NumControl+'"><input type="hidden" id="lse'+i+'" value="'+itemFila.lse_Clave+'"></td><td>'+nombre+'</td><td><span class="profe-nota profe-nota--mal">'+itemFila.lsc_Calificacion+'</span></td><td><select id="motivo'+i+'" class="form-select form-select-sm"><option value="">Selecciona</option><option value="1">Responsabilidad del alumno</option><option value="2">Inasistencia</option><option value="3">Complejidad de la materia</option><option value="4">Otro</option></select></td><td><textarea id="comentario'+i+'" class="form-control form-control-sm" rows="1">'+(registro?registro.comentario:'')+'</textarea></td><td><button type="button" class="btn btn-sm btn-primary" onclick="guardar('+i+')"><i class="fa-solid fa-floppy-disk"></i></button></td></tr>');
          if(registro) $('#motivo'+i).val(registro.motivos);
        });
      },
      error:function(xhr){$('#listaCali tbody').html('<tr><td colspan="7"><div class="profe-empty">'+(xhr.status===403?'No tienes acceso a este grupo.':'No se pudieron cargar las calificaciones.')+'</div></td></tr>');}
    });
}
function guardar(i){
    var item=JSON.parse($('#materia').val());
    $.ajax({type:'post',dataType:'json',url:"{{ route('comentarios.save') }}",data:{motivos:$('#motivo'+i).val(),comentario:$('#comentario'+i).val(),alumno:$('#alu'+i).val(),materia:item.ret_Clave,unidad:unidadActual,lse_clave:$('#lse'+i).val(),gse_clave:item.gse_Clave,grupo:item.gse_Clave},
      success:function(){swal('Éxito','Los comentarios se guardaron correctamente','success');},
      error:function(xhr){swal('Error',xhr.status===403?'No tienes acceso a este grupo.':'Ocurrió un error al guardar.','error');}
    });
}
</script>
@endsection
