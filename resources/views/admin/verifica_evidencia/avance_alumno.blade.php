@extends('template.molde')

@section('title','Avance de alumno')

@section('links')
<style>
    .advance-breadcrumb,.advance-search-card,.advance-info-card,.advance-progress-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .advance-breadcrumb{display:flex;align-items:center;gap:.65rem;min-height:64px;margin-bottom:.75rem;padding:.8rem 1rem;color:#64748b}
    .advance-breadcrumb i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .advance-breadcrumb strong{color:#102b4a}
    .advance-search-card{margin-bottom:1rem;padding:1.25rem}
    .advance-search-card h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .advance-search-card p{margin:.2rem 0 1rem;color:#6b7280;font-size:.88rem}
    .advance-search-card .form-control,.advance-search-card .form-select{min-height:48px;border-radius:.75rem}
    .advance-info-card{display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding:1.25rem}
    .advance-avatar{width:72px;height:72px;object-fit:cover;border-radius:1rem;background:#edf3f8}
    .advance-progress-card{overflow:hidden}
    .advance-progress-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .advance-progress-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .credit-progress{height:.75rem;border-radius:999px;background:#e9eef4;overflow:hidden}
    .credit-progress>div{height:100%;border-radius:999px;background:linear-gradient(90deg,#173c66,#2d6da3)}
    @media(max-width:767.98px){.advance-info-card{align-items:flex-start;flex-direction:column}.advance-progress-head{align-items:flex-start;flex-direction:column}}
</style>
@endsection

@section('contenido')
@if(count($ruta_data)>0)
    <div class="advance-breadcrumb">
        <i class="fa-solid fa-chart-line"></i>
        <div>
            <form action="{{ route('verifica_evidencia.reportes') }}" method="get" class="d-inline">
                <input type="hidden" name="carrera" value="{{ $ruta_data[0] }}">
                <input type="hidden" name="generacion" value="{{ $ruta_data[1] }}">
                <button type="submit" class="btn btn-link p-0 text-decoration-none">Reportes</button>
            </form>
            <span class="mx-2">/</span><strong>Avance del alumno</strong>
        </div>
    </div>
@else
    <div class="advance-breadcrumb"><i class="fa-solid fa-chart-line"></i><div><strong>Avance del alumno</strong></div></div>
@endif

<article class="advance-search-card">
    <h1>Buscar alumno</h1>
    <p>Escribe un nombre o número de control. Se muestran hasta cinco coincidencias.</p>
    <form action="{{ route('verifica_evidencia.avance_alumno') }}" method="get" id="studentAdvanceSearch">
        <input type="hidden" name="no_control" id="student_no_control">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="student_search">Nombre o número de control</label>
                <input type="search" id="student_search" class="form-control" placeholder="Ej. Juan Pérez o 00030068" autocomplete="off">
                <div id="student_search_status" class="small text-muted mt-2"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="student_select">Coincidencias</label>
                <select id="student_select" class="form-select">
                    <option value="">Escribe para buscar</option>
                </select>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4" id="student_search_submit" disabled><i class="fa-solid fa-magnifying-glass me-2"></i>Consultar avance</button>
            </div>
        </div>
    </form>
</article>

@php
    $primerAlumno = ($alumno_data !== null && count($alumno_data) > 0) ? $alumno_data[0] : null;
    $tempPorcentaje = 0;
    $sumaCreditos = 0;
@endphp

@if($primerAlumno)
    <article class="advance-info-card">
        <img class="advance-avatar" src="{{ !empty($primerAlumno->foto) ? asset('storage/alumnos/img/'.$primerAlumno->foto) : asset('images/user.png') }}" alt="Alumno">
        <div>
            <span class="text-muted small">Alumno seleccionado</span>
            <h2 class="h5 mb-1">{{ $primerAlumno->nombre_alumno }}</h2>
            <div class="text-muted"><strong>{{ $primerAlumno->no_control }}</strong>@if(!empty($primerAlumno->carrera)) · {{ $primerAlumno->carrera }}@endif</div>
        </div>
    </article>
@endif

<article class="advance-progress-card">
    <div class="advance-progress-head">
        <h2>Avance por créditos</h2>
        @if($liberado && Auth::User()->hasAnyPermission(['VIP','IMPRIMIR_CONSTANCIAS']))
            <form action="{{ route('constancias.imprimir') }}" method="post" class="mb-0">
                @csrf
                @if($primerAlumno)<input type="hidden" name="no_control" value="{{ $primerAlumno->no_control }}">@endif
                <button type="submit" class="btn btn-primary rounded-pill"><i class="fa-solid fa-print me-2"></i>Imprimir constancia</button>
            </form>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Crédito</th><th>Actividades</th><th class="text-end">Porcentaje</th></tr></thead>
            <tbody>
                @foreach($creditos as $credito)
                    @php
                        $registros = $avance ? collect($alumno_data)->where('nombre_credito',$credito->nombre) : collect();
                        $porcentaje = $registros->max('por_credito') ?? 0;
                        $porcentaje = min(100,(int)$porcentaje);
                        $sumaCreditos += $porcentaje;
                    @endphp
                    <tr>
                        <td style="min-width:220px">
                            <strong>{{ $credito->nombre }}</strong>
                            <div class="credit-progress mt-2"><div style="width:{{ $porcentaje }}%"></div></div>
                        </td>
                        <td>
                            @if($registros->isNotEmpty())
                                @foreach($registros as $registro)
                                    <div>{{ $registro->nombre_actividad }} <span class="text-muted">({{ $registro->por_cred_actividad }}%)</span></div>
                                @endforeach
                            @else
                                <span class="text-muted">Sin actividades registradas</span>
                            @endif
                        </td>
                        <td class="text-end"><strong>{{ $porcentaje }}%</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</article>
@endsection

@section('js')
<script>
    (function(){
        const searchInput = document.getElementById('student_search');
        const select = document.getElementById('student_select');
        const hiddenControl = document.getElementById('student_no_control');
        const submit = document.getElementById('student_search_submit');
        const status = document.getElementById('student_search_status');
        let timeout = null;

        function resetMatches(message){
            select.innerHTML = '<option value="">'+(message || 'Sin coincidencias')+'</option>';
            hiddenControl.value = '';
            submit.disabled = true;
            status.textContent = message || '';
        }

        searchInput.addEventListener('input', function(){
            const query = this.value.trim();
            clearTimeout(timeout);
            hiddenControl.value = '';
            submit.disabled = true;
            if(query.length < 2){
                resetMatches('Escribe al menos 2 caracteres');
                return;
            }
            timeout = setTimeout(function(){
                status.textContent = 'Buscando...';
                fetch("{{ route('verifica_evidencia.alumnos_busqueda') }}?peticion=0&nombre="+encodeURIComponent(query), {
                    headers:{'Accept':'application/json'}
                }).then(r=>r.json()).then(rows=>{
                    if(!rows.length){
                        resetMatches('Sin coincidencias');
                        return;
                    }
                    select.innerHTML = '<option value="">Selecciona una coincidencia</option>';
                    rows.slice(0,5).forEach(function(row){
                        const option=document.createElement('option');
                        option.value=row.no_control;
                        option.textContent=row.nombre+' — '+row.no_control+(row.carrera?' · '+row.carrera:'');
                        select.appendChild(option);
                    });
                    status.textContent = rows.length+' coincidencia'+(rows.length===1?'':'s')+' encontrada'+(rows.length===1?'':'s');
                }).catch(function(){
                    resetMatches('No fue posible completar la búsqueda');
                });
            },300);
        });

        select.addEventListener('change', function(){
            hiddenControl.value = this.value;
            submit.disabled = !this.value;
        });
    })();
</script>
@endsection
