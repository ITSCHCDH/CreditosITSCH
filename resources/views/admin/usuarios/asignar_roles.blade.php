@extends('template.molde')

@section('title','Asignar roles')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-users-gear" style="color:#2d6da3"></i>
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">Usuarios</a>
        <span class="text-muted">/</span>
        Asignar roles
    </span>
@endsection

@push('styles')
<style>
    .roles-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .roles-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .roles-card-head h1,.roles-card-head h2{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .roles-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .roles-card-body{padding:1.25rem}
    .roles-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .roles-avatar{width:64px;height:64px;display:grid;place-items:center;border-radius:1rem;background:linear-gradient(145deg,#edf3f8,#dbe7f2);color:#173c66;font-size:1.7rem}
    .roles-user-name{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .roles-user-email{margin:.15rem 0 0;color:#6b7280;font-size:.85rem;overflow-wrap:anywhere}
    .roles-status{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .55rem;border-radius:999px;font-size:.76rem;font-weight:600}
    .roles-status--active{background:#e7f5ec;color:#1b7a43}
    .roles-status--inactive{background:#fdeceb;color:#b3261e}
    .roles-table-card{overflow:hidden}
    .roles-table-card .table{margin:0}
    .roles-table-card .table th{background:#f8fafc;color:#102b4a;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em;border-bottom:1px solid #edf1f5}
    .roles-table-card .table td{vertical-align:middle}
    .roles-role-name{color:#102b4a;font-weight:600}
    .roles-role-id{color:#6b7280;font-size:.78rem}
    .roles-assigned-row{background:#fbfdff}
    .roles-assigned-row:has(.form-check-input:checked){background:#f1f7fc}
    .roles-toolbar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:.85rem 1.25rem;border-bottom:1px solid #edf1f5;background:#fff}
    .roles-search{max-width:280px}
    .roles-count{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .65rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.78rem;font-weight:600}
    .roles-footer{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .roles-footer-actions{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem}
    .roles-empty{padding:2.5rem 1rem;text-align:center;color:#64748b}
    @media(max-width:767.98px){
        .roles-card-body{padding:1rem}
        .roles-toolbar{align-items:stretch}
        .roles-search{max-width:none;width:100%}
        .roles-footer{align-items:stretch}
        .roles-footer-actions,.roles-footer-actions .btn{width:100%}
        .roles-table-card .table th,.roles-table-card .table td{padding:.75rem}
    }
</style>
@endpush

@section('contenido')
@php
    $rolesAsignados = collect($roles)->filter(fn ($rol) => $rol->user_name !== null)->count();
@endphp

<div class="row g-3 mb-3">
    <div class="col-12 col-lg-5">
        <article class="roles-card h-100">
            <div class="roles-card-head">
                <div class="d-flex align-items-center gap-2">
                    <span class="roles-icon"><i class="fa-solid fa-user"></i></span>
                    <div>
                        <h1>Usuario seleccionado</h1>
                        <p>Información y estado de la cuenta.</p>
                    </div>
                </div>
                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ROLES','VER_ROLES']))
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-primary" title="Administrar roles">
                        <i class="fa-solid fa-user-shield me-2"></i>Administrar roles
                    </a>
                @endif
            </div>
            <div class="roles-card-body">
                <div class="d-flex align-items-center gap-3">
                    <span class="roles-avatar"><i class="fa-solid fa-user"></i></span>
                    <div class="min-w-0 flex-grow-1">
                        <p class="roles-user-name">{{ strtoupper($user->name) }}</p>
                        <p class="roles-user-email">{{ $user->email }}</p>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="roles-status {{ $user->active === 'true' ? 'roles-status--active' : 'roles-status--inactive' }}">
                                <i class="fa-solid {{ $user->active === 'true' ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                {{ $user->active === 'true' ? 'Activo' : 'Inactivo' }}
                            </span>
                            <span class="badge rounded-pill bg-light text-dark">
                                <i class="fa-solid fa-building me-1"></i>{{ $area?->nombre ?? 'Sin área asignada' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <div class="col-12 col-lg-7">
        <article class="roles-card h-100">
            <div class="roles-card-head">
                <div class="d-flex align-items-center gap-2">
                    <span class="roles-icon"><i class="fa-solid fa-key"></i></span>
                    <div>
                        <h2>Resumen de acceso</h2>
                        <p>Los roles determinan los permisos disponibles.</p>
                    </div>
                </div>
            </div>
            <div class="roles-card-body d-flex align-items-center">
                <div class="row g-3 w-100">
                    <div class="col-6">
                        <span class="text-muted small d-block">Roles disponibles</span>
                        <strong class="h4 mb-0 text-primary">{{ count($roles) }}</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted small d-block">Roles asignados</span>
                        <strong class="h4 mb-0 text-success" id="rolesAsignadosResumen">{{ $rolesAsignados }}</strong>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>

<form action="{{ route('usuarios.guardar_roles') }}" method="post" id="formAsignarRoles">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <article class="roles-card roles-table-card">
        <div class="roles-card-head">
            <div class="d-flex align-items-center gap-2">
                <span class="roles-icon"><i class="fa-solid fa-list-check"></i></span>
                <div>
                    <h2>Roles disponibles</h2>
                    <p>Selecciona los roles que tendrá esta cuenta.</p>
                </div>
            </div>
            <span class="roles-count">
                <i class="fa-solid fa-check-double"></i>
                <span id="rolesAsignadosCount">{{ $rolesAsignados }}</span> seleccionados
            </span>
        </div>

        <div class="roles-toolbar">
            <div class="input-group roles-search">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="search" class="form-control border-start-0" id="buscarRol" placeholder="Buscar rol" aria-label="Buscar rol">
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" id="seleccionarTodos">
                    <i class="fa-solid fa-check-double me-1"></i>Todos
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="limpiarRoles">
                    <i class="fa-solid fa-xmark me-1"></i>Limpiar
                </button>
            </div>
        </div>

        @if(count($roles) > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:90px">ID</th>
                            <th>Rol</th>
                            <th style="width:180px">Permisos</th>
                            <th class="text-end" style="width:150px">Asignar</th>
                        </tr>
                    </thead>
                    <tbody id="tablaRoles">
                        @foreach ($roles as $rol)
                            <tr class="roles-assigned-row" data-role-item data-role-name="{{ \Illuminate\Support\Str::lower($rol->name) }}">
                                <td><span class="roles-role-id">#{{ $rol->id }}</span></td>
                                <td><span class="roles-role-name">{{ $rol->name }}</span></td>
                                <td>
                                    <a href="{{ route('roles.role_ver_permisos',['id'=>$rol->id,'user_id'=>$user->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-key me-1"></i>Ver permisos
                                    </a>
                                </td>
                                <td class="text-end">
                                    <div class="form-check form-switch d-inline-flex justify-content-end">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            name="roles_id[]"
                                            value="{{ $rol->id }}"
                                            id="rol{{ $rol->id }}"
                                            @checked($rol->user_name !== null)
                                        >
                                        <label class="form-check-label ms-2" for="rol{{ $rol->id }}">Asignar</label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-muted small px-3 pt-3 mb-0" id="sinRolesEncontrados" hidden>No hay roles que coincidan con la búsqueda.</p>
        @else
            <div class="roles-empty">
                <i class="fa-solid fa-user-shield fa-2x mb-2 d-block text-muted"></i>
                No hay roles disponibles para este usuario.
            </div>
        @endif

        <div class="roles-footer">
            <span class="text-muted small">
                <i class="fa-solid fa-circle-info me-1"></i>Los cambios se aplicarán al guardar.
            </span>
            <div class="roles-footer-actions">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar roles
                </button>
            </div>
        </div>
    </article>
</form>
@endsection

@section('js')
<script>
    function actualizarRolesAsignados() {
        const total = $('#tablaRoles input[name="roles_id[]"]:checked').length;
        $('#rolesAsignadosCount').text(total);
        $('#rolesAsignadosResumen').text(total);
    }

    $(document).ready(function () {
        actualizarRolesAsignados();

        $('#tablaRoles input[name="roles_id[]"]').on('change', actualizarRolesAsignados);

        $('#seleccionarTodos').on('click', function () {
            $('#tablaRoles tr:visible input[name="roles_id[]"]').prop('checked', true);
            actualizarRolesAsignados();
        });

        $('#limpiarRoles').on('click', function () {
            $('#tablaRoles input[name="roles_id[]"]').prop('checked', false);
            actualizarRolesAsignados();
        });

        $('#buscarRol').on('input', function () {
            const termino = $(this).val().toLowerCase().trim();
            let visibles = 0;

            $('[data-role-item]').each(function () {
                const coincide = String($(this).data('role-name')).indexOf(termino) !== -1;
                $(this).toggle(coincide);
                if (coincide) { visibles++; }
            });

            $('#sinRolesEncontrados').prop('hidden', visibles > 0);
        });
    });
</script>
@endsection
