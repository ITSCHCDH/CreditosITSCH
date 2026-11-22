@extends('template.molde')

@section('title','Créditos | Altas')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-award" style="color:#2d6da3"></i>
        <a href="{{ route('creditos.index') }}" class="text-decoration-none">Créditos</a>
        <span class="text-muted">/</span>
        Altas
    </span>
@endsection

@push('styles')
<style>
    .alta-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .alta-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .alta-card-head h1{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .alta-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .alta-card-body{padding:1.25rem}
    .alta-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .alta-area{display:flex;align-items:center;gap:.6rem;padding:.55rem .7rem;border:1px solid #e7edf4;border-radius:.6rem;background:#fff;cursor:pointer;transition:.15s ease;height:100%}
    .alta-area:hover{border-color:#b9cde1;background:#f8fbff}
    .alta-area .form-check-input{margin:0;flex:0 0 auto}
    .alta-area span{color:#334155;font-size:.88rem;line-height:1.25}
    .alta-area:has(input:checked){border-color:#2d6da3;background:#eef5fc}
    .alta-area:has(input:checked) span{color:#102b4a;font-weight:600}
    .alta-count{display:inline-flex;align-items:center;gap:.35rem;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.78rem;font-weight:600}
    .alta-buscar{max-width:260px}
    .alta-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    @media(max-width:767.98px){
        .alta-card-body{padding:1rem}
        .alta-buscar{max-width:none;width:100%}
    }
</style>
@endpush

@section('contenido')
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

    <form action="{{ route('creditos.store') }}" method="post" id="formCredito">
        @csrf

        <div class="row g-3">
            {{-- Datos del crédito --}}
            <div class="col-12 col-xl-5">
                <article class="alta-card h-100">
                    <div class="alta-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="alta-icon"><i class="fa-solid fa-award"></i></span>
                            <div>
                                <h1>Datos del crédito</h1>
                                <p>Nombre, responsable y vigencia.</p>
                            </div>
                        </div>
                    </div>
                    <div class="alta-card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre del crédito</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="70" required value="{{ old('nombre') }}" placeholder="Ej. Tutorías">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="credito_jefe">Jefe del crédito</label>
                            <select name="credito_jefe" id="credito_jefe" class="form-select" required>
                                <option value="">Seleccione un jefe</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" @selected(old('credito_jefe') == $usuario->id)>{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="vigente" value="false">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="vigente" id="vigente" value="true" @checked(old('vigente', 'true') !== 'false')>
                            <label class="form-check-label" for="vigente">Crédito vigente</label>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Áreas --}}
            <div class="col-12 col-xl-7">
                <article class="alta-card h-100">
                    <div class="alta-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="alta-icon"><i class="fa-solid fa-building-columns"></i></span>
                            <div>
                                <h1>Áreas que aplican</h1>
                                <p>Carreras del SIT que pueden registrar actividades de este crédito.</p>
                            </div>
                        </div>
                        <span class="alta-count"><i class="fa-solid fa-check-double"></i><span id="areasCount">0</span> seleccionadas</span>
                    </div>
                    <div class="alta-card-body">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <div class="input-group alta-buscar">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="search" class="form-control border-start-0" id="areasBuscar" placeholder="Buscar área">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="areasTodas">
                                <i class="fa-solid fa-check-double me-1"></i>Todas
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="areasNinguna">
                                <i class="fa-solid fa-xmark me-1"></i>Ninguna
                            </button>
                        </div>

                        <div class="row g-2" id="areasGrid">
                            @forelse ($areas as $area)
                                <div class="col-12 col-md-6" data-area-item data-nombre="{{ \Illuminate\Support\Str::lower($area->nombre) }}">
                                    <label class="alta-area">
                                        <input class="form-check-input" type="checkbox" name="areas[]" value="{{ $area->id }}" @checked(in_array($area->id, old('areas', [])))>
                                        <span>{{ $area->nombre }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted mb-0">No hay carreras activas en SIT.</p>
                                </div>
                            @endforelse
                        </div>
                        <p class="text-muted small mt-3 mb-0" id="areasSinResultados" hidden>No hay áreas que coincidan con la búsqueda.</p>
                    </div>
                </article>
            </div>
        </div>

        <div class="alta-card mt-3">
            <div class="alta-footer">
                <a href="{{ route('creditos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Registrar crédito
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        function actualizarContador() {
            var total = $('input[name="areas[]"]:checked').length;
            $('#areasCount').text(total);
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
                    var coincide = $(this).data('nombre').indexOf(termino) !== -1;
                    $(this).toggle(coincide);
                    if (coincide) { visibles++; }
                });

                $('#areasSinResultados').prop('hidden', visibles > 0);
            });

            $('#formCredito').on('submit', function (evento) {
                if ($('input[name="areas[]"]:checked').length === 0) {
                    evento.preventDefault();
                    swal('Faltan áreas', 'Seleccioná al menos una carrera para el crédito.', 'info');
                }
            });
        });
    </script>
@endsection
