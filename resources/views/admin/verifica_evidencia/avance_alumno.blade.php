@extends('template.molde')

@section('title','Avance de alumno')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-chart-line" style="color:#2d6da3"></i>
        Avance del alumno
    </span>
@endsection

@section('links')
<style>
    .advance-info-card,.advance-progress-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
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
@php
    $primerAlumno = ($alumno_data !== null && count($alumno_data) > 0) ? $alumno_data[0] : null;
    $tempPorcentaje = 0;
    $sumaCreditos = 0;
    $alumnoInicial = $primerAlumno ? [
        'no_control' => (string) $primerAlumno->no_control,
        'nombre' => (string) $primerAlumno->nombre_alumno,
        'carrera' => (string) ($primerAlumno->carrera ?? ''),
    ] : null;
@endphp

@include('template.partes.buscador_combobox', [
    'config' => [
        'id' => 'alumno',
        'title' => 'Buscar alumno',
        'title_icon' => 'fa-solid fa-user-graduate',
        'description' => 'Un solo campo: escribe nombre o número de control y elige una coincidencia de la lista. Hasta cinco resultados.',
        'label' => 'Alumno',
        'placeholder' => 'Ej. Juan Pérez o 00030068',
        'matches_label' => 'Coincidencias de alumnos',
        'submit_label' => 'Consultar avance',
        'submit_icon' => 'fa-solid fa-chart-line',
        'action' => route('verifica_evidencia.avance_alumno'),
        'endpoint' => route('verifica_evidencia.alumnos_busqueda'),
        'field' => 'no_control',
        'params' => ['peticion' => '0'],
        'query_param' => 'nombre',
        'keys' => ['value' => 'no_control', 'label' => 'nombre', 'meta' => 'carrera'],
        'initial' => $alumnoInicial,
        'min_chars' => 2,
        'limit' => 5,
    ],
])

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
        <div class="d-flex flex-wrap gap-2">
            @if(count($ruta_data)>0)
                <form action="{{ route('verifica_evidencia.reportes') }}" method="get" class="mb-0">
                    <input type="hidden" name="carrera" value="{{ $ruta_data[0] }}">
                    <input type="hidden" name="generacion" value="{{ $ruta_data[1] }}">
                    <button type="submit" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Reportes</button>
                </form>
            @endif
            @if($liberado && Auth::User()->hasAnyPermission(['VIP','IMPRIMIR_CONSTANCIAS']))
                <form action="{{ route('constancias.imprimir') }}" method="post" class="mb-0">
                    @csrf
                    @if($primerAlumno)<input type="hidden" name="no_control" value="{{ $primerAlumno->no_control }}">@endif
                    <button type="submit" class="btn btn-primary rounded-pill"><i class="fa-solid fa-print me-2"></i>Imprimir constancia</button>
                </form>
            @endif
        </div>
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
