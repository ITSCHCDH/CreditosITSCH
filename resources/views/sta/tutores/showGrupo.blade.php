@extends('template.molde')

@section('title','Grupo de tutoría')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2 flex-wrap">
        <i class="fa-solid fa-users-gear" style="color:#2d6da3"></i>
        <a href="{{ route('tutores.index') }}" class="text-decoration-none">Tutorías</a>
        <span class="text-muted">/</span>
        Grupo {{ $grupo[0]->gpo_Nombre }}
    </span>
@endsection

@push('styles')
<style>
    .tgs-shell{display:grid;gap:1rem}
    .tgs-hero{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.25rem 1.35rem;border:1px solid #e4eaf1;border-radius:1.15rem;background:linear-gradient(135deg,#173c66,#102b4a);color:#fff;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14)}
    .tgs-hero h1{margin:.1rem 0 0;font-size:clamp(1.25rem,3vw,1.65rem);font-weight:700}
    .tgs-hero p{margin:.25rem 0 0;color:rgba(255,255,255,.78)}
    .tgs-hero-icon{width:58px;height:58px;display:grid;place-items:center;flex:0 0 58px;border-radius:1rem;background:rgba(255,255,255,.12);font-size:1.45rem}
    .tgs-card{border:1px solid #e4eaf1;border-radius:1.15rem;background:#fff;box-shadow:0 .55rem 1.35rem rgba(29,78,116,.08);overflow:hidden}
    .tgs-card-head{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .tgs-card-head h2{margin:0;color:#102b4a;font-size:1rem;font-weight:700}
    .tgs-card-body{padding:1.15rem 1.25rem}
    .tgs-kpis{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.75rem}
    .tgs-kpi{display:flex;align-items:center;gap:.75rem;padding:.85rem;border:1px solid #e7edf4;border-radius:.85rem;background:#fbfcfe}
    .tgs-kpi-icon{width:40px;height:40px;display:grid;place-items:center;flex:0 0 40px;border-radius:.75rem;color:#173c66;background:#edf3f8}
    .tgs-kpi span{display:block;color:#64748b;font-size:.74rem;text-transform:uppercase}
    .tgs-kpi strong{display:block;color:#102b4a;font-size:1.05rem}
    .tgs-actions{display:flex;justify-content:flex-end;gap:.5rem}
    .tgs-table-card{overflow:hidden}
    .tgs-table-card .dataTables_wrapper{position:relative;padding:0 1.25rem 1rem}
    .tgs-table-card .dt-buttons{float:left;margin:.85rem 0 .5rem;display:flex;gap:.4rem;flex-wrap:wrap}
    .tgs-table-card .dt-button{border:1px solid #d8e2ec!important;border-radius:.55rem!important;background:#fff!important;color:#173c66!important;font-size:.8rem!important}
    .tgs-table-card .dataTables_filter{float:right;margin:.85rem 0 .5rem}
    .tgs-table-card .dataTables_filter input{border:1px solid #d6e0ea;border-radius:.55rem;padding:.4rem .7rem}
    .tgs-table-card table.dataTable{clear:both;width:100%!important;margin:.5rem 0 0!important}
    .tgs-table-card table.dataTable thead th{background:#f8fafc;color:#102b4a;font-size:.78rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .tgs-table-card table.dataTable tbody td{vertical-align:middle}
    .tgs-semaforos{display:flex;align-items:center;gap:.38rem}
    .tgs-semaforo-link{width:18px;height:18px;border-radius:50%;display:inline-block}
    .tgs-alumno strong{display:block;color:#102b4a}
    .tgs-alumno small{color:#64748b}
    .tgs-row-actions{display:flex;justify-content:flex-end;gap:.35rem}
    .tgs-row-actions .btn{width:38px;height:38px;padding:0;display:inline-grid;place-items:center;border-radius:.65rem}
    .tgs-empty{padding:2.5rem 1rem;text-align:center;color:#64748b}
    .tgs-empty i{display:block;font-size:1.8rem;margin-bottom:.6rem;color:#b7c3d1}
    @media(max-width:991.98px){.tgs-kpis{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:575.98px){
        .tgs-hero{align-items:flex-start;flex-direction:column}
        .tgs-hero-icon{display:none}
        .tgs-kpis{grid-template-columns:1fr}
        .tgs-table-card .dataTables_wrapper{padding:0 .85rem .85rem}
        .tgs-table-card .dataTables_filter{float:none;width:100%;text-align:left;margin:.25rem 0 .5rem}
        .tgs-table-card .dataTables_filter input{width:100%}
    }
</style>
@endpush

@section('contenido')
@php
    $vigentes = $alumnosGrupo->where('status', 'VI')->count();
    $bajas = $alumnosGrupo->whereIn('status', ['BT','BD'])->count();
    $fichas = $alumnosGrupo->where('ficha', 1)->count();
@endphp

<div class="tgs-shell">
    <section class="tgs-hero">
        <div>
            <span class="small text-uppercase opacity-75">Grupo tutorado</span>
            <h1>Grupo {{ $grupo[0]->gpo_Nombre }}</h1>
            <p>{{ $grupo[0]->nomTutor }} · {{ $grupo[0]->car_Nombre }}</p>
        </div>
        <div class="tgs-hero-icon"><i class="fa-solid fa-users-rectangle"></i></div>
    </section>

    <div class="tgs-kpis">
        <article class="tgs-kpi"><span class="tgs-kpi-icon"><i class="fa-solid fa-user-graduate"></i></span><div><span>Alumnos</span><strong>{{ $alumnosGrupo->count() }}</strong></div></article>
        <article class="tgs-kpi"><span class="tgs-kpi-icon"><i class="fa-solid fa-circle-check"></i></span><div><span>Vigentes</span><strong>{{ $vigentes }}</strong></div></article>
        <article class="tgs-kpi"><span class="tgs-kpi-icon"><i class="fa-solid fa-file-circle-check"></i></span><div><span>Fichas llenas</span><strong>{{ $fichas }}</strong></div></article>
        <article class="tgs-kpi"><span class="tgs-kpi-icon"><i class="fa-solid fa-user-slash"></i></span><div><span>Bajas</span><strong>{{ $bajas }}</strong></div></article>
    </div>

    <article class="tgs-card">
        <div class="tgs-card-head">
            <h2><i class="fa-solid fa-user-plus me-2"></i>Agregar alumnos al grupo</h2>
            <a href="{{ route('tutores.analisisGrupo',$grupo[0]->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                <i class="fa-solid fa-chart-column me-2"></i>Analizar grupo
            </a>
        </div>
        <div class="tgs-card-body">
            @include('template.partes.buscador_combobox', [
                'config' => [
                    'id' => 'grupoAlumno',
                    'bare' => true,
                    'show_submit' => false,
                    'required' => false,
                    'field' => 'no_Control',
                    'label' => 'Buscar alumno',
                    'placeholder' => 'Nombre o número de control',
                    'endpoint' => route('participantes.busqueda'),
                    'query_param' => 'nombre',
                    'min_chars' => 2,
                    'limit' => 8,
                    'params' => ['peticion' => 0],
                    'keys' => ['value' => 'no_control', 'label' => 'nombre', 'meta' => ''],
                ],
            ])
            <div class="mt-3">
                <label class="form-label" for="grupoListaNoControl">Carga masiva</label>
                <input type="text" id="grupoListaNoControl" class="form-control"
                    placeholder="Ej. S23001, S23002 S23003">
                <small class="text-muted">Separa varios números de control con espacios, comas o punto y coma.</small>
            </div>
            <div class="tgs-actions mt-3">
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="agregarAlumnosGrupo()">
                    <i class="fa-solid fa-user-plus me-2"></i>Agregar al grupo
                </button>
            </div>
        </div>
    </article>

    <article class="tgs-card tgs-table-card">
        <div class="tgs-card-head">
            <div class="d-flex align-items-center gap-2">
                <h2><i class="fa-solid fa-table-list me-2"></i>Alumnos del grupo</h2>
                <span class="badge rounded-pill bg-light text-dark">{{ $alumnosGrupo->count() }}</span>
            </div>
        </div>
        @if($alumnosGrupo->count())
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="tabGrupoTut">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Control</th>
                            <th>Alumno</th>
                            <th>Status</th>
                            <th>Semáforos</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnosGrupo as $alumno)
                            @php
                                $statusMap = ['BD'=>'Baja definitiva','BT'=>'Baja temporal','VI'=>'Vigente'];
                                $statusText = $statusMap[$alumno->status] ?? 'Sin status';
                                $statusClass = $alumno->status === 'VI' ? 'bg-success' : (in_array($alumno->status,['BD','BT']) ? 'bg-danger' : 'bg-secondary');
                            @endphp
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><span class="font-monospace">{{ $alumno->no_Control }}</span></td>
                                <td class="tgs-alumno">
                                    <strong>{{ $alumno->alu_Nombre }} {{ $alumno->alu_ApePaterno }} {{ $alumno->alu_ApeMaterno }}</strong>
                                    <small>{{ $alumno->no_Control }}</small>
                                </td>
                                <td><span class="badge rounded-pill {{ $statusClass }}">{{ $statusText }}</span></td>
                                <td>
                                    <div class="tgs-semaforos">
                                        <a href="{{ route('analisis.alumno',$alumno->no_Control) }}" class="tgs-semaforo-link {{ $alumno->semaforos['semaforoAcad'] }}" data-mdb-toggle="tooltip" title="Académico: {{ $alumno->semaforos['titleAcad'] }}" aria-label="Diagnóstico académico"></a>
                                        <span class="tgs-semaforo-link {{ $alumno->semaforos['semaforoMedico'] }}" data-mdb-toggle="tooltip" title="Médico"></span>
                                        <span class="tgs-semaforo-link {{ $alumno->semaforos['semaforoPsico'] }}" data-mdb-toggle="tooltip" title="Psicológico"></span>
                                        <span class="tgs-semaforo-link {{ $alumno->semaforos['semaforoServicio'] }}" data-mdb-toggle="tooltip" title="Servicio social: {{ $alumno->semaforos['titleSS'] }}"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="tgs-row-actions">
                                        <button type="button" class="btn btn-outline-danger" onclick="eliminarAlumnoGrupo('{{ $alumno->no_Control }}')" title="Eliminar alumno" aria-label="Eliminar alumno">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <a href="{{ route('analisis.alumno',$alumno->no_Control) }}" class="btn btn-outline-primary" title="Ver diagnóstico" aria-label="Ver diagnóstico">
                                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                                        </a>
                                        <a href="{{ route('analisis.ficha',[$alumno->no_Control,2]) }}" class="btn {{ $alumno->ficha == 1 ? 'btn-outline-success' : 'btn-outline-secondary' }}" title="{{ $alumno->ficha == 1 ? 'Ver ficha' : 'Ver avance de ficha' }}" aria-label="Ver ficha">
                                            <i class="fa-solid {{ $alumno->ficha == 1 ? 'fa-file-circle-check' : 'fa-file-pen' }}"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="tgs-empty">
                <i class="fa-regular fa-folder-open"></i>
                El grupo todavía no tiene alumnos asignados.
            </div>
        @endif
    </article>
</div>
@endsection

@section('js')
<script>
    function agregarAlumnosGrupo() {
        const seleccion = $.trim($('#grupoAlumno_value').val());
        const lista = $.trim($('#grupoListaNoControl').val());
        const entrada = lista !== '' ? lista : seleccion;
        const controles = entrada === '' ? [] : entrada.split(/[\s,;]+/).filter(Boolean).map(function (control) {
            return control.trim().toUpperCase();
        });

        if (controles.length === 0) {
            swal('Error','Selecciona un alumno o captura números de control','error');
            return;
        }

        const botones = $('.tgs-actions button');
        botones.prop('disabled', true);

        $.ajax({
            url: "{{ route('tutores.storeGrupo') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                gpo_Nombre: "{{ $grupo[0]->gpo_Nombre }}",
                controles: controles
            },
            traditional: true,
            success: function (response) {
                const agregados = response.agregados || [];
                const existentes = response.existentes || [];
                const invalidos = response.invalidos || [];
                const errores = response.errores || [];
                let detalle = [];

                if (agregados.length) detalle.push(agregados.length + ' agregado(s)');
                if (existentes.length) detalle.push(existentes.length + ' ya estaba(n) en el grupo');
                if (invalidos.length) detalle.push(invalidos.length + ' no existe(n): ' + invalidos.join(', '));
                if (errores.length) detalle.push(errores.length + ' no pudo(dieron) insertarse: ' + errores.join(', '));

                swal({
                    title: agregados.length ? 'Éxito' : 'Información',
                    text: detalle.length ? detalle.join('. ') + '.' : response.message,
                    icon: agregados.length ? 'success' : 'info',
                    button: 'Cerrar'
                }).then(function () {
                    if (agregados.length || existentes.length) window.location.reload();
                });
            },
            error: function (xhr) {
                const mensaje = xhr.responseJSON?.message || 'No fue posible agregar los números de control.';
                swal('Error', mensaje, 'error');
            },
            complete: function () {
                botones.prop('disabled', false);
                $('#grupoListaNoControl').val('');
                const combo = document.getElementById('grupoAlumno_combo');
                if (combo && typeof combo.cbxReset === 'function') combo.cbxReset();
            }
        });
    }

    function eliminarAlumnoGrupo(noControl) {
        swal({
            title: '¿Eliminar alumno?',
            text: 'Se quitará el número de control '+noControl+' del grupo.',
            icon: 'warning',
            buttons: ['Cancelar','Eliminar'],
            dangerMode: true
        }).then(function (confirmado) {
            if (!confirmado) return;
            $.ajax({
                url: "{{ route('tutores.deleteAlumno') }}",
                type: 'POST',
                data: {_token: "{{ csrf_token() }}", no_Control: noControl},
                success: function () {
                    swal('Éxito','Alumno eliminado del grupo','success').then(function () {
                        window.location.reload();
                    });
                },
                error: function () {
                    swal('Error','No fue posible eliminar al alumno','error');
                }
            });
        });
    }

    $(document).ready(function () {
        if ($.fn.DataTable && $('#tabGrupoTut').length) {
            $('#tabGrupoTut').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5,10,25,50,-1],[5,10,25,50,'Ver todos']],
                dom: '<"d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3"Bf>rt<"d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3"lip>',
                order: [[2,'asc']],
                columnDefs: [{orderable:false,targets:[4,5]}],
                buttons: [
                    {extend:'copyHtml5',text:'Copiar',className:'btn btn-sm'},
                    {extend:'excelHtml5',text:'Excel',className:'btn btn-sm'},
                    {extend:'pdfHtml5',text:'PDF',className:'btn btn-sm'},
                    {extend:'print',text:'Imprimir',className:'btn btn-sm'}
                ],
                language:{url:'//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'}
            });
        }
        if (typeof mdb !== 'undefined' && mdb.Tooltip) {
            document.querySelectorAll('[data-mdb-toggle="tooltip"]').forEach(function (elemento) {
                new mdb.Tooltip(elemento);
            });
        }
    });
</script>
@endsection
