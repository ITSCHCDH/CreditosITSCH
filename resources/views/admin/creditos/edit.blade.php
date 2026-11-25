@extends('template.molde')

@section('title','Créditos | Editar')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-award" style="color:#2d6da3"></i>
        <a href="{{ route('creditos.index') }}" class="text-decoration-none">Créditos</a>
        <span class="text-muted">/</span>
        Editar
    </span>
@endsection

@push('styles')
<style>
    .editar-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .editar-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .editar-card-head h1,.editar-card-head h2{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .editar-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .editar-card-body{padding:1.25rem}
    .editar-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .editar-clave{display:inline-flex;align-items:center;gap:.4rem;padding:.25rem .6rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.78rem;font-weight:600}
    .editar-area{display:flex;align-items:center;gap:.6rem;height:100%;padding:.55rem .7rem;border:1px solid #e7edf4;border-radius:.6rem;background:#fff;cursor:pointer;transition:border-color .15s ease,background-color .15s ease,transform .15s ease}
    .editar-area:hover{border-color:#b9cde1;background:#f8fbff;transform:translateY(-1px)}
    .editar-area .form-check-input{margin:0;flex:0 0 auto}
    .editar-area span{color:#334155;font-size:.88rem;line-height:1.25}
    .editar-area:has(input:checked){border-color:#2d6da3;background:#eef5fc}
    .editar-area:has(input:checked) span{color:#102b4a;font-weight:600}
    .editar-count{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .55rem;border-radius:999px;background:#e7f5ec;color:#1b7a43;font-size:.78rem;font-weight:600}
    .editar-buscar{max-width:280px}
    .editar-footer{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .editar-acciones{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem}
    @media(max-width:767.98px){
        .editar-card-body{padding:1rem}
        .editar-buscar{max-width:none;width:100%}
        .editar-footer{align-items:stretch}
        .editar-acciones,.editar-acciones .btn{width:100%}
    }
</style>
@endpush

@section('contenido')
    @php
        $areasSeleccionadas = collect(old(
            'areas',
            $areas->filter(fn ($area) => $area->credito_id !== null)->pluck('id')
        ))->map(fn ($id) => (string) $id)->all();
        $jefeId = (string) old('credito_jefe', $credito->credito_jefe);
        $jefeActual = $usuarios->first(fn ($usuario) => (string) $usuario->id === $jefeId);
        $jefeInicial = $jefeActual ? [
            'id' => (string) $jefeActual->id,
            'name' => $jefeActual->name,
        ] : null;
    @endphp

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Revisa los datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('creditos.update', $credito->id) }}" method="post" id="formCredito">
        @csrf

        <div class="row g-3">
            <div class="col-12 col-xl-5">
                <article class="editar-card h-100">
                    <div class="editar-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="editar-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                            <div>
                                <h1>Datos del crédito</h1>
                                <p>Actualiza el nombre, responsable y vigencia.</p>
                            </div>
                        </div>
                        <span class="editar-clave">
                            <i class="fa-solid fa-hashtag"></i>Clave {{ $credito->id }}
                        </span>
                    </div>
                    <div class="editar-card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre del crédito</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-award"></i></span>
                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    maxlength="70"
                                    required
                                    value="{{ old('nombre', $credito->nombre) }}"
                                    placeholder="Ej. Tutorías"
                                >
                            </div>
                            @error('nombre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            @include('template.partes.buscador_combobox', [
                                'config' => [
                                    'id' => 'creditoJefe',
                                    'bare' => true,
                                    'show_submit' => false,
                                    'show_value' => false,
                                    'required' => true,
                                    'field' => 'credito_jefe',
                                    'label' => 'Jefe del crédito',
                                    'placeholder' => 'Escribe nombre o apellidos',
                                    'endpoint' => route('creditos.jefes_busqueda'),
                                    'query_param' => 'nombre',
                                    'min_chars' => 1,
                                    'limit' => 10,
                                    'keys' => ['value' => 'id', 'label' => 'name', 'meta' => ''],
                                    'initial' => $jefeInicial,
                                    'matches_label' => 'Jefes disponibles',
                                ],
                            ])
                            @error('credito_jefe')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="vigente" value="false">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                name="vigente"
                                id="vigente"
                                value="true"
                                @checked(old('vigente', $credito->vigente) !== 'false')
                            >
                            <label class="form-check-label fw-medium" for="vigente">Crédito vigente</label>
                            <div class="form-text">Los créditos no vigentes permanecen registrados, pero no se muestran como activos.</div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-7">
                <article class="editar-card h-100">
                    <div class="editar-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="editar-icon"><i class="fa-solid fa-building-columns"></i></span>
                            <div>
                                <h2>Áreas que aplican</h2>
                                <p>Selecciona las carreras que pueden usar este crédito.</p>
                            </div>
                        </div>
                        <span class="editar-count">
                            <i class="fa-solid fa-check-double"></i>
                            <span id="areasCount">{{ count($areasSeleccionadas) }}</span> seleccionadas
                        </span>
                    </div>
                    <div class="editar-card-body">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <div class="input-group editar-buscar">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="search" class="form-control border-start-0" id="areasBuscar" placeholder="Buscar área" aria-label="Buscar área">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="areasTodas">
                                <i class="fa-solid fa-check-double me-1"></i>Seleccionar todas
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="areasNinguna">
                                <i class="fa-solid fa-xmark me-1"></i>Limpiar
                            </button>
                        </div>

                        <div class="row g-2" id="areasGrid">
                            @forelse ($areas as $area)
                                <div class="col-12 col-md-6" data-area-item data-nombre="{{ \Illuminate\Support\Str::lower($area->nombre) }}">
                                    <label class="editar-area">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="areas[]"
                                            value="{{ $area->id }}"
                                            @checked(in_array((string) $area->id, $areasSeleccionadas, true))
                                        >
                                        <span>{{ $area->nombre }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted mb-0">No hay carreras activas en SIT.</p>
                                </div>
                            @endforelse
                        </div>
                        <p class="text-muted small mt-3 mb-0" id="areasSinResultados" hidden>
                            No hay áreas que coincidan con la búsqueda.
                        </p>
                        @error('areas')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </article>
            </div>
        </div>

        <div class="editar-card mt-3">
            <div class="editar-footer">
                <span class="text-muted small">
                    <i class="fa-solid fa-circle-info me-1"></i>Los cambios se aplicarán al guardar.
                </span>
                <div class="editar-acciones">
                    <a href="{{ route('creditos.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function actualizarContador() {
            $('#areasCount').text($('input[name="areas[]"]:checked').length);
        }

        $(document).ready(function () {
            actualizarContador();

            $('input[name="areas[]"]').on('change', actualizarContador);

            $('#areasTodas').on('click', function () {
                $('[data-area-item]:visible input[name="areas[]"]').prop('checked', true);
                actualizarContador();
            });

            $('#areasNinguna').on('click', function () {
                $('input[name="areas[]"]').prop('checked', false);
                actualizarContador();
            });

            $('#areasBuscar').on('input', function () {
                var termino = $(this).val().toLowerCase().trim();
                var visibles = 0;

                $('[data-area-item]').each(function () {
                    var coincide = String($(this).data('nombre')).indexOf(termino) !== -1;
                    $(this).toggle(coincide);
                    if (coincide) {
                        visibles++;
                    }
                });

                $('#areasSinResultados').prop('hidden', visibles > 0);
            });

            $('#formCredito').on('submit', function (evento) {
                if (!$('#creditoJefe_value').val()) {
                    evento.preventDefault();
                    $('#creditoJefe_input').focus();
                    $('#creditoJefe_status').text('Selecciona un jefe de la lista antes de continuar.').attr('data-state', 'error');
                    return;
                }

                if ($('input[name="areas[]"]:checked').length === 0) {
                    evento.preventDefault();
                    swal('Faltan áreas', 'Selecciona al menos una carrera para el crédito.', 'info');
                }
            });
        });
    </script>
@endsection
