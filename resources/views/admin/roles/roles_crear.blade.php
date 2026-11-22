@extends('template.molde')

@section('title','Roles | Crear')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-shield-halved" style="color:#2d6da3"></i>
        <a href="{{ route('roles.index') }}" class="text-decoration-none">Roles y permisos</a>
        <span class="text-muted">/</span>
        Crear
    </span>
@endsection

@push('styles')
<style>
    .nr-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .nr-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .nr-card-head h1{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .nr-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .nr-card-body{padding:1.25rem}
    .nr-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .nr-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .nr-count{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .55rem;border-radius:999px;background:#f1ebfd;color:#5b21b6;font-size:.78rem;font-weight:600}
    .nr-buscar{max-width:280px}
    .nr-grupo{margin-bottom:1rem}
    .nr-grupo-titulo{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.5rem;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.75rem;font-weight:600;letter-spacing:.02em;text-transform:uppercase}
    .nr-permiso{display:flex;align-items:center;gap:.55rem;padding:.45rem .6rem;border:1px solid #e7edf4;border-radius:.5rem;background:#fff;cursor:pointer;transition:.15s ease;height:100%}
    .nr-permiso:hover{border-color:#b9cde1;background:#f8fbff}
    .nr-permiso .form-check-input{margin:0;flex:0 0 auto}
    .nr-permiso span{color:#334155;font-size:.8rem;line-height:1.25;word-break:break-word}
    .nr-permiso:has(input:checked){border-color:#2d6da3;background:#eef5fc}
    .nr-permiso:has(input:checked) span{color:#102b4a;font-weight:600}
    .nr-permisos-scroll{max-height:380px;overflow:auto;padding-right:.35rem}
    @media(max-width:767.98px){
        .nr-card-body{padding:1rem}
        .nr-buscar{max-width:none;width:100%}
        .nr-permisos-scroll{max-height:none}
    }
</style>
@endpush

@section('contenido')
    @php
        $puedeAsignar = Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']);
        $grupos = collect($permisos)->groupBy(fn ($permiso) => \Illuminate\Support\Str::afterLast($permiso->name, '_'))->sortKeys();
    @endphp

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Revisá los datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.roles_guardar') }}" method="post" id="formRol">
        @csrf

        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <article class="nr-card h-100">
                    <div class="nr-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="nr-icon"><i class="fa-solid fa-user-shield"></i></span>
                            <div>
                                <h1>Datos del rol</h1>
                                <p>Nombre único para identificar el rol.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nr-card-body">
                        <label class="form-label" for="name">Nombre del rol</label>
                        <input type="text" id="name" name="name" class="form-control" required maxlength="100" value="{{ old('name') }}" placeholder="Ej. Jefe de Carrera" autofocus>
                        <p class="text-muted small mt-2 mb-0">El nombre debe ser único; después podés asignarle permisos y usuarios.</p>
                    </div>
                </article>
            </div>

            @if ($puedeAsignar)
                <div class="col-12 col-xl-8">
                    <article class="nr-card h-100">
                        <div class="nr-card-head">
                            <div class="d-flex align-items-center gap-2">
                                <span class="nr-icon"><i class="fa-solid fa-key"></i></span>
                                <div>
                                    <h1>Permisos iniciales</h1>
                                    <p>Opcional: podés asignarlos ahora o después.</p>
                                </div>
                            </div>
                            <span class="nr-count"><i class="fa-solid fa-check-double"></i><span id="permisosCount">0</span> seleccionados</span>
                        </div>
                        <div class="nr-card-body">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="input-group nr-buscar">
                                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                    <input type="search" class="form-control border-start-0" id="permisosBuscar" placeholder="Buscar permiso">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="permisosTodos">
                                    <i class="fa-solid fa-check-double me-1"></i>Visibles
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="permisosNinguno">
                                    <i class="fa-solid fa-xmark me-1"></i>Ninguno
                                </button>
                            </div>

                            <div class="nr-permisos-scroll">
                                @forelse ($grupos as $grupo => $items)
                                    <div class="nr-grupo" data-permiso-grupo>
                                        <span class="nr-grupo-titulo"><i class="fa-solid fa-folder-tree"></i>{{ $grupo }} · {{ $items->count() }}</span>
                                        <div class="row g-2">
                                            @foreach ($items as $permiso)
                                                <div class="col-12 col-md-6 col-xxl-4" data-permiso-item data-nombre="{{ \Illuminate\Support\Str::lower($permiso->name) }}">
                                                    <label class="nr-permiso" title="{{ $permiso->name }}">
                                                        <input class="form-check-input" type="checkbox" name="permisos[]" value="{{ $permiso->id }}" @checked(in_array($permiso->id, old('permisos', [])))>
                                                        <span>{{ str_replace('_', ' ', $permiso->name) }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">No hay permisos registrados.</p>
                                @endforelse
                            </div>
                            <p class="text-muted small mt-2 mb-0" id="permisosSinResultados" hidden>No hay permisos que coincidan con la búsqueda.</p>
                        </div>
                    </article>
                </div>
            @endif
        </div>

        <div class="nr-card mt-3">
            <div class="nr-footer">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Crear rol
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function actualizarContadorPermisos() {
            $('#permisosCount').text($('input[name="permisos[]"]:checked').length);
        }

        $(document).ready(function () {
            actualizarContadorPermisos();

            $('input[name="permisos[]"]').on('change', actualizarContadorPermisos);

            $('#permisosTodos').on('click', function () {
                $('[data-permiso-item]:visible input[name="permisos[]"]').prop('checked', true);
                actualizarContadorPermisos();
            });

            $('#permisosNinguno').on('click', function () {
                $('input[name="permisos[]"]').prop('checked', false);
                actualizarContadorPermisos();
            });

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
