@extends('template.molde')

@section('title','Mi avance')

@section('links')
<style>
    .student-dashboard { --student-blue:#173c66; --student-gold:#c79a2b; }
    .student-hero {
        display:flex; align-items:center; justify-content:space-between; gap:1.5rem;
        padding:1.75rem; border:0; border-radius:1.25rem; color:#fff;
        background:linear-gradient(135deg, #173c66 0%, #102b4a 100%);
        box-shadow:0 1rem 2.5rem rgba(16,43,74,.16);
    }
    .student-identity { display:flex; align-items:center; gap:1rem; min-width:0; }
    .student-avatar {
        width:72px; height:72px; object-fit:cover; border:3px solid rgba(255,255,255,.75);
        border-radius:1rem; background:#fff;
    }
    .student-hero h1 { margin:.15rem 0 .35rem; font-size:clamp(1.35rem,3vw,2rem); font-weight:700; }
    .student-meta { color:rgba(255,255,255,.78); font-size:.95rem; }
    .dashboard-action { border-radius:.75rem; white-space:nowrap; }
    .summary-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:1rem; margin:1.25rem 0; }
    .summary-card {
        min-height:120px; padding:1.25rem; border:1px solid #e7edf4; border-radius:1rem;
        background:#fff; box-shadow:0 .45rem 1.25rem rgba(29,78,116,.06);
    }
    .summary-card i { width:42px; height:42px; display:inline-grid; place-items:center; border-radius:.75rem;
        color:#173c66; background:#edf3f8; }
    .summary-card strong { display:block; margin-top:.75rem; color:#102b4a; font-size:1.5rem; }
    .summary-card span { color:#6b7280; font-size:.88rem; }
    .credit-card { border:1px solid #e7edf4; border-radius:1rem; background:#fff; overflow:hidden; margin-bottom:1rem; }
    .credit-head { display:flex; justify-content:space-between; align-items:center; gap:1rem; padding:1rem 1.25rem;
        background:#f8fafc; border-bottom:1px solid #edf1f5; }
    .credit-head h2 { margin:0; color:#102b4a; font-size:1.05rem; font-weight:700; }
    .credit-bar { height:.75rem; overflow:hidden; border-radius:999px; background:#e9eef4; }
    .credit-bar > div { height:100%; border-radius:999px; background:linear-gradient(90deg,#173c66,#2d6da3); }
    .activity-row { display:grid; grid-template-columns:minmax(0,1fr) 100px; gap:1rem; align-items:center;
        padding:.85rem 1.25rem; border-bottom:1px solid #f0f3f6; }
    .activity-row:last-child { border-bottom:0; }
    .activity-row span { color:#4b5563; }
    .empty-state { padding:2.25rem 1rem; text-align:center; color:#6b7280; }
    @media (max-width:767px) {
        .student-hero { align-items:flex-start; flex-direction:column; }
        .summary-grid { grid-template-columns:1fr; }
        .activity-row { grid-template-columns:minmax(0,1fr) 72px; }
    }
</style>
@endsection

@section('ruta')
<a class="text-decoration-none" href="{{ route('alumnos.home_avance') }}">Mi avance</a>
@endsection

@section('contenido')
@php
    $perfilAlumno = $perfil[0] ?? null;
    $totalCreditos = 0;
    foreach ($creditos as $credito) {
        $porcentaje = 0;
        if ($avance) {
            foreach ($alumno_data as $registro) {
                if (($registro->nombre_credito ?? null) === $credito->nombre) {
                    $porcentaje = max($porcentaje, min(100, (int) ($registro->por_credito ?? 0)));
                }
            }
        }
        $totalCreditos += $porcentaje >= 100 ? 1 : 0;
    }
    $porcentajeGeneral = $creditos->count() ? (int) (($totalCreditos / $creditos->count()) * 100) : 0;
@endphp

<div class="student-dashboard">
    <div class="student-hero">
        <div class="student-identity">
            <img class="student-avatar" src="{{ asset('images/user.png') }}" alt="Avatar del alumno">
            <div>
                <div class="student-meta">Bienvenido/a</div>
                <h1>{{ $perfilAlumno->nombre_alumno ?? 'Alumno ITSCH' }}</h1>
                <div class="student-meta">
                    {{ $perfilAlumno->no_control ?? '' }}
                    @if(!empty($perfilAlumno->carrera)) · {{ $perfilAlumno->carrera }} @endif
                </div>
            </div>
        </div>
        <a href="{{ route('alumnos.actividades') }}" class="btn btn-light dashboard-action">
            <i class="fas fa-layer-group me-2"></i>Ver actividades
        </a>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <i class="fas fa-award"></i>
            <strong>{{ $porcentajeGeneral }}%</strong>
            <span>Progreso general</span>
        </div>
        <div class="summary-card">
            <i class="fas fa-check-circle"></i>
            <strong>{{ $totalCreditos }}</strong>
            <span>Créditos liberados</span>
        </div>
        <div class="summary-card">
            <i class="fas fa-book-open"></i>
            <strong>{{ $creditos->count() }}</strong>
            <span>Tipos de crédito</span>
        </div>
    </div>

    @foreach($creditos as $credito)
        @php
            $registros = $avance
                ? collect($alumno_data)->where('nombre_credito', $credito->nombre)
                : collect();
            $porcentaje = $registros->max('por_credito') ?? 0;
            $porcentaje = min(100, (int) $porcentaje);
        @endphp
        <article class="credit-card">
            <div class="credit-head">
                <h2>{{ $credito->nombre }}</h2>
                <strong class="{{ $porcentaje >= 100 ? 'text-success' : 'text-primary' }}">{{ $porcentaje }}%</strong>
            </div>
            <div class="px-3 pt-3">
                <div class="credit-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $porcentaje }}">
                    <div style="width:{{ $porcentaje }}%"></div>
                </div>
            </div>
            @if($registros->isNotEmpty())
                @foreach($registros as $registro)
                    <div class="activity-row">
                        <span>{{ $registro->nombre_actividad }}</span>
                        <strong class="text-end">{{ (int) $registro->por_cred_actividad }}%</strong>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <div>No hay actividades registradas en este tipo de crédito.</div>
                </div>
            @endif
        </article>
    @endforeach

    @if($liberado)
        <a href="{{ route('alumnos.constancias_imprimir') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-print me-2"></i>Imprimir constancia
        </a>
    @endif
</div>
@endsection
