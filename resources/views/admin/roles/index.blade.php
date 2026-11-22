@extends('template.molde')

@section('title','Roles y permisos')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-shield-halved" style="color:#2d6da3"></i>
        Roles y permisos
    </span>
@endsection

@push('styles')
<style>
    .rol-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .rol-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .rol-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .rol-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .rol-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .rol-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .rol-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .rol-kpi--roles .rol-kpi-icon{color:#173c66;background:#edf3f8}
    .rol-kpi--permisos .rol-kpi-icon{color:#5b21b6;background:#f1ebfd}
    .rol-kpi--asignaciones .rol-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .rol-kpi--usuarios .rol-kpi-icon{color:#b45309;background:#fdf1e3}
    .rol-table-card{overflow:hidden}
    .rol-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .rol-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .rol-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .rol-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .rol-table-card .dt-buttons .dt-button:hover,.rol-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a}
    .rol-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .rol-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .rol-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .rol-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .rol-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .rol-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .rol-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .rol-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .rol-table-card table.dataTable tbody td{vertical-align:middle}
    .rol-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .rol-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .rol-table-card .pagination{margin-bottom:0;gap:.2rem}
    .rol-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .rol-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .rol-table-card .page-link:hover{background:#edf3f8}
    .rol-nombre strong{display:block;color:#102b4a;font-size:.92rem}
    .rol-nombre small{color:#6b7280}
    .rol-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .rol-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    @media(max-width:767.98px){
        .rol-card-head{align-items:flex-start;flex-direction:column}
        .rol-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .rol-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .rol-table-card .dt-buttons .buttons-colvis,.rol-table-card .dt-buttons .buttons-page-length{display:none}
        .rol-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .rol-table-card .dataTables_filter label{display:flex;width:100%}
        .rol-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .rol-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .rol-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .rol-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $puedeCrear = Auth::User()->hasAnyPermission(['VIP','CREAR_ROLES']);
        $puedeAsignar = Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']);
        $puedeEditar = Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ROLES']);
        $puedeEliminar = Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ROLES']);
        $puedeUsuarios = Auth::User()->hasAnyPermission(['VIP','VER_ROLES_USUARIOS']);
        $puedeAcciones = $puedeAsignar || $puedeEditar || $puedeEliminar || $puedeUsuarios;
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="rol-card rol-kpi rol-kpi--roles">
                <span class="rol-kpi-icon"><i class="fa-solid fa-user-shield"></i></span>
                <div>
                    <span class="rol-kpi-label">Roles</span>
                    <span class="rol-kpi-value">{{ $totalRoles }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="rol-card rol-kpi rol-kpi--permisos">
                <span class="rol-kpi-icon"><i class="fa-solid fa-key"></i></span>
                <div>
                    <span class="rol-kpi-label">Permisos</span>
                    <span class="rol-kpi-value">{{ $totalPermisos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="rol-card rol-kpi rol-kpi--asignaciones">
                <span class="rol-kpi-icon"><i class="fa-solid fa-link"></i></span>
                <div>
                    <span class="rol-kpi-label">Asignaciones</span>
                    <span class="rol-kpi-value">{{ $totalAsignaciones }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="rol-card rol-kpi rol-kpi--usuarios">
                <span class="rol-kpi-icon"><i class="fa-solid fa-users"></i></span>
                <div>
                    <span class="rol-kpi-label">Usuarios con rol</span>
                    <span class="rol-kpi-value">{{ $usuariosConRol }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="rol-card rol-table-card">
        <div class="rol-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-user-shield me-2"></i>Listado de roles</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalRoles }}</span>
            </div>
            @if ($puedeCrear)
                <a href="{{ route('roles.roles_crear') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Crear rol
                </a>
            @endif
        </div>

        @if ($totalRoles > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabla_roles">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rol</th>
                            <th>Permisos</th>
                            <th>Usuarios</th>
                            @if ($puedeAcciones)
                                <th class="text-end">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="rol-nombre">
                                    <strong>{{ $rol->name }}</strong>
                                    <small>ID {{ $rol->id }}</small>
                                </td>
                                <td>
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <span class="badge rounded-pill bg-light text-dark">{{ $rol->permissions_count }}</span>
                                        <a href="{{ route('roles.role_ver_permisos', $rol->id) }}" class="btn btn-sm btn-outline-secondary" title="Ver permisos">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if ($puedeUsuarios)
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <span class="badge rounded-pill bg-light text-dark">{{ $rol->users_count }}</span>
                                            <a href="{{ route('roles.usuarios', $rol->id) }}" class="btn btn-sm btn-outline-secondary" title="Ver usuarios">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </a>
                                        </div>
                                    @else
                                        <span class="badge rounded-pill bg-light text-dark">{{ $rol->users_count }}</span>
                                    @endif
                                </td>
                                @if ($puedeAcciones)
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            @if ($puedeAsignar)
                                                <a href="{{ route('roles.roles_asignar_permisos_vista', $rol->id) }}" class="btn btn-sm btn-outline-primary" title="Asignar o revocar permisos">
                                                    <i class="fa-solid fa-shield-halved"></i>
                                                </a>
                                            @endif
                                            @if ($puedeEditar)
                                                <a href="{{ route('roles.role_editar', $rol->id) }}" class="btn btn-sm btn-outline-warning" title="Modificar rol">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endif
                                            @if ($puedeEliminar)
                                                <a href="{{ route('roles.role_eliminar', $rol->id) }}" onclick="return confirm('¿Estás seguro que deseas eliminar este rol?')" class="btn btn-sm btn-outline-danger" title="Eliminar rol">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rol-empty">
                <i class="fa-regular fa-folder-open"></i>
                Todavía no hay roles registrados.
            </div>
        @endif
    </article>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            if (!$('#tabla_roles').length) {
                return;
            }

            $('#tabla_roles').DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], ['10 registros', '25 registros', '50 registros', 'Ver todos']],
                pagingType: 'full_numbers',
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                rowCallback: function (fila, datos, indice) {
                    fila.cells[0].textContent = indice + 1;
                },
                language: {
                    emptyTable: 'Sin roles registrados',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                    infoFiltered: '(filtrado de _MAX_ registros totales)',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    loadingRecords: 'Cargando…',
                    processing: 'Procesando…',
                    search: 'Buscar:',
                    zeroRecords: 'Sin coincidencias',
                    paginate: {
                        first: 'Primero',
                        last: 'Último',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                },
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fa-solid fa-download me-2"></i>Exportar',
                        className: 'btn btn-sm btn-outline-primary',
                        buttons: [
                            { extend: 'copyHtml5', text: '<i class="fa-regular fa-copy me-2"></i>Copiar', className: 'btn-sm' },
                            { extend: 'excelHtml5', text: '<i class="fa-solid fa-file-excel me-2"></i>Excel', className: 'btn-sm' },
                            { extend: 'pdfHtml5', text: '<i class="fa-solid fa-file-pdf me-2"></i>PDF', className: 'btn-sm' },
                            { extend: 'print', text: '<i class="fa-solid fa-print me-2"></i>Imprimir', className: 'btn-sm' }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa-solid fa-table-columns me-2"></i>Columnas',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'pageLength',
                        text: '<i class="fa-solid fa-list me-2"></i>Registros',
                        className: 'btn btn-sm btn-outline-secondary'
                    }
                ]
            });
        });
    </script>
@endsection
