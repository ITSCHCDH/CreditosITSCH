@extends('template.molde')

@section('title','Permisos asignados')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-shield-halved" style="color:#2d6da3"></i>
        @if ($user_id != null)
            <a href="{{ route('usuarios.index') }}" class="text-decoration-none">Usuarios</a>
            <span class="text-muted">/</span>
            <a href="{{ route('usuarios.asignar_roles', $user_id) }}" class="text-decoration-none">Asignación de roles</a>
            <span class="text-muted">/</span>
            Permisos de {{ $role->name }}
        @else
            <a href="{{ route('roles.index') }}" class="text-decoration-none">Roles y permisos</a>
            <span class="text-muted">/</span>
            Permisos de {{ $role->name }}
        @endif
    </span>
@endsection

@push('styles')
<style>
    .vp-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .vp-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .vp-card-head h1{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .vp-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .vp-card-body{padding:1.25rem}
    .vp-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .vp-dato{display:flex;justify-content:space-between;gap:.75rem;padding:.55rem 0;border-bottom:1px dashed #e7edf4;font-size:.88rem}
    .vp-dato:last-of-type{border-bottom:0}
    .vp-dato span:first-child{color:#6b7280}
    .vp-dato span:last-child{color:#102b4a;font-weight:600;text-align:right}
    .vp-count{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .55rem;border-radius:999px;background:#e7f5ec;color:#1b7a43;font-size:.78rem;font-weight:600}
    .vp-buscar{max-width:280px}
    .vp-grupo{margin-bottom:1rem}
    .vp-grupo-titulo{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.5rem;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.75rem;font-weight:600;letter-spacing:.02em;text-transform:uppercase}
    .vp-permiso{display:flex;align-items:center;gap:.5rem;padding:.45rem .6rem;border:1px solid #dceee3;border-radius:.5rem;background:#f8fdf9;height:100%}
    .vp-permiso i{color:#1b7a43;font-size:.78rem;flex:0 0 auto}
    .vp-permiso span{color:#334155;font-size:.8rem;line-height:1.25;word-break:break-word}
    .vp-permisos-scroll{max-height:440px;overflow:auto;padding-right:.35rem}
    .vp-vacio{padding:2.5rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .vp-vacio i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    @media(max-width:767.98px){
        .vp-card-body{padding:1rem}
        .vp-buscar{max-width:none;width:100%}
        .vp-permisos-scroll{max-height:none}
    }
</style>
@endpush

@section('contenido')
    @php
        $asignados = $permisos->count();
        $grupos = collect($permisos)->groupBy(fn ($permiso) => \Illuminate\Support\Str::afterLast($permiso->name, '_'))->sortKeys();
        $puedeAsignar = Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']);
        $puedeEditar = Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ROLES']);
    @endphp

    <div class="row g-3">
        <div class="col-12 col-xl-4">
            <article class="vp-card h-100">
                <div class="vp-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="vp-icon"><i class="fa-solid fa-user-shield"></i></span>
                        <div>
                            <h1>{{ $role->name }}</h1>
                            <p>Resumen del rol.</p>
                        </div>
                    </div>
                </div>
                <div class="vp-card-body">
                    <div class="vp-dato">
                        <span>Identificador</span>
                        <span>{{ $role->id }}</span>
                    </div>
                    <div class="vp-dato">
                        <span>Permisos asignados</span>
                        <span>{{ $asignados }} de {{ $totalPermisos }}</span>
                    </div>
                    <div class="vp-dato">
                        <span>Usuarios con el rol</span>
                        <span>{{ $usuarios }}</span>
                    </div>
                    <div class="vp-dato">
                        <span>Última actualización</span>
                        <span>{{ optional($role->updated_at)->format('d/m/Y H:i') ?? '—' }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Volver
                        </a>
                        @if ($puedeEditar)
                            <a href="{{ route('roles.role_editar', $role->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Editar rol
                            </a>
                        @endif
                        @if ($puedeAsignar)
                            <a href="{{ route('roles.roles_asignar_permisos_vista', $role->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-key me-2"></i>Asignar permisos
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        </div>

        <div class="col-12 col-xl-8">
            <article class="vp-card h-100">
                <div class="vp-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="vp-icon"><i class="fa-solid fa-key"></i></span>
                        <div>
                            <h1>Permisos asignados</h1>
                            <p>Agrupados por módulo.</p>
                        </div>
                    </div>
                    <span class="vp-count"><i class="fa-solid fa-circle-check"></i>{{ $asignados }} permisos</span>
                </div>
                <div class="vp-card-body">
                    @if ($asignados > 0)
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <div class="input-group vp-buscar">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="search" class="form-control border-start-0" id="permisosBuscar" placeholder="Buscar permiso">
                            </div>
                        </div>

                        <div class="vp-permisos-scroll">
                            @foreach ($grupos as $grupo => $items)
                                <div class="vp-grupo" data-permiso-grupo>
                                    <span class="vp-grupo-titulo"><i class="fa-solid fa-folder-tree"></i>{{ $grupo }} · {{ $items->count() }}</span>
                                    <div class="row g-2">
                                        @foreach ($items as $per)
                                            <div class="col-12 col-md-6 col-xxl-4" data-permiso-item data-nombre="{{ \Illuminate\Support\Str::lower($per->name) }}">
                                                <div class="vp-permiso" title="{{ $per->name }}">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    <span>{{ str_replace('_', ' ', $per->name) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-muted small mt-2 mb-0" id="permisosSinResultados" hidden>No hay permisos que coincidan con la búsqueda.</p>
                    @else
                        <div class="vp-vacio">
                            <i class="fa-regular fa-folder-open"></i>
                            Este rol todavía no tiene permisos asignados.
                            @if ($puedeAsignar)
                                <div class="mt-2">
                                    <a href="{{ route('roles.roles_asignar_permisos_vista', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-key me-2"></i>Asignar el primero
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#permisosBuscar').on('input', function () {
                var termino = $(this).val().toLowerCase().trim();
                var visibles = 0;

                $('[data-permiso-item]').each(function () {
                    var coincide = $(this).data('nombre').indexOf(termino) !== -1;
                    $(this).toggle(coincide);
                    if (coincide) { visibles++; }
                });

                $('[data-permiso-grupo]').each(function () {
                    $(this).toggle($(this).find('[data-permiso-item]:visible').length > 0);
                });

                $('#permisosSinResultados').prop('hidden', visibles > 0);
            });
        });
    </script>
@endsection
