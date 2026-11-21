@extends('template.molde')

@section('title','Profesores')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-chalkboard-user" style="color:#2d6da3"></i>
        Profesores
    </span>
@endsection

@push('styles')
<style>
    .profe-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .profe-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .profe-card-head h2{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .profe-card-body{padding:1.25rem}
    .profe-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
    .profe-title{margin:0;color:#102b4a;font-size:1.15rem;font-weight:700}
    .profe-sub{margin:.15rem 0 0;color:#6b7280;font-size:.86rem}
    .profe-units{display:flex;flex-wrap:wrap;gap:.45rem}
    .profe-units .btn{border-radius:.6rem;padding:.4rem .8rem;font-size:.84rem}
    .profe-units .btn.active{background:#2d6da3;border-color:#2d6da3;color:#fff}
    .profe-filtro{color:#6b7280;font-size:.84rem;line-height:1.6}
    .profe-filtro strong{color:#102b4a;font-weight:600}
    .profe-table thead th{background:#f8fafc;color:#102b4a;font-size:.78rem;text-transform:uppercase;letter-spacing:.02em;border-bottom:1px solid #edf1f5;white-space:nowrap}
    .profe-table tbody td{vertical-align:middle}
    .profe-table .form-select,.profe-table .form-control{font-size:.84rem}
    .profe-nota{display:inline-flex;align-items:center;justify-content:center;min-width:48px;padding:.25rem .5rem;border-radius:.5rem;font-weight:700;font-size:.84rem}
    .profe-nota--bien{background:#e7f5ec;color:#1b7a43}
    .profe-nota--mal{background:#fdeceb;color:#b3261e}
    .profe-empty{padding:2.75rem 1rem;text-align:center;color:#64748b;font-size:.9rem}
    .profe-empty i{display:block;margin-bottom:.5rem;font-size:1.7rem;color:#c3d0de}
    .profe-alumno strong{display:block;color:#102b4a;font-size:.9rem}
    .profe-alumno small{color:#6b7280}
    @media(max-width:767.98px){
        .profe-card-body{padding:1rem}
    }
</style>
@endpush

@section('contenido')
    <input type="hidden" name="gse_clave" id="gse_clave" readonly>
    <input type="hidden" name="grupo" id="grupo" readonly>

    {{-- Filtros --}}
    <article class="profe-card mb-3">
        <div class="profe-card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="profe-icon"><i class="fa-solid fa-filter"></i></span>
                <div>
                    <h1 class="profe-title">Consultar calificaciones</h1>
                    <p class="profe-sub">Elegí un profesor, su materia y una unidad para revisar y capturar los comentarios de reprobación.</p>
                </div>
            </div>

            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    @include('template.partes.buscador_combobox', [
                        'config' => [
                            'id' => 'profesor',
                            'bare' => true,
                            'show_submit' => false,
                            'required' => false,
                            'field' => 'profesor',
                            'label' => 'Profesor',
                            'placeholder' => 'Escribe nombre o apellidos',
                            'endpoint' => route('profesores.busqueda'),
                            'query_param' => 'nombre',
                            'min_chars' => 2,
                            'limit' => 8,
                            'keys' => ['value' => 'cat_Clave', 'label' => 'nombre_completo', 'meta' => 'departamento'],
                        ],
                    ])
                </div>
                <div class="col-12 col-md-5" id="divMaterias">
                    <label class="form-label" for="materia" id="labMaterias">Materia</label>
                    <select name="materia" id="materia" class="form-select" required>
                        <option value="">Selecciona un profesor</option>
                    </select>
                </div>
                <div class="col-12 col-md-2" id="divFiltrar">
                    <button type="button" class="btn btn-primary w-100" id="findUnits" title="Ver unidades">
                        <i class="fa-solid fa-list-check me-2"></i>Unidades
                    </button>
                </div>
            </div>
        </div>
    </article>

    {{-- Unidades y resumen del filtro --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <article class="profe-card h-100">
                <div class="profe-card-head">
                    <h2><i class="fa-solid fa-layer-group me-2"></i>Unidades de la materia</h2>
                    <span class="text-muted small" id="unidadesHint">Seleccioná una materia y presioná «Unidades»</span>
                </div>
                <div class="profe-card-body">
                    <div class="profe-units" id="unidades"></div>
                    <div class="profe-empty" id="unidadesVacio">
                        <i class="fa-regular fa-rectangle-list"></i>
                        Todavía no hay unidades para mostrar.
                    </div>
                </div>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <article class="profe-card h-100">
                <div class="profe-card-head">
                    <h2><i class="fa-solid fa-circle-info me-2"></i>Filtro actual</h2>
                </div>
                <div class="profe-card-body">
                    <p class="profe-filtro mb-0" id="datosFiltro">Seleccioná un profesor para comenzar.</p>
                    <span id="unidad" class="d-none"></span>
                </div>
            </article>
        </div>
    </div>

    {{-- Calificaciones --}}
    <article class="profe-card">
        <div class="profe-card-head">
            <h2><i class="fa-solid fa-clipboard-list me-2"></i>Calificaciones de la unidad</h2>
            <span class="text-muted small">Solo los reprobados permiten capturar motivo y comentario</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0 profe-table" id="listaCali">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Control</th>
                        <th>Nombre</th>
                        <th class="text-center">Calificación</th>
                        <th style="min-width:180px">Motivo de reprobación</th>
                        <th style="min-width:220px">Comentario</th>
                        <th class="text-end">Confirmar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="filaVacia">
                        <td colspan="7">
                            <div class="profe-empty">
                                <i class="fa-regular fa-hand-pointer"></i>
                                Elegí una unidad para cargar las calificaciones del grupo.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>
@endsection

@section('js')
    <script type="text/javascript">
        var motivosTexto = {
            1: 'Responsabilidad del alumno',
            2: 'Inasistencia',
            3: 'Complejidad de la materia',
            4: 'Otro'
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#divMaterias').hide();
            $('#divFiltrar').hide();

            // El buscador combobox dispara change sobre el input oculto
            $('#profesor_value').on('change', function () {
                txtFiltro();
                var profesor = $(this).val();

                if (!profesor) {
                    $('#materia').empty().prepend(`<option value="">Selecciona un profesor</option>`);
                    $('#divMaterias').hide();
                    $('#divFiltrar').hide();
                    limpiarUnidades();
                    return;
                }

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: "{{ route('materias.find') }}",
                    data: { profesor: profesor },
                    success: function (materias) {
                        if (materias.error == 500) {
                            $('#materia').empty().prepend(`<option value="">No tiene materias asignadas</option>`);
                            swal('Sin materias', materias.message, 'info');
                            return;
                        }

                        $('#materia').empty();
                        $.each(materias, function (i, item) {
                            var valor = JSON.stringify(item);
                            $('#materia').prepend(`<option value='${valor}'>${item.ret_NomCompleto} · ${item.gse_Observaciones}</option>`);
                        });
                        $('#materia').prepend(`<option value="" selected>Selecciona una materia</option>`);
                        limpiarUnidades();
                    },
                    error: function (e) {
                        console.log('Error al buscar las materias de este profesor', e);
                    }
                });

                $('#divMaterias').show();
            });

            $('#materia').on('change', function () {
                txtFiltro();
                $('#divFiltrar').show();
                limpiarUnidades();
            });
        });

        function limpiarUnidades() {
            $('#unidades').empty();
            $('#unidadesVacio').show();
            $('#unidadesHint').text('Seleccioná una materia y presioná «Unidades»');
            $('#unidad').text('');
            txtFiltro();
        }

        $('#findUnits').on('click', function (e) {
            e.preventDefault();

            var strMateria = $('#materia').val();
            if (!strMateria) {
                swal('Falta la materia', 'Seleccioná una materia antes de consultar las unidades.', 'info');
                return;
            }

            var jsnMateria = JSON.parse(strMateria);
            $('#grupo').val(jsnMateria.gse_Clave);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "{{ route('units.find') }}",
                data: { materia: jsnMateria.ret_Clave },
                success: function (unidades) {
                    var botones = '';
                    var total = parseInt(unidades.ret_NumUnidades, 10) || 0;

                    for (var i = 1; i <= total; i++) {
                        botones += `<button type="button" class="btn btn-outline-primary" onclick="getCalificaciones(${i}, this)"><i class="fa-solid fa-layer-group me-1"></i>Unidad ${i}</button>`;
                    }

                    $('#unidades').html(botones);
                    $('#unidadesVacio').toggle(total === 0);
                    $('#unidadesHint').text(total === 0
                        ? 'La materia no tiene unidades configuradas'
                        : `${total} ${total === 1 ? 'unidad' : 'unidades'} · elegí una para cargar las calificaciones`);
                },
                error: function (e) {
                    console.log('Error al buscar las unidades de esta materia', e);
                }
            });
        });

        function getCalificaciones(unidad, boton) {
            $('#unidad').text(unidad);
            txtFiltro();

            var strMateria = $('#materia').val();
            var jsnMateria = JSON.parse(strMateria);

            $('#unidades .btn').removeClass('active');
            if (boton) {
                $(boton).addClass('active');
            }

            $('#listaCali > tbody').html(`<tr><td colspan="7"><div class="profe-empty"><span class="spinner-border spinner-border-sm me-2"></span>Cargando calificaciones…</div></td></tr>`);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "{{ route('listaCali.find') }}",
                data: {
                    materia: jsnMateria.ret_Clave,
                    unidad: unidad,
                    grupo: $('#grupo').val()
                },
                success: function (datos) {
                    var filas = datos['listaCali'] || [];
                    var comentarios = datos['coment'] || [];

                    $('#listaCali > tbody').empty();

                    if (filas.length === 0) {
                        $('#listaCali > tbody').append(`<tr><td colspan="7"><div class="profe-empty"><i class="fa-regular fa-folder-open"></i>Esta unidad no tiene calificaciones capturadas.</div></td></tr>`);
                        return;
                    }

                    $('#gse_clave').val(filas[0].gse_Clave);

                    $.each(filas, function (i, item) {
                        var calificacion = parseFloat(item.lsc_Calificacion);
                        var reprobado = calificacion < 70;
                        var nombre = [item.alu_Nombre, item.alu_ApePaterno, item.alu_ApeMaterno].filter(Boolean).join(' ');
                        var ocultos = `<input type="hidden" name="alu${i}" id="alu${i}" value="${item.alu_NumControl}">` +
                            `<input type="hidden" name="lse_clave${i}" id="lse_clave${i}" value="${item.lse_Clave}">`;

                        if (!reprobado) {
                            $('#listaCali > tbody').append(
                                `<tr><td class="text-muted">${i + 1}</td><td><span class="font-monospace">${item.alu_NumControl}</span></td>` +
                                `<td class="profe-alumno"><strong>${nombre}</strong></td>` +
                                `<td class="text-center"><span class="profe-nota profe-nota--bien">${item.lsc_Calificacion}</span></td>` +
                                `<td class="text-muted">—</td><td class="text-muted">—</td><td></td></tr>`
                            );
                            return;
                        }

                        var registro = comentarios.find(function (c) { return c.no_control == item.alu_NumControl; });
                        var opciones = '<option value="">Selecciona una opción</option>';
                        Object.keys(motivosTexto).forEach(function (valor) {
                            opciones += `<option value="${valor}">${motivosTexto[valor]}</option>`;
                        });

                        $('#listaCali > tbody').append(
                            `<tr><td class="text-muted">${i + 1}</td><td><span class="font-monospace">${item.alu_NumControl}</span>${ocultos}</td>` +
                            `<td class="profe-alumno"><strong>${nombre}</strong></td>` +
                            `<td class="text-center"><span class="profe-nota profe-nota--mal">${item.lsc_Calificacion}</span></td>` +
                            `<td><select class="form-select form-select-sm" name="motivos${i}" id="motivos${i}" required>${opciones}</select></td>` +
                            `<td><textarea required placeholder="Comentario para el alumno" name="comentarios${i}" id="comentarios${i}" rows="1" class="form-control form-control-sm">${registro ? registro.comentario : ''}</textarea></td>` +
                            `<td class="text-end"><button type="button" class="btn btn-sm btn-primary" onclick="guardarComentarios(${i})"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button></td></tr>`
                        );

                        if (registro) {
                            $(`#motivos${i}`).val(registro.motivos);
                        }
                    });
                },
                error: function (e) {
                    console.log('Error al buscar la lista de calificaciones de este grupo y unidad', e);
                    $('#listaCali > tbody').html(`<tr><td colspan="7"><div class="profe-empty"><i class="fa-solid fa-triangle-exclamation"></i>No se pudieron cargar las calificaciones.</div></td></tr>`);
                }
            });
        }

        function guardarComentarios(r) {
            var strMateria = $('#materia').val();
            var jsnMateria = JSON.parse(strMateria);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "{{ route('comentarios.save') }}",
                data: {
                    motivos: $('#motivos' + r).val(),
                    comentario: $('#comentarios' + r).val(),
                    alumno: $('#alu' + r).val(),
                    materia: jsnMateria.ret_Clave,
                    unidad: $('#unidad').text(),
                    lse_clave: $('#lse_clave' + r).val(),
                    gse_clave: jsnMateria.ret_Clave
                },
                success: function () {
                    swal('Éxito', 'Los comentarios se guardaron correctamente', 'success');
                },
                error: function (e) {
                    console.log('Error al guardar los comentarios', e);
                    swal('Error', 'Ocurrió un error al guardar. Consultá con el administrador del sistema.', 'error');
                }
            });
        }

        function txtFiltro() {
            var profesor = $.trim($('#profesor_chip_label').text()) || $.trim($('#profesor_input').val());
            var materia = $('#materia option:selected').text();
            var unidad = $('#unidad').text();

            if (!$('#profesor_value').val()) {
                $('#datosFiltro').text('Seleccioná un profesor para comenzar.');
                return;
            }

            var html = '<div><strong>Profesor:</strong> ' + profesor + '</div>';
            if ($('#materia').val()) {
                html += '<div><strong>Materia:</strong> ' + materia + '</div>';
            }
            if (unidad) {
                html += '<div><strong>Unidad:</strong> ' + unidad + '</div>';
            }
            $('#datosFiltro').html(html);
        }
    </script>
@endsection
