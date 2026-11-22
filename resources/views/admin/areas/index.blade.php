@extends('template.molde')

@section('title','Áreas administrativas')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-sitemap" style="color:#2d6da3"></i>
        Áreas administrativas
    </span>
@endsection

@push('styles')
<style>
    .areas-shell{display:grid;gap:1rem}
    .areas-hero{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1.25rem 1.35rem;border:1px solid #e4eaf1;border-radius:1.15rem;background:linear-gradient(135deg,#173c66,#102b4a);color:#fff;box-shadow:0 .75rem 1.5rem rgba(16,43,74,.14)}
    .areas-hero h1{margin:.15rem 0 0;font-size:clamp(1.25rem,3vw,1.75rem);font-weight:700}
    .areas-hero p{margin:.35rem 0 0;color:rgba(255,255,255,.78)}
    .areas-hero-icon{width:58px;height:58px;display:grid;place-items:center;border-radius:1rem;background:rgba(255,255,255,.12);font-size:1.45rem}
    .areas-card{border:1px solid #e4eaf1;border-radius:1.15rem;background:#fff;box-shadow:0 .55rem 1.35rem rgba(29,78,116,.08);overflow:hidden}
    .areas-card-head{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .areas-card-head h2{margin:0;font-size:1rem;font-weight:700;color:#102b4a}
    .areas-card-body{padding:1rem 1.25rem 1.25rem}
    .areas-count{font-weight:800;font-size:1.15rem;color:#173c66}
    .areas-actions{display:flex;justify-content:flex-end;gap:.4rem}
    .areas-actions .btn{width:38px;height:38px;display:inline-grid;place-items:center;padding:0;border-radius:.65rem}
    .areas-table tbody tr{transition:background-color .15s ease}
    .areas-table tbody tr:hover{background:#f7fafc}
    .areas-table td,.areas-table th{vertical-align:middle}
    .areas-type{display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.78rem;font-weight:700}
    @media(max-width:767.98px){
        .areas-hero{align-items:flex-start}
        .areas-hero-icon{display:none}
        .areas-card-body{padding:.75rem}
    }
</style>
@endpush

@section('contenido')
<div class="areas-shell">
    <section class="areas-hero">
        <div>
            <span class="small text-uppercase opacity-75">Administración</span>
            <h1>Áreas administrativas</h1>
            <p>Departamentos internos disponibles para asignar usuarios.</p>
        </div>
        <div class="areas-hero-icon"><i class="fa-solid fa-building-columns"></i></div>
    </section>

    <div class="d-flex justify-content-end">
        @if(Auth::User()->hasAnyPermission(['VIP','CREAR_AREAS']))
            <a href="{{ route('areas.crear') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Nueva área
            </a>
        @endif
    </div>

    <article class="areas-card">
        <div class="areas-card-head">
            <h2><i class="fa-solid fa-list-ul me-2 text-primary"></i>Listado de áreas</h2>
            <span class="areas-count">{{ $areas->count() }} {{ $areas->count() === 1 ? 'área' : 'áreas' }}</span>
        </div>
        <div class="areas-card-body">
            <table class="table areas-table" id="tabAreas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($areas as $area)
                        <tr>
                            <td><span class="text-muted">#{{ $area->id }}</span></td>
                            <td><strong>{{ $area->nombre }}</strong></td>
                            <td>
                                <span class="areas-type">
                                    <i class="fa-solid fa-building"></i>{{ ucfirst($area->tipo) }}
                                </span>
                            </td>
                            <td>
                                <div class="areas-actions">
                                    <a href="{{ route('areas.usuarios',$area->id) }}" class="btn btn-primary" title="Ver usuarios">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    @if(Auth::User()->hasAnyPermission(['VIP','MODIFICAR_AREAS']))
                                        <a href="{{ route('areas.editar',$area->id) }}" class="btn btn-warning" title="Editar área">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(Auth::User()->hasAnyPermission(['VIP','ELIMINAR_AREAS']))
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalBaja"
                                            onclick="ruta({{ $area->id }})" class="btn btn-danger" title="Eliminar área">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fa-solid fa-building-circle-xmark d-block fs-3 mb-2"></i>
                                No hay áreas administrativas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</div>

<div class="modal fade" id="modalBaja" tabindex="-1" aria-labelledby="modalBajaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBajaTitle"><i class="fa-solid fa-trash-can text-danger me-2"></i>Eliminar área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Confirmas eliminar esta área administrativa?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger" id="eliminar"><i class="fa-solid fa-trash-can me-2"></i>Eliminar</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    function ruta(id) {
        document.getElementById('eliminar').setAttribute('href', '{{ url("admin/areas") }}/' + id + '/eliminar');
    }

    $(document).ready(function() {
        if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tabAreas')) {
            $('#tabAreas').DataTable({
                responsive:true,
                pageLength:10,
                lengthMenu:[[5,10,25,50,-1],[5,10,25,50,'Ver todo']],
                dom:'<"d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3"lfB>rt<"d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3"ip>',
                buttons:[
                    {extend:'copyHtml5',text:'Copiar',className:'btn btn-light btn-sm'},
                    {extend:'excelHtml5',text:'Excel',className:'btn btn-light btn-sm'},
                    {extend:'pdfHtml5',text:'PDF',className:'btn btn-light btn-sm'},
                    {extend:'print',text:'Imprimir',className:'btn btn-light btn-sm'}
                ],
                language:{url:'//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'}
            });
        }
    });
</script>
@endsection
