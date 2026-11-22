@extends('template.molde')

@section('title','Asignar permisos')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-shield-halved" style="color:#2d6da3"></i>
        <a href="{{ route('roles.index') }}" class="text-decoration-none">Roles y permisos</a>
        <span class="text-muted">/</span>
        Asignar permisos
    </span>
@endsection

@push('styles')
<style>
    .ap-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .ap-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .ap-card-head h1{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .ap-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .ap-card-body{padding:1.25rem}
    .ap-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .ap-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .ap-count{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .55rem;border-radius:999px;background:#f1ebfd;color:#5b21b6;font-size:.78rem;font-weight:600}
    .ap-buscar{max-width:280px}
    .ap-grupo{margin-bottom:1rem}
    .ap-grupo-titulo{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.5rem;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.75rem;font-weight:600;letter-spacing:.02em;text-transform:uppercase}
    .ap-permiso{display:flex;align-items:center;gap:.55rem;padding:.45rem .6rem;border:1px solid #e7edf4;border-radius:.5rem;background:#fff;cursor:pointer;transition:.15s ease;height:100%}
    .ap-permiso:hover{border-color:#b9cde1;background:#f8fbff}
    .ap-permiso .form-check-input{margin:0;flex:0 0 auto}
    .ap-permiso span{color:#334155;font-size:.8rem;line-height:1.25;word-break:break-word}
    .ap-permiso:has(input:checked){border-color:#2d6da3;background:#eef5fc}
    .ap-permiso:has(input:checked) span{color:#102b4a;font-weight:600}
    .ap-permiso .ap-asignado{display:none;color:#1b7a43;font-size:.7rem}
    .ap-permiso:has(input:checked) .ap-asignado{display:inline-flex;align-items:center;gap:.2rem}
    .ap-permisos-scroll{max-height:440px;overflow:auto;padding-right:.35rem}
    .ap-rol-dato{display:flex;justify-content:space-between;gap:.75rem;padding:.5rem 0;border-bottom:1px dashed #e7edf4;font-size:.87rem}
    .ap-rol-dato:last-child{border-bottom:0}
    .ap-rol-dato span:first-child{color:#6b7280}
    .ap-rol-dato span:last-child{color:#102b4a;font-weight:600;text-align:right}
    @media(max-width:767.98px){
        .ap-card-body{padding:1rem}
        .ap-buscar{max-width:none;width:100%}
        .ap-permisos-scroll{max-height:none}
    }
</style>
@endpush

@section('contenido')
    @php
        $asignados = $permisos->where('role_id', '!=', null)->count();
        $grupos = collect($permisos)->groupBy(fn ($permiso) => \Illuminate\Support\Str::afterLast($permiso->name, '_'))->sortKeys();
    @endphp

    <input type="hidden" name="role_id" value="{{ $role->id }}" id="role_id">

    @if ($role == null)
        <div class="alert alert-warning mb-3" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>El rol solicitado no existe.
        </div>
    @else
        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <article class="ap-card h-100">
                    <div class="ap-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="ap-icon"><i class="fa-solid fa-user-shield"></i></span>
                            <div>
                                <h1>{{ $role->name }}</h1>
                                <p>Resumen del rol seleccionado.</p>
                            </div>
                        </div>
                    </div>
                    <div class="ap-card-body">
                        <div class="ap-rol-dato">
                            <span>Identificador</span>
                            <span>{{ $role->id }}</span>
                        </div>
                        <div class="ap-rol-dato">
                            <span>Permisos asignados</span>
                            <span>{{ $asignados }} de {{ $permisos->count() }}</span>
                        </div>
                        <div class="ap-rol-dato">
                            <span>Última actualización</span>
                            <span>{{ optional($role->updated_at)->format('d/m/Y H:i') ?? '—' }}</span>
                        </div>
                        <a href="{{ route('roles.role_ver_permisos', $role->id) }}" class="btn btn-sm btn-outline-secondary mt-3">
                            <i class="fa-regular fa-eye me-2"></i>Ver solo los asignados
                        </a>
                        <p class="text-muted small mt-3 mb-0">Marcá los permisos que querés habilitar y guardá los cambios.</p>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-8">
                <article class="ap-card h-100">
                    <div class="ap-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="ap-icon"><i class="fa-solid fa-key"></i></span>
                            <div>
                                <h1>Permisos del rol</h1>
                                <p>Agrupados por módulo.</p>
                            </div>
                        </div>
                        <span class="ap-count"><i class="fa-solid fa-check-double"></i><span id="permisosCount">{{ $asignados }}</span> seleccionados</span>
                    </div>
                    <div class="ap-card-body">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <div class="input-group ap-buscar">
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

                        <div class="ap-permisos-scroll">
                            @forelse ($grupos as $grupo => $items)
                                <div class="ap-grupo" data-permiso-grupo>
                                    <span class="ap-grupo-titulo"><i class="fa-solid fa-folder-tree"></i>{{ $grupo }} · {{ $items->count() }}</span>
                                    <div class="row g-2">
                                        @foreach ($items as $per)
                                            <div class="col-12 col-md-6 col-xxl-4" data-permiso-item data-nombre="{{ \Illuminate\Support\Str::lower($per->name) }}">
                                                <label class="ap-permiso" title="{{ $per->name }}">
                                                    <input class="form-check-input permisos_asignados" type="checkbox" name="permisos_id[]" value="{{ $per->id }}" id="c{{ $per->id }}" @checked($per->role_id != null)>
                                                    <span>{{ str_replace('_', ' ', $per->name) }}</span>
                                                    <span class="ap-asignado ms-auto"><i class="fa-solid fa-circle-check"></i>Asignado</span>
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
                    <div class="ap-footer">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="button" class="btn btn-primary" id="permisos-submit">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar permisos
                        </button>
                    </div>
                </article>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function actualizarContadorPermisos() {
            $('#permisosCount').text($('.permisos_asignados:checked').length);
        }

        $(document).ready(function () {
            actualizarContadorPermisos();

            $('.permisos_asignados').on('change', actualizarContadorPermisos);

            $('#permisosTodos').on('click', function () {
                $('[data-permiso-item]:visible .permisos_asignados').prop('checked', true);
                actualizarContadorPermisos();
            });

            $('#permisosNinguno').on('click', function () {
                $('.permisos_asignados').prop('checked', false);
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

            $('#permisos-submit').on('click', function () {
                var boton = $(this);
                var seleccionados = $('.permisos_asignados:checked').map(function () {
                    return $(this).val();
                }).get();

                var guardar = function () {
                    boton.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin me-2"></i>Guardando…');

                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "{{ route('roles.roles_asignar_permisos') }}",
                        data: {
                            permisos_id: seleccionados,
                            role_id: $('#role_id').val()
                        },
                        success: function () {
                            location.href = "{{ route('roles.index') }}";
                        },
                        error: function (e) {
                            boton.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i>Guardar permisos');
                            swal('Error', 'No se pudieron guardar los permisos.', 'error');
                            console.log('Error al asignar permisos', e);
                        }
                    });
                };

                if (seleccionados.length === 0) {
                    swal({
                        title: '¿Quitar todos los permisos?',
                        text: 'El rol quedará sin permisos asignados.',
                        icon: 'warning',
                        buttons: ['Cancelar', 'Sí, guardar'],
                    }).then(function (confirmar) {
                        if (confirmar) { guardar(); }
                    });
                } else {
                    guardar();
                }
            });
        });
    </script>
@endsection
