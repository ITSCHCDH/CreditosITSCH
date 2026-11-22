@extends('template.molde')

@section('title','Usuarios')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-users" style="color:#2d6da3"></i>
        Usuarios
    </span>
@endsection

@push('styles')
<style>
    .usr-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .usr-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .usr-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .usr-kpi{display:flex;align-items:center;gap:.85rem;height:100%;padding:1rem 1.15rem}
    .usr-kpi-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;font-size:1.05rem}
    .usr-kpi-label{display:block;color:#6b7280;font-size:.78rem;text-transform:uppercase;letter-spacing:.03em}
    .usr-kpi-value{display:block;color:#102b4a;font-size:1.45rem;font-weight:700;line-height:1.1}
    .usr-kpi--total .usr-kpi-icon{color:#173c66;background:#edf3f8}
    .usr-kpi--activos .usr-kpi-icon{color:#1b7a43;background:#e7f5ec}
    .usr-kpi--inactivos .usr-kpi-icon{color:#b45309;background:#fdf1e3}
    .usr-kpi--tutores .usr-kpi-icon{color:#5b21b6;background:#f1ebfd}
    .usr-table-card{overflow:hidden}
    .usr-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .usr-table-card .dataTables_wrapper::after{content:"";display:block;clear:both}
    .usr-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;flex-wrap:wrap;gap:.4rem}
    .usr-table-card .dt-buttons .dt-button{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;border:1px solid #cfdceb;border-radius:.55rem;background:#fff;color:#173c66;font-size:.8rem;font-weight:500;line-height:1.2;box-shadow:none;text-transform:none}
    .usr-table-card .dt-buttons .dt-button:hover,.usr-table-card .dt-buttons .dt-button:focus{background:#edf3f8;border-color:#b9cde1;color:#102b4a}
    .usr-table-card .dt-button-collection{border:1px solid #e2e9f1;border-radius:.7rem;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14);padding:.35rem}
    .usr-table-card .dt-button-collection .dt-button{border:0;border-radius:.45rem;width:100%;justify-content:flex-start}
    .usr-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem;text-align:right}
    .usr-table-card .dataTables_filter label{display:inline-flex;align-items:center;gap:.4rem;color:#6b7280;font-size:.85rem;font-weight:400;margin:0}
    .usr-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem;margin:0;background:#fff;box-shadow:none;font-size:.85rem}
    .usr-table-card .dataTables_filter input:focus{border-color:#2d6da3;box-shadow:0 0 0 .15rem rgba(45,109,163,.18);outline:0}
    .usr-table-card table.dataTable{clear:both;margin:.5rem 0 0!important;width:100%!important}
    .usr-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.8rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .usr-table-card table.dataTable tbody td{vertical-align:middle}
    .usr-table-card .dataTables_info{float:left;color:#6b7280;font-size:.85rem;padding-top:1rem}
    .usr-table-card .dataTables_paginate{float:right;padding-top:.9rem}
    .usr-table-card .pagination{margin-bottom:0;gap:.2rem}
    .usr-table-card .page-link{border-radius:.55rem!important;color:#173c66;border-color:#e2e9f1;padding:.35rem .7rem;font-size:.82rem}
    .usr-table-card .page-item.active .page-link{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .usr-table-card .page-link:hover{background:#edf3f8}
    .usr-nombre strong{display:block;color:#102b4a;font-size:.92rem}
    .usr-nombre small{color:#6b7280}
    .usr-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .usr-empty i{display:block;margin-bottom:.6rem;font-size:1.8rem;color:#c3d0de}
    @media(max-width:767.98px){
        .usr-card-head{align-items:flex-start;flex-direction:column}
        .usr-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .usr-table-card .dt-buttons{float:none;width:100%;margin:.75rem 0 .35rem}
        .usr-table-card .dt-buttons .buttons-colvis,.usr-table-card .dt-buttons .buttons-page-length{display:none}
        .usr-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .usr-table-card .dataTables_filter label{display:flex;width:100%}
        .usr-table-card .dataTables_filter input{flex:1 1 auto;width:100%}
        .usr-table-card .dataTables_info{float:none;padding-top:.65rem;text-align:center}
        .usr-table-card .dataTables_paginate{float:none;padding-top:.4rem;text-align:center}
        .usr-table-card .pagination{justify-content:center;flex-wrap:wrap}
    }
</style>
@endpush

@section('contenido')
    @php
        $totalUsuarios = $users->count();
        $activos = $users->where('active', 'true')->count();
        $inactivos = $totalUsuarios - $activos;
        $tutores = $users->filter(fn ($u) => (string) ($u->tutor ?? '') === '1')->count();
        $puedeCrear = Auth::User()->hasAnyPermission(['VIP','CREAR_USUARIOS']);
        $puedeAcciones = Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS','MODIFICAR_USUARIOS','ELIMINAR_USUARIOS']);
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="usr-card usr-kpi usr-kpi--total">
                <span class="usr-kpi-icon"><i class="fa-solid fa-users"></i></span>
                <div>
                    <span class="usr-kpi-label">Usuarios</span>
                    <span class="usr-kpi-value">{{ $totalUsuarios }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="usr-card usr-kpi usr-kpi--activos">
                <span class="usr-kpi-icon"><i class="fa-solid fa-user-check"></i></span>
                <div>
                    <span class="usr-kpi-label">Activos</span>
                    <span class="usr-kpi-value">{{ $activos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="usr-card usr-kpi usr-kpi--inactivos">
                <span class="usr-kpi-icon"><i class="fa-solid fa-user-slash"></i></span>
                <div>
                    <span class="usr-kpi-label">Inactivos</span>
                    <span class="usr-kpi-value">{{ $inactivos }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="usr-card usr-kpi usr-kpi--tutores">
                <span class="usr-kpi-icon"><i class="fa-solid fa-user-graduate"></i></span>
                <div>
                    <span class="usr-kpi-label">Tutores</span>
                    <span class="usr-kpi-value">{{ $tutores }}</span>
                </div>
            </div>
        </div>
    </div>

    <article class="usr-card usr-table-card">
        <div class="usr-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-users me-2"></i>Listado de usuarios</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $totalUsuarios }}</span>
            </div>
            @if ($puedeCrear)
                <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-user-plus me-2"></i>Agregar usuario
                </a>
            @endif
        </div>

        @if ($totalUsuarios > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabUsuarios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Área</th>
                            <th>Activo</th>
                            <th>Tutor</th>
                            @if ($puedeAcciones)
                                <th class="text-end">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td class="usr-nombre">
                                    <strong>{{ strtoupper($user->name) }}</strong>
                                    <small>{{ $user->email }}</small>
                                </td>
                                <td><span class="badge rounded-pill bg-light text-dark">{{ $user->area }}</span></td>
                                <td>
                                    @if ($user->active == 'true')
                                        <span class="badge rounded-pill bg-success">Activo</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    @if ((string) ($user->tutor ?? '') === '1')
                                        <span class="badge rounded-pill bg-primary">Sí</span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>
                                @if ($puedeAcciones)
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_USUARIOS']))
                                                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Modificar usuario">
                                                    <i class="fa-solid fa-user-pen"></i>
                                                </a>
                                            @endif
                                            @if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS']))
                                                <a href="{{ route('usuarios.asignar_roles', $user->id) }}" class="btn btn-sm btn-outline-secondary" title="Asignar roles">
                                                    <i class="fa-solid fa-users-gear"></i>
                                                </a>
                                            @endif
                                            @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_USUARIOS']))
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarUsr({{ $user->id }})" title="Eliminar usuario">
                                                    <i class="fa-solid fa-user-minus"></i>
                                                </button>
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
            <div class="usr-empty">
                <i class="fa-regular fa-folder-open"></i>
                No hay usuarios para mostrar.
            </div>
        @endif
    </article>

    <form method="get" id="formEliminarUsr"></form>
@endsection

@section('js')
    <script>
        function eliminarUsr(id) {
            swal({
                title: 'Confirmación',
                text: '¿Estás seguro de que deseas eliminar este usuario?',
                icon: 'warning',
                buttons: ['Cancelar', 'Aceptar'],
            }).then(function (result) {
                if (result) {
                    var ruta = "{{ route('usuarios.destroy', ['id' => ':id']) }}";
                    ruta = ruta.replace(':id', id);
                    $('#formEliminarUsr').attr('action', ruta);
                    $('#formEliminarUsr').submit();
                }
            });
        }

        $(document).ready(function () {
            if (!$('#tabUsuarios').length) {
                return;
            }

            $('#tabUsuarios').DataTable({
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
                    emptyTable: 'Sin usuarios registrados',
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
