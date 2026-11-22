@extends('template.molde')

@section('title','Constancias')

@section('links')
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-certificate" style="color:#2d6da3"></i>
        Constancias
    </span>
@endsection

@push('styles')
<style>
    .const-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .const-card-head{display:flex;align-items:center;gap:.75rem;padding:.9rem 1.1rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .const-card-head h1{margin:0;color:#102b4a;font-size:.98rem;font-weight:700}
    .const-card-head p{margin:.1rem 0 0;color:#6b7280;font-size:.79rem}
    .const-card-body{padding:1.1rem}
    .const-icon{width:40px;height:40px;flex:0 0 40px;display:grid;place-items:center;border-radius:.75rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .const-img-preview{display:flex;align-items:center;justify-content:center;min-height:100px;margin-top:.6rem;padding:.6rem;border:1px dashed #cfdceb;border-radius:.7rem;background:#fff}
    .const-img-preview img{max-width:100%;max-height:120px;object-fit:contain;border-radius:.4rem}
    .const-alert{border:1px solid #f4d9a8;border-radius:.85rem;background:#fdf6e8;color:#8a5a00;padding:1rem 1.1rem}
    .const-alert h2{margin:0 0 .35rem;font-size:.95rem;font-weight:700;color:#7a4f00}
    .const-alert ul{margin:0;padding-left:1.1rem}
    .const-alert li{font-size:.85rem}
    @media(max-width:767.98px){
        .const-card-body{padding:.95rem}
    }
</style>
@endpush

@section('contenido')
    <input type="hidden" name="" id="variable-ocultar" value="@if ($datos_globales->count()==0){{ 0 }}@else{{ 1 }}@endif">

    @if (Auth::User()->hasAnyPermission(['VIP','VIP_CONSTANCIAS']))
        <div id="mensajes-parte-superior"></div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
            <div>
                <h2 class="h5 mb-0" style="color:#102b4a"><i class="fa-solid fa-stamp me-2"></i>Datos globales de la constancia</h2>
                <p class="text-muted small mb-0">Firmas, puestos e imágenes que aparecen en todas las constancias.</p>
            </div>
            @if ($datos_globales->count() > 0)
                <span class="badge rounded-pill bg-success"><i class="fa-solid fa-circle-check me-1"></i>Registrados</span>
            @else
                <span class="badge rounded-pill bg-warning text-dark"><i class="fa-solid fa-triangle-exclamation me-1"></i>Pendientes</span>
            @endif
        </div>

        @if ($datos_globales->count() == 0)
            <div class="const-alert mb-3" id="mensaje-agregar-datos">
                <h2><i class="fa-solid fa-triangle-exclamation me-2"></i>Atención</h2>
                Antes de crear o editar constancias, proporcioná los datos globales, el encabezado y el pie de página.
            </div>
        @endif

        <form action="{{ route('constancias.guardar_datos_globales') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row g-3">
                {{-- Jefe de Servicios Escolares --}}
                <div class="col-12 col-xl-6">
                    <article class="const-card h-100">
                        <div class="const-card-head">
                            <span class="const-icon"><i class="fa-solid fa-user-tie"></i></span>
                            <div>
                                <h1>Jefe de Servicios Escolares</h1>
                                <p>Firma que aparece como responsable de la constancia.</p>
                            </div>
                        </div>
                        <div class="const-card-body">
                            <div class="row g-2 mb-2">
                                <div class="col-5">
                                    <label class="form-label" for="profesion_jefe_depto">Abreviatura</label>
                                    <select class="form-select" name="profesion_jefe_depto" id="profesion_jefe_depto">
                                        <option value="">Abreviatura de profesión</option>
                                        @if ($datos_globales->count() > 0)
                                            @if (substr($datos_globales[0]->profesion_jefe_depto, 0, 5) == "otro-")
                                                @php $cadena = substr($datos_globales[0]->profesion_jefe_depto, 5); @endphp
                                                <option value="{{ $datos_globales[0]->profesion_certificador }}" id="otro-jefe-depto" selected>{{ "otro->".$cadena }}</option>
                                                @for ($x = 0; $x < count($abreviaturas); $x++)
                                                    <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                @endfor
                                            @else
                                                <option value="otro-" id="otro-jefe-depto">Otro (especificar)</option>
                                                @for ($x = 0; $x < count($abreviaturas); $x++)
                                                    @if ($datos_globales[0]->profesion_jefe_depto == $abreviaturas[$x]['abreviatura'])
                                                        <option value="{{ $abreviaturas[$x]['abreviatura'] }}" selected>{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                    @else
                                                        <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                    @endif
                                                @endfor
                                            @endif
                                        @else
                                            <option value="otro-" id="otro-jefe-depto">Otro (especificar)</option>
                                            @for ($x = 0; $x < count($abreviaturas); $x++)
                                                <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                                <div class="col-7">
                                    <label class="form-label" for="jefe_depto">Nombre</label>
                                    <select name="jefe_depto" id="jefe_depto" class="form-select" required>
                                        <option value="">Nombre del jefe de departamento</option>
                                        @if ($datos_globales->count() > 0)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @selected($datos_globales[0]->jefe_depto == $user->id)>{{ strtoupper($user->name) }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ strtoupper($user->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <label class="form-label" for="jefe_depto_enunciado">Puesto</label>
                            <input type="text" name="jefe_depto_enunciado" id="jefe_depto_enunciado" required placeholder="Ej. Jefe del Depto. de Servicios Escolares" class="form-control" value="{{ $datos_globales->count() > 0 ? $datos_globales[0]->jefe_depto_enunciado : '' }}">
                        </div>
                    </article>
                </div>

                {{-- Vo.Bo --}}
                <div class="col-12 col-xl-6">
                    <article class="const-card h-100">
                        <div class="const-card-head">
                            <span class="const-icon"><i class="fa-solid fa-user-check"></i></span>
                            <div>
                                <h1>Vo.Bo</h1>
                                <p>Persona que certifica el documento.</p>
                            </div>
                        </div>
                        <div class="const-card-body">
                            <div class="row g-2 mb-2">
                                <div class="col-5">
                                    <label class="form-label" for="profesion_certificador">Abreviatura</label>
                                    <select class="form-select" name="profesion_certificador" id="profesion_certificador">
                                        <option value="">Abreviatura de profesión</option>
                                        @if ($datos_globales->count() > 0)
                                            @if (substr($datos_globales[0]->profesion_certificador, 0, 5) == "otro-")
                                                @php $cadena = substr($datos_globales[0]->profesion_certificador, 5); @endphp
                                                <option value="{{ $datos_globales[0]->profesion_certificador }}" id="otro-certificador" selected>{{ "otro->".$cadena }}</option>
                                                @for ($x = 0; $x < count($abreviaturas); $x++)
                                                    <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                @endfor
                                            @else
                                                <option value="otro-" id="otro-certificador">Otro (especificar)</option>
                                                @for ($x = 0; $x < count($abreviaturas); $x++)
                                                    @if ($datos_globales[0]->profesion_certificador == $abreviaturas[$x]['abreviatura'])
                                                        <option value="{{ $abreviaturas[$x]['abreviatura'] }}" selected>{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                    @else
                                                        <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                                    @endif
                                                @endfor
                                            @endif
                                        @else
                                            <option value="otro-" id="otro-certificador">Otro (especificar)</option>
                                            @for ($x = 0; $x < count($abreviaturas); $x++)
                                                <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                                <div class="col-7">
                                    <label class="form-label" for="certificador">Nombre</label>
                                    <select name="certificador" id="certificador" class="form-select" required>
                                        <option value="">Nombre de quién certifica el documento</option>
                                        @if ($datos_globales->count() > 0)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @selected($datos_globales[0]->certificador == $user->id)>{{ strtoupper($user->name) }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ strtoupper($user->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <label class="form-label" for="certificador_enunciado">Puesto del Vo.Bo</label>
                            <input type="text" name="certificador_enunciado" id="certificador_enunciado" required placeholder="Ej. Director Académico" class="form-control" value="{{ $datos_globales->count() > 0 ? $datos_globales[0]->certificador_enunciado : '' }}">
                        </div>
                    </article>
                </div>

                {{-- Encabezado --}}
                <div class="col-12 col-xl-6">
                    <article class="const-card h-100">
                        <div class="const-card-head">
                            <span class="const-icon"><i class="fa-solid fa-image"></i></span>
                            <div>
                                <h1>Encabezado</h1>
                                <p>Imagen de la parte superior de la constancia.</p>
                            </div>
                        </div>
                        <div class="const-card-body">
                            <label class="form-label" for="imagen_encabezado">Imagen de encabezado</label>
                            <input type="file" name="imagen_encabezado" id="imagen_encabezado" class="form-control" required>
                            @if ($datos_globales->count() > 0)
                                <div class="const-img-preview" id="img-encabezado">
                                    <img src="{{ asset('/storage/constancia_imagenes/encabezado/'.$datos_globales[0]->imagen_encabezado) }}" alt="Encabezado actual">
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                {{-- Pie de página --}}
                <div class="col-12 col-xl-6">
                    <article class="const-card h-100">
                        <div class="const-card-head">
                            <span class="const-icon"><i class="fa-solid fa-image"></i></span>
                            <div>
                                <h1>Pie de página</h1>
                                <p>Imagen de la parte inferior de la constancia.</p>
                            </div>
                        </div>
                        <div class="const-card-body">
                            <label class="form-label" for="imagen_pie">Imagen de pie de página</label>
                            <input type="file" name="imagen_pie" id="imagen_pie" class="form-control" required>
                            @if ($datos_globales->count() > 0)
                                <div class="const-img-preview" id="img-pie-de-pagina">
                                    <img src="{{ asset('/storage/constancia_imagenes/pie_de_pagina/'.$datos_globales[0]->imagen_pie) }}" alt="Pie de página actual">
                                </div>
                            @endif
                        </div>
                    </article>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar datos globales
                </button>
            </div>
        </form>
    @endif

    {{-- Datos específicos por carrera --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-4 mb-2">
        <div>
            <h2 class="h5 mb-0" style="color:#102b4a"><i class="fa-solid fa-graduation-cap me-2"></i>Datos específicos por carrera</h2>
            <p class="text-muted small mb-0">Jefe de división, enunciado y plan de estudios de cada constancia.</p>
        </div>
    </div>

    <div class="const-alert ocultar-formulario mb-3" id="constancias-faltantes">
        <h2><i class="fa-solid fa-triangle-exclamation me-2"></i>Constancias incompletas</h2>
        <p class="mb-2">A estas carreras les faltan datos; completarlos evita problemas al consultar las constancias.</p>
        <div>
            <ul></ul>
        </div>
    </div>

    <div id="mensajes-parte_media"></div>

    <form class="ocultar-formulario" method="post" id="form-datos-especificos">
        <input type="hidden" value="{{ csrf_token() }}" id="token">

        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <article class="const-card h-100">
                    <div class="const-card-head">
                        <span class="const-icon"><i class="fa-solid fa-building-columns"></i></span>
                        <div>
                            <h1>Carrera</h1>
                            <p>Elegí la carrera a configurar.</p>
                        </div>
                    </div>
                    <div class="const-card-body">
                        <label class="form-label" for="carrera">Carrera</label>
                        <select id="carrera" name="carrera" class="form-select" required>
                            <option value="" selected>Seleccione una carrera</option>
                            @foreach ($carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Al elegirla se cargan sus datos actuales.</small>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-8">
                <article class="const-card h-100">
                    <div class="const-card-head">
                        <span class="const-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                        <div>
                            <h1>Datos de la carrera</h1>
                            <p>Se habilitan cuando elegís una carrera.</p>
                        </div>
                    </div>
                    <div class="const-card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="jefe_division">Jefe de división</label>
                                <div class="row g-2">
                                    <div class="col-5">
                                        <select class="form-select" name="profesion_jefe_division" id="profesion_jefe_division">
                                            <option value="">Abreviatura</option>
                                            <option value="otro-" id="otro-jefe-division">Otro (especificar)</option>
                                            @for ($x = 0; $x < count($abreviaturas); $x++)
                                                <option value="{{ $abreviaturas[$x]['abreviatura'] }}">{{ $abreviaturas[$x]['profesion'] }}->{{ $abreviaturas[$x]['abreviatura'] }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-7">
                                        <select name="jefe_division" id="jefe_division" class="form-select" required>
                                            <option value="">Nombre del jefe de división</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="division_enunciado">Enunciado de la división</label>
                                <input type="text" name="division_enunciado" id="division_enunciado" class="form-control" required placeholder="Ej. DIV. DE ING. SIST. COMP.">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="plan_de_estudios">Plan de estudios</label>
                                <input type="text" name="plan_de_estudios" id="plan_de_estudios" class="form-control" required placeholder="Ej. ISIC-2010-224">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3">
            <a href="#" class="btn btn-outline-primary" id="constancia-vista-previa" style="visibility: hidden;">
                <i class="fa-regular fa-eye me-2"></i>Vista previa
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar datos de la carrera
            </button>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function ocultarDatosEspecificosConstancia() {
            var existen_datos = $('#variable-ocultar').attr('value');
            if (existen_datos == 1) {
                $('.ocultar-formulario').fadeIn();
                $('#mensaje-agregar-datos').fadeOut();
                $('#imagen_encabezado').removeAttr('required');
                $('#imagen_pie').removeAttr('required');
            } else {
                $('.ocultar-formulario').fadeOut();
                $('#mensaje-agregar-datos').fadeIn();
                $('#imagen_encabezado').attr('required', 'required');
                $('#imagen_pie').attr('required', 'required');
            }
        }

        function abreviaturasEspeciales(abreviatura, option_id) {
            var token = abreviatura.substring(0, 5);
            if (token == 'otro-') {
                var opcion = document.getElementById(option_id);
                var resto_token = abreviatura.substring(5);
                opcion.value = abreviatura;
                opcion.innerHTML = 'Otro->' + resto_token;
            }
        }

        function actualizarDatosEspecificos(response, accion = 'llenar') {
            if (accion == 'llenar') {
                abreviaturasEspeciales(response['profesion_jefe_division'], 'otro-jefe-division');
                $('#jefe_division').val(response['jefe_division']);
                $('#profesion_jefe_division').val(response['profesion_jefe_division']);
                $('#division_enunciado').val(response['division_enunciado']);
                $('#plan_de_estudios').val(response['plan_de_estudios']);
            } else {
                $('#jefe_division').val('');
                $('#profesion_jefe_division').val('');
                $('#division_enunciado').val('');
                $('#plan_de_estudios').val('');
            }
        }

        function comboCarrera() {
            $(document).on('change', '#carrera', function (event) {
                event.preventDefault();
                var carrera_nombre = $('#carrera').val();
                $('#carrera').removeAttr('disabled');
                if (carrera_nombre.length > 0) {
                    var ruta = "{{ route('constancias.obtener_datos_especificos', 'aux') }}";
                    var ruta_visualizar = "{{ route('constancias.visualizar', ['carrera' => 'aux']) }}";
                    ruta = ruta.replace('aux', carrera_nombre);
                    ruta_visualizar = ruta_visualizar.replace('aux', carrera_nombre);
                    $.ajax({
                        type: 'get',
                        dataType: 'json',
                        cache: true,
                        url: ruta,
                        success: function (response) {
                            if (response.length > 0) {
                                actualizarDatosEspecificos(response[0]);
                                $('#constancia-vista-previa').attr('href', ruta_visualizar);
                                $('#constancia-vista-previa').fadeIn();
                                $('#constancia-vista-previa').css('visibility', 'visible');
                            } else {
                                actualizarDatosEspecificos(response, 'vaciar');
                                $('#constancia-vista-previa').attr('href', '#');
                                $('#constancia-vista-previa').fadeOut();
                            }
                            $('#form-datos-especificos input').removeAttr('disabled');
                            $('#form-datos-especificos select').removeAttr('disabled');

                            var temp_cookie = document.getElementById('carrera').value;
                            Cookies.set('constancias_carrera_val', temp_cookie, { expires: 1 });
                        },
                        error: function () {
                            console.log('Error al obtener datos especificos');
                        }
                    });
                } else {
                    $('#constancia-vista-previa').attr('href', '#');
                    $('#constancia-vista-previa').fadeOut();
                    $('#constancia-vista-previa').css('visibility', 'hidden');
                    $('#form-datos-especificos input').attr('disabled', 'disabled');
                    $('#form-datos-especificos select').attr('disabled', 'disabled');
                    $('#jefe_division').val('');
                    $('#profesion_jefe_division').val('');
                    $('#carrera').removeAttr('disabled');
                }
            });
        }

        function guardarDatosEspecificos() {
            $(document).on('submit', '#form-datos-especificos', function (event) {
                event.preventDefault();
                var constancia_data = $('#form-datos-especificos').serialize();
                var ruta = "{{ route('constancias.guardar_datos_especificos', 'aux') }}";
                var carrera_nombre = $('#carrera').val();
                ruta = ruta.replace('aux', carrera_nombre);
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    data: constancia_data,
                    url: ruta,
                    success: function (response) {
                        swal({
                            title: 'Correcto!',
                            text: 'Los datos se guardaron correctamente',
                            icon: 'success',
                            button: 'Cerrar!'
                        });
                        mostrarConstanciasFaltantes();
                        $('#carrera').trigger('change');
                    },
                    error: function () {
                        swal({
                            title: 'Error',
                            text: 'Error al guardar datos especificos de la constancia',
                            icon: 'error',
                            button: 'Cerrar!'
                        });
                    }
                });
            });
        }

        function mostrarConstanciasFaltantes() {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: "{{ route('constancias.constancias_faltantes') }}",
                success: function (response) {
                    var existen_datos = $('#variable-ocultar').attr('value');
                    if (response.length > 0) {
                        if (existen_datos == 1) $('#constancias-faltantes').fadeIn();
                        $('#constancias-faltantes div ul').empty();
                        for (var i = 0; i < response.length; i++) {
                            $('#constancias-faltantes div ul').append("<li style = 'text-align: left;'>" + response[i] + '</li>');
                        }
                    } else {
                        $('#constancias-faltantes div ul').empty();
                        $('#constancias-faltantes').fadeOut();
                    }
                },
                error: function () {
                    swal({
                        title: 'Error',
                        text: 'Error al obtener las constancias faltantes',
                        icon: 'error',
                        button: 'Cerrar!'
                    });
                }
            });
        }

        function otros() {
            $(document).on('change', '#profesion_jefe_depto', function (event) {
                var identificador = $(this).val();
                var identificador_token = identificador.substring(0, 5);
                if (identificador_token == 'otro-') {
                    var abreviatura = prompt('Favor de especificar abreviatura (max: 10 caracteres)');
                    if (abreviatura != null) {
                        $('#otro-jefe-depto').val('otro-' + abreviatura);
                        var opcion = document.getElementById('otro-jefe-depto');
                        opcion.innerHTML = 'Otro->' + abreviatura;
                    } else if (identificador == identificador_token) {
                        $(this).val('');
                    }
                }
            });
            $(document).on('change', '#profesion_jefe_division', function (event) {
                var identificador = $(this).val();
                var identificador_token = identificador.substring(0, 5);
                if (identificador_token == 'otro-') {
                    var abreviatura = prompt('Favor de especificar abreviatura (max: 10 caracteres)');
                    if (abreviatura != null) {
                        $('#otro-jefe-division').val('otro-' + abreviatura);
                        var opcion = document.getElementById('otro-jefe-division');
                        opcion.innerHTML = 'Otro->' + abreviatura;
                    } else if (identificador == identificador_token) {
                        $(this).val('');
                    }
                }
            });
            $(document).on('change', '#profesion_certificador', function (event) {
                var identificador = $(this).val();
                var identificador_token = identificador.substring(0, 5);
                if (identificador_token == 'otro-') {
                    var abreviatura = prompt('Favor de especificar abreviatura (max: 10 caracteres)');
                    if (abreviatura != null) {
                        $('#otro-certificador').val('otro-' + abreviatura);
                        var opcion = document.getElementById('otro-certificador');
                        opcion.innerHTML = 'Otro->' + abreviatura;
                    } else if (identificador == identificador_token) {
                        $(this).val('');
                    }
                }
            });
        }

        function getCookie() {
            var constancias_cookie = Cookies.get('constancias_carrera_val');
            if (constancias_cookie != null) {
                $('#carrera').val(constancias_cookie);
                $('#carrera').trigger('change');
            }
        }

        $(document).ready(function () {
            ocultarDatosEspecificosConstancia();
            comboCarrera();
            guardarDatosEspecificos();
            mostrarConstanciasFaltantes();
            otros();
            $('#form-datos-especificos input').attr('disabled', 'disabled');
            $('#form-datos-especificos select').attr('disabled', 'disabled');
            $('#carrera').removeAttr('disabled');
            getCookie();
        });
    </script>
@endsection
