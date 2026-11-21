@extends('template.molde')

@section('title','Verificar evidencias')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-check" style="color:#2d6da3"></i>
        @if($actividades_link == 'true')
            <a href="{{ route('actividades.index') }}" class="text-decoration-none">Actividades</a>
            <span class="text-muted">/</span>
        @endif
        Verificar evidencias
    </span>
@endsection

@section('links')
<style>
    .verification-control,.verification-summary,.verification-table-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .verification-control{display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.9rem 1rem}
    .verification-control h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .verification-control p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
    .verification-summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.75rem;margin-bottom:1rem}
    .verification-summary-item{padding:.9rem 1rem;border-right:1px solid #edf1f5}
    .verification-summary-item:last-child{border-right:0}
    .verification-summary-item span{display:block;color:#6b7280;font-size:.78rem}
    .verification-summary-item strong{color:#102b4a;font-size:1.25rem}
    .verification-table-card{overflow:hidden}
    .verification-table-card-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .verification-table-card-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .verification-status{display:inline-flex;align-items:center;gap:.45rem}
    .verification-status i{width:28px;height:28px;display:grid;place-items:center;border-radius:.55rem}
    @media(max-width:767.98px){.verification-control{align-items:flex-start;flex-direction:column}.verification-summary{grid-template-columns:1fr}.verification-summary-item{border-right:0;border-bottom:1px solid #edf1f5}.verification-summary-item:last-child{border-bottom:0}.verification-table-card-head{align-items:flex-start;flex-direction:column}}
</style>
@endsection

@section('contenido')
@php
    $total = $evidencias_data->count();
    $validadasCount = $evidencias_data->where('validado','true')->count();
    $pendientesCount = $total - $validadasCount;
@endphp

<div class="verification-control">
    <div>
        <h1>Validación de evidencias</h1>
        <p>Revisa responsables, créditos y estado de cada actividad.</p>
    </div>
    <form action="{{ route('verifica_evidencia.index') }}" method="get" id="actividades-submit" class="d-flex align-items-center gap-2 flex-wrap">
        <input type="hidden" name="actividades_link" value="{{ $actividades_link }}">
        <div class="form-check form-switch mb-0">
            <input type="checkbox" id="checkbox5" class="form-check-input" name="validadas" @checked($validadas == 'false')>
            <label for="checkbox5" class="form-check-label">Actividades sin validar</label>
        </div>
        <div class="input-group" style="max-width:320px">
            <input type="text" class="form-control" placeholder="Buscar actividad, crédito o responsable" name="busqueda" value="{{ $busqueda }}">
            <button class="btn btn-primary" type="submit" title="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
</div>

<div class="verification-summary">
    <div class="verification-summary-item"><span>Total</span><strong>{{ $total }}</strong></div>
    <div class="verification-summary-item"><span>Validadas</span><strong class="text-success">{{ $validadasCount }}</strong></div>
    <div class="verification-summary-item"><span>Pendientes</span><strong class="text-warning">{{ $pendientesCount }}</strong></div>
</div>

<form action="{{ route('verifica_evidencia.store') }}" method="post">
    @csrf
    <input type="hidden" name="actividades_link" value="{{ $actividades_link }}">

    <article class="verification-table-card">
        <div class="verification-table-card-head">
            <h2>Listado de evidencias</h2>
            @if(Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                <button type="submit" class="btn btn-primary rounded-pill"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar validación</button>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Actividad</th><th>Validador</th><th>Responsable</th><th>Crédito</th><th>Evidencias</th><th>Validar</th></tr>
                </thead>
                <tbody>
                    @forelse($evidencias_data as $evi)
                        <tr>
                            <td><strong>{{ $evi->nombre }}</strong></td>
                            <td>{{ $evi->validador_nombre }}</td>
                            <td>{{ $evi->name }}</td>
                            <td>{{ $evi->nombre_credito }}</td>
                            <td>
                                <a href="{{ route('verifica_evidencia.ver_evidencia',$evi->actividad_evidencia_id) }}" class="btn btn-outline-primary btn-sm rounded-3" title="Ver evidencias">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                @if($evi->vigente == 'false')
                                    <span class="badge rounded-pill bg-secondary">Crédito no vigente</span>
                                @else
                                    @php
                                        $puedeValidar = Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA'])
                                            || (Auth::User()->hasAnyPermission(['VIP_SOLO_LECTURA','VERIFICAR_EVIDENCIA']) && $evi->validador_id == Auth::User()->id);
                                    @endphp
                                    @if($puedeValidar)
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="id_evidencias[]" value="{{ $evi->actividad_evidencia_id }}" class="form-check-input" id="validar{{ $evi->actividad_evidencia_id }}" @checked($evi->validado=='true') @disabled($evi->validado=='true')>
                                            <label class="form-check-label" for="validar{{ $evi->actividad_evidencia_id }}">{{ $evi->validado=='true'?'Validada':'Pendiente' }}</label>
                                        </div>
                                    @else
                                        <span class="badge rounded-pill {{ $evi->validado=='true'?'bg-success':'bg-secondary' }}">{{ $evi->validado=='true'?'Validada':'Pendiente' }}</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5"><i class="fa-solid fa-inbox fa-2x mb-3"></i><div>No hay evidencias para los filtros seleccionados.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</form>
@endsection

@section('js')
<script>
    document.getElementById('checkbox5')?.addEventListener('change', function () {
        document.getElementById('actividades-submit').submit();
    });
</script>
@endsection
