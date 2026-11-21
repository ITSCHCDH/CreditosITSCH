@extends('template.molde')

@section('title','Asignar responsables')

@section('links')
<style>
    .responsible-breadcrumb,.responsible-control,.responsible-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06);}
    .responsible-breadcrumb{display:flex;align-items:center;gap:.65rem;min-height:64px;margin-bottom:.75rem;padding:.8rem 1rem;color:#64748b}
    .responsible-breadcrumb i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .responsible-breadcrumb strong{color:#102b4a}
    .responsible-control{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.9rem 1rem}
    .responsible-control h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .responsible-control p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
    .responsible-card{overflow:hidden}
    .responsible-card-head{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .responsible-card-head i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .responsible-card-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .responsible-row{display:grid;grid-template-columns:minmax(220px,1fr) 180px 100px 100px;align-items:center;gap:.75rem;padding:.85rem 1.25rem;border-bottom:1px solid #edf1f5}
    .responsible-row:last-child{border-bottom:0}
    .responsible-name{display:flex;align-items:center;gap:.65rem;font-weight:600;color:#334155}
    .responsible-avatar{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .responsible-actions{position:sticky;bottom:.75rem;z-index:4;display:flex;justify-content:flex-end;margin-top:1rem;padding:.75rem;border:1px solid #e7edf4;border-radius:.9rem;background:rgba(255,255,255,.96);box-shadow:0 .55rem 1.5rem rgba(16,43,74,.12)}
    @media(max-width:767.98px){.responsible-control{align-items:flex-start;flex-direction:column}.responsible-row{grid-template-columns:1fr 1fr}.responsible-row>div:nth-child(2){text-align:right}.responsible-actions{position:static}}
</style>
@endsection

@section('contenido')
@if($actividad != null)
    <div class="responsible-breadcrumb">
        <i class="fa-solid fa-user-plus"></i>
        <div><a class="text-decoration-none" href="{{ route('actividades.index') }}">Actividades</a><span class="mx-2">/</span><strong>{{ $actividad->nombre }}</strong><span class="mx-2">/</span>Asignar responsables</div>
    </div>

    <div class="responsible-control">
        <div><h1>Responsables de la actividad</h1><p>Selecciona los usuarios que podrán cargar y gestionar evidencias.</p></div>
        <a href="{{ route('responsables',$actividad->id) }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Ver asignados</a>
    </div>

    <input type="hidden" name="actividad_id" value="{{ $actividad->id }}" id="actividad_id">
    <article class="responsible-card">
        <div class="responsible-card-head"><i class="fa-solid fa-users-gear"></i><h2>Usuarios disponibles</h2></div>
        @if($responsables != null)
            <div class="p-3 border-bottom">
                <label class="form-label" for="responsableSearch">Buscar administrativo o docente</label>
                <select id="responsableSearch" class="form-select">
                    <option value="">Selecciona un responsable</option>
                    @foreach($responsables as $res)
                        @php
                            $asignado = $res->actividad_nombre !== null;
                            $bloqueado = $res->active == 'false' || ($asignado && ($res->participantes !== null || $res->evidencias !== null || $res->validado == 'true'));
                        @endphp
                        <option value="{{ $res->usuario_id }}" @disabled($bloqueado)>
                            {{ $res->usuario_nombre }} · {{ $res->area }}{{ $bloqueado ? ' (no disponible)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-none d-md-grid responsible-row border-bottom table-light">
                <strong>Usuario</strong><strong>Área</strong><strong>Activo</strong><strong>Asignar</strong>
            </div>
            @foreach($responsables as $res)
                @php
                    $asignado = $res->actividad_nombre !== null;
                    $bloqueado = $res->active == 'false' || ($asignado && ($res->participantes !== null || $res->evidencias !== null || $res->validado == 'true'));
                @endphp
                <div class="responsible-row">
                    <div class="responsible-name"><span class="responsible-avatar"><i class="fa-solid fa-user"></i></span><span>{{ $res->usuario_nombre }}</span></div>
                    <div class="text-md-start">{{ $res->area }}</div>
                    <div>{!! $res->active == 'true' ? '<span class="badge rounded-pill bg-success">Sí</span>' : '<span class="badge rounded-pill bg-secondary">No</span>' !!}</div>
                    <div class="form-check form-switch d-flex justify-content-md-end">
                        <input type="checkbox" name="user_id[]" value="{{ $res->usuario_id }}" class="responsable-agregado form-check-input" id="c{{ $res->usuario_id }}" @checked($asignado) @disabled($bloqueado)>
                        <label class="visually-hidden" for="c{{ $res->usuario_id }}">Asignar responsable</label>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center text-muted py-5">No se encontraron usuarios disponibles.</div>
        @endif
    </article>

    @if($responsables != null)
        <div class="responsible-actions">
            <button type="button" id="submit-reponsables" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-user-check me-2"></i>Guardar responsables</button>
        </div>
    @endif
@else
    <div class="responsible-breadcrumb"><i class="fa-solid fa-triangle-exclamation"></i><div><strong>Actividad no encontrada</strong></div></div>
@endif
@endsection

@section('js')
@if($responsables != null && $actividad != null)
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    var responsables_array=[];
    function inicializarArreglo(){
        $('.responsable-agregado:checked').each(function(){ responsables_array.push($(this).val()); });
    }
    $(document).on('change','.responsable-agregado',function(){
        var value=$(this).val();
        if($(this).is(':checked')){ if(!responsables_array.includes(value)) responsables_array.push(value); }
        else { responsables_array=responsables_array.filter(function(id){ return id!==value; }); }
    });
    $(document).on('change','#responsableSearch',function(){
        var value=$(this).val();
        if(!value) return;
        var checkbox=document.getElementById('c'+value);
        if(!checkbox || checkbox.disabled) return;
        checkbox.checked=!checkbox.checked;
        $(checkbox).trigger('change');
        checkbox.closest('.responsible-row').scrollIntoView({behavior:'smooth',block:'center'});
    });
    $(document).on('click','#submit-reponsables',function(event){
        event.preventDefault();
        $.ajax({
            type:'post',dataType:'json',
            url:"{{ route('actividad_evidencias.asignar_responsables') }}",
            data:{responsables_id:responsables_array,actividad_id:$('#actividad_id').val()},
            success:function(){ location.href="{{ route('responsables',$actividad->id) }}"; },
            error:function(){ Swal.fire({icon:'error',title:'Error',text:'No fue posible guardar los responsables.'}); }
        });
    });
    $(document).ready(inicializarArreglo);
</script>
@endif
@endsection
