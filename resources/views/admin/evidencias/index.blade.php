@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-images" style="color:#2d6da3"></i>
        @if ($ruta)
            <a href="{{ route('participantes.index') }}" class="text-decoration-none">Participantes</a>
            <span class="text-muted">/</span>
        @endif
        Evidencias
    </span>
@endsection

@section('links')
    <link href="{{ asset('css/viewer.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/creditos/app.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
    <style>
        .evi-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06);padding:1.25rem;margin-bottom:1rem;text-align:left}
        .evi-head{display:flex;align-items:flex-start;gap:.85rem;margin-bottom:1rem}
        .evi-head h2{margin:0;color:#102b4a;font-size:1.1rem;font-weight:700}
        .evi-head p{margin:.2rem 0 0;color:#6b7280;font-size:.85rem}
        .evi-icon{width:44px;height:44px;flex:0 0 auto;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
        .evi-filters .form-label{font-size:.82rem;font-weight:600;color:#334155;margin-bottom:.3rem}
        .evi-filters .form-select{min-height:46px;border-radius:.7rem}
        .evi-filters .cbx-combo{min-height:46px}
        .evi-filters .cbx-hint{display:none}
        .evi-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(8rem,1fr));gap:.75rem;margin-top:1rem}
        .evi-stat{display:flex;flex-direction:column;gap:.15rem;padding:.75rem .9rem;border:1px solid #e7edf4;border-radius:.85rem;background:#f8fafc}
        .evi-stat-value{font-size:1.3rem;font-weight:700;color:#102b4a;line-height:1.1}
        .evi-stat-label{font-size:.74rem;color:#64748b;text-transform:uppercase;letter-spacing:.03em}
        .evi-stat.is-pdf{background:#fdf2f2;border-color:#f3d8d8}
        .evi-stat.is-img{background:#f1f7fb;border-color:#d8e7f1}
        .evi-stat.is-ok{background:#f1f8f4;border-color:#d6ecdd}
        .evi-gallery{display:grid;grid-template-columns:repeat(auto-fill,minmax(15rem,1fr));gap:1rem}
        .evi-tile{display:flex;flex-direction:column;overflow:hidden;border:1px solid #e7edf4;border-radius:.9rem;background:#fff;box-shadow:0 .4rem .9rem rgba(29,78,116,.07);transition:box-shadow .15s ease,transform .15s ease}
        .evi-tile:hover{box-shadow:0 .7rem 1.4rem rgba(29,78,116,.14);transform:translateY(-2px)}
        .evi-thumb{position:relative;aspect-ratio:4/3;background:#eef3f8;overflow:hidden}
        .evi-thumb img{width:100%;height:100%;object-fit:cover;cursor:zoom-in;display:block}
        .evi-thumb img.is-PDF{object-fit:contain;padding:1.35rem;background:#fff;cursor:zoom-in}
        .evi-badge{position:absolute;display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:999px;font-size:.7rem;font-weight:700;letter-spacing:.02em;background:#fff;box-shadow:0 .2rem .5rem rgba(16,43,74,.18)}
        .evi-badge.is-type{top:.5rem;left:.5rem;color:#173c66}
        .evi-badge.is-type.is-pdf{color:#b3261e}
        .evi-badge.is-state{top:.5rem;right:.5rem}
        .evi-badge.is-ok{color:#1b7a3d}
        .evi-badge.is-pending{color:#9a6408}
        .evi-delete{position:absolute;right:.5rem;bottom:.5rem;width:34px;height:34px;display:none;place-items:center;border:0;border-radius:.6rem;background:rgba(179,38,30,.92);color:#fff;cursor:pointer}
        .evi-delete:hover,.evi-delete:focus-visible{background:#8f1d17}
        .evi-tile:hover .evi-delete,.evi-tile:focus-within .evi-delete,.evi-delete:focus-visible{display:grid}
        .evi-body{padding:.8rem .9rem;display:flex;flex-direction:column;gap:.3rem}
        .evi-title{margin:0;font-size:.9rem;font-weight:700;color:#102b4a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .evi-meta{display:flex;align-items:center;gap:.45rem;font-size:.78rem;color:#64748b;min-width:0}
        .evi-meta i{width:14px;color:#94a3b8;flex:0 0 auto}
        .evi-meta span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .evi-empty{display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:2.5rem 1.5rem}
        .evi-empty i{font-size:2rem;color:#94a3b8}
        .evi-empty h3{margin:0;font-size:1.05rem;color:#102b4a}
        .evi-empty p{margin:0;color:#64748b;font-size:.88rem;max-width:34rem}
        .evi-loading{display:flex;align-items:center;justify-content:center;gap:.6rem;padding:2rem;color:#64748b;font-size:.9rem}
        @media(hover:none){.evi-delete{display:grid}}
        @media(max-width:575.98px){.evi-gallery{grid-template-columns:repeat(auto-fill,minmax(13rem,1fr))}}
    </style>
@endsection

@section('contenido')
    <article class="evi-card">
        <div class="evi-head">
            <span class="evi-icon"><i class="fa-solid fa-filter" aria-hidden="true"></i></span>
            <div>
                <h2>Filtros</h2>
                <p>Elige la actividad y, si hace falta, un responsable para acotar la galería.</p>
            </div>
        </div>
        <div class="evi-filters">
            {{-- Los selects originales se conservan ocultos como fuente de verdad para la lógica existente --}}
            <div class="d-none">
                <select name="actividades_id" id="actividades_id">
                    <option value="">Seleccione una actividad</option>
                    @foreach ($actividades as $act)
                        <option value="{{ $act->id }}">{{ $act->nombre }}</option>
                    @endforeach
                </select>
                <select name="responsables_id" id="responsables_id">
                    @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA'))
                        <option value="nulo">Todos los responsables</option>
                    @else
                        <option value="{{ Auth::User()->id }}">{{ Auth::User()->name }}</option>
                    @endif
                </select>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-sm-6 col-xl-5">
                    @include('template.partes.buscador_combobox', [
                        'config' => [
                            'id' => 'actividad',
                            'bare' => true,
                            'required' => false,
                            'show_submit' => false,
                            'label' => 'Actividad',
                            'placeholder' => 'Buscar actividad…',
                            'field' => 'actividad_id',
                            'endpoint' => route('evidencias.actividades_busqueda'),
                            'query_param' => 'nombre',
                            'min_chars' => 1,
                            'show_value' => false,
                            'keys' => ['value' => 'id', 'label' => 'nombre', 'meta' => ''],
                        ],
                    ])
                </div>
                <div class="col-sm-6 col-xl-5">
                    @include('template.partes.buscador_combobox', [
                        'config' => [
                            'id' => 'responsable',
                            'bare' => true,
                            'required' => false,
                            'show_submit' => false,
                            'label' => 'Responsable',
                            'placeholder' => 'Todos los responsables',
                            'field' => 'responsable_id',
                            'endpoint' => route('evidencias.responsables_busqueda'),
                            'query_param' => 'nombre',
                            'params' => ['actividad_id' => ''],
                            'min_chars' => 1,
                            'show_value' => false,
                            'keys' => ['value' => 'id', 'label' => 'name', 'meta' => ''],
                        ],
                    ])
                </div>
                @if (Auth::User()->can('VIP') || Auth::User()->can('CREAR_EVIDENCIA'))
                    <div class="col-12 col-xl-2">
                        @php
                            $idActividadNueva = request()->query('id_actividad');
                            $idResponsableNuevo = request()->query('id_responsable');
                        @endphp
                        <a id="evi-nueva"
                           class="btn btn-primary rounded-pill w-100 @if(!$idActividadNueva || !$idResponsableNuevo) disabled @endif"
                           href="{{ route('evidencias.create', ['id_actividad' => $idActividadNueva, 'id_responsable' => $idResponsableNuevo]) }}"
                           aria-disabled="{{ (!$idActividadNueva || !$idResponsableNuevo) ? 'true' : 'false' }}">
                            <i class="fa-solid fa-cloud-arrow-up me-2" aria-hidden="true"></i>Subir evidencia
                        </a>
                    </div>
                @endif
            </div>
            <div class="evi-stats">
                <div class="evi-stat"><span class="evi-stat-value" id="evi-total">0</span><span class="evi-stat-label">Evidencias</span></div>
                <div class="evi-stat is-pdf"><span class="evi-stat-value" id="evi-pdf">0</span><span class="evi-stat-label">PDF</span></div>
                <div class="evi-stat is-img"><span class="evi-stat-value" id="evi-img">0</span><span class="evi-stat-label">Imágenes</span></div>
                <div class="evi-stat is-ok"><span class="evi-stat-value" id="evi-validada">0</span><span class="evi-stat-label">Validadas</span></div>
            </div>
        </div>
    </article>

    <article class="evi-card">
        <div class="evi-head">
            <span class="evi-icon"><i class="fa-solid fa-photo-film" aria-hidden="true"></i></span>
            <div>
                <h2>Galería</h2>
                <p id="evi-resumen">Selecciona una actividad para ver sus evidencias.</p>
            </div>
        </div>

        <div id="evi-loading" class="evi-loading" hidden>
            <i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
            <span>Cargando evidencias…</span>
        </div>

        <div id="evi-empty" class="evi-empty">
            <i class="fa-solid fa-images" aria-hidden="true"></i>
            <h3>Sin evidencias por mostrar</h3>
            <p>Elige una actividad en el filtro de arriba; si ya elegiste una, revisa el responsable seleccionado.</p>
        </div>

        <div id="gallery-container" class="evi-gallery"></div>

        <div style="display:none;" id="images-container">
            <ul id="images-list"></ul>
        </div>
    </article>

    <!-- Modal PDF -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Lector PDF</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
                        <button id="prev" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-chevron-left me-1" aria-hidden="true"></i>Anterior</button>
                        <button id="next" class="btn btn-outline-primary rounded-pill">Siguiente<i class="fa-solid fa-chevron-right ms-1" aria-hidden="true"></i></button>
                        <span class="ms-2 small">Página <span id="page_num"></span> de <span id="page_count"></span></span>
                    </div>
                    <canvas id="pdf-canvas" class="mt-3"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary rounded-pill" data-mdb-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel">Eliminar evidencia</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modal-eliminar-body">¿Estás seguro de eliminar esta evidencia?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-mdb-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger rounded-pill" id="eliminar"><i class="fa-solid fa-trash me-2" aria-hidden="true"></i>Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="actividad_id" id="actividad_id">
    <input type="hidden" name="archivo_eliminar" id="archivo_eliminar">
@endsection

@section('js')
    <script src="{{ asset('js/pdf_viewer/pdf.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/pdf_viewer/pdf.worker.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/pdf_viewer.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/viewer.min.js') }}"></script>

    <script type="text/javascript">
        var imagenes_lista = document.getElementById('images-list');
        var imagenes_contador = 0;
        const galeria_viewer = new Viewer(imagenes_lista);

        const plantilla = {
            total: document.getElementById('evi-total'),
            pdf: document.getElementById('evi-pdf'),
            img: document.getElementById('evi-img'),
            validada: document.getElementById('evi-validada'),
            resumen: document.getElementById('evi-resumen'),
            vacio: document.getElementById('evi-empty'),
            cargando: document.getElementById('evi-loading'),
            nueva: document.getElementById('evi-nueva')
        };

        function mostrarCargando(mostrar) {
            if (!plantilla.cargando) { return; }
            plantilla.cargando.hidden = !mostrar;
        }

        function mostrarVacio(mostrar, mensaje) {
            if (!plantilla.vacio) { return; }
            plantilla.vacio.hidden = !mostrar;
            if (mostrar && mensaje) {
                const parrafo = plantilla.vacio.querySelector('p');
                if (parrafo) { parrafo.textContent = mensaje; }
            }
        }

        function actualizarResumen(total, pdfs, imagenes) {
            if (plantilla.total) { plantilla.total.textContent = total; }
            if (plantilla.pdf) { plantilla.pdf.textContent = pdfs; }
            if (plantilla.img) { plantilla.img.textContent = imagenes; }
            const validadas = document.querySelectorAll('#gallery-container .evi-badge.is-state.is-ok').length;
            if (plantilla.validada) { plantilla.validada.textContent = validadas; }

            if (plantilla.resumen) {
                if (total === 0) {
                    plantilla.resumen.textContent = 'Selecciona una actividad para ver sus evidencias.';
                } else {
                    plantilla.resumen.textContent = total + (total === 1 ? ' evidencia encontrada' : ' evidencias encontradas');
                }
            }

            mostrarVacio(total === 0, total === 0 ? 'No hay evidencias para la selección actual. Prueba con otra actividad o con «Todos los responsables».' : null);
        }

        function crearMeta(icono, texto, titulo) {
            const meta = document.createElement('div');
            meta.className = 'evi-meta';
            const iconoElemento = document.createElement('i');
            iconoElemento.className = 'fa-solid ' + icono;
            iconoElemento.setAttribute('aria-hidden', 'true');
            const valor = document.createElement('span');
            valor.textContent = texto;
            valor.title = titulo || texto;
            meta.append(iconoElemento, valor);
            return meta;
        }

        // Muchos archivos llegan con nombres numéricos (1795059676.pdf); en ese caso
        // se usa una etiqueta legible y el nombre real queda en el tooltip.
        function esNombreDescriptivo(texto) {
            if (!/[a-záéíóúüñ]{3,}/i.test(texto)) { return false; }
            // Descarta nombres generados por la app (ids o marcas de tiempo largas)
            return !/\d{6,}/.test(texto);
        }

        function tituloEvidencia(nombreOriginal, posicion) {
            const limpio = nameWithoutExtension(nombreOriginal || '');
            if (esNombreDescriptivo(limpio)) {
                const legible = limpio.replace(/[_-]+/g, ' ').replace(/\s+/g, ' ').trim();
                return legible.charAt(0).toUpperCase() + legible.slice(1);
            }
            return 'Evidencia ' + posicion;
        }

        function crearElementoParaGaleria(archivo_nombre, responsable, alumno, fecha, imagen_url, archivo_url, isPDF, actividad, evidencia_id, puede_eliminar, validado, tituloTexto) {
            const tarjeta = document.createElement('article');
            tarjeta.className = 'evi-tile';

            const miniatura = document.createElement('div');
            miniatura.className = 'evi-thumb';

            const img = document.createElement('img');
            img.src = imagen_url;
            img.alt = archivo_nombre;
            img.className = 'galeria-elemento ' + (isPDF ? 'is-PDF' : 'is-image');
            img.addEventListener('click', displayDocument);
            if (isPDF) {
                img.dataset.pdf = archivo_url;
            } else {
                img.dataset.index = imagenes_contador++;
            }
            miniatura.appendChild(img);

            const tipo = document.createElement('span');
            tipo.className = 'evi-badge is-type' + (isPDF ? ' is-pdf' : '');
            tipo.innerHTML = '<i class="fa-solid ' + (isPDF ? 'fa-file-pdf' : 'fa-image') + '" aria-hidden="true"></i>' + (isPDF ? 'PDF' : 'Imagen');
            miniatura.appendChild(tipo);

            const estado = document.createElement('span');
            const esValido = String(validado) === 'true';
            estado.className = 'evi-badge is-state ' + (esValido ? 'is-ok' : 'is-pending');
            estado.innerHTML = '<i class="fa-solid ' + (esValido ? 'fa-circle-check' : 'fa-clock') + '" aria-hidden="true"></i>' + (esValido ? 'Validada' : 'Pendiente');
            miniatura.appendChild(estado);

            if (puede_eliminar) {
                const boton = document.createElement('button');
                boton.type = 'button';
                boton.className = 'evi-delete';
                boton.title = 'Eliminar evidencia';
                boton.setAttribute('aria-label', 'Eliminar evidencia ' + archivo_nombre);
                boton.innerHTML = '<i class="fa-solid fa-trash" aria-hidden="true"></i>';
                boton.dataset.actividad = actividad;
                boton.dataset.evidencia_id = evidencia_id;
                boton.dataset.archivo = archivo_nombre;
                boton.addEventListener('click', initProcesoEliminar);
                miniatura.appendChild(boton);
            }

            const cuerpo = document.createElement('div');
            cuerpo.className = 'evi-body';

            const titulo = document.createElement('h3');
            titulo.className = 'evi-title';
            titulo.textContent = tituloTexto;
            titulo.title = 'Archivo: ' + archivo_nombre;

            cuerpo.appendChild(titulo);
            cuerpo.appendChild(crearMeta('fa-user-tie', responsable));
            cuerpo.appendChild(crearMeta(alumno.icono, alumno.texto, alumno.titulo));
            cuerpo.appendChild(crearMeta('fa-calendar-days', fecha));

            tarjeta.append(miniatura, cuerpo);
            return tarjeta;
        }

        function displayDocument(event) {
            let target = event.target;
            if (target.classList.contains('is-image')) {
                galeria_viewer.view(target.dataset.index);
            } else {
                displayPdf(target.dataset.pdf);
            }
        }

        function agregarImagenesAViewer() {
            imagenes_lista.innerHTML = '';
            imagenes_contador = 0;
            const imagenes = document.getElementsByClassName('is-image');
            for (let i = 0; i < imagenes.length; ++i) {
                const imagen_clone = imagenes[i].cloneNode(true);
                imagen_clone.classList.remove('is-image');
                agregarImagenAViewer(imagen_clone);
            }
            galeria_viewer.update();
        }

        function agregarImagenAViewer(imagen_elem) {
            let li_elem = createElement('li');
            li_elem.appendChild(imagen_elem);
            imagenes_lista.appendChild(li_elem);
        }

        function vaciarGaleria() {
            let galeriaNode = document.getElementById('gallery-container');
            while (galeriaNode.firstChild) {
                galeriaNode.removeChild(galeriaNode.firstChild);
            }
            actualizarResumen(0, 0, 0);
        }

        function agregaEvidencias(response) {
            const galeria = document.getElementById('gallery-container');
            let pdfs = 0;
            let imagenes = 0;

            for (let x = 0; x < response.length; x++) {
                const archivo = response[x]['nom_imagen'].toString();
                const nombre_original = isNull(response[x]['nom_original']) ? archivo : response[x]['nom_original'];
                const admin = "{{ Auth::User()->can('VIP')}}" == "1";
                const admin_evidencia = "{{ Auth::User()->can('VIP_EVIDENCIA') }}" == "1";
                const permiso_eliminar = "{{ Auth::User()->can('ELIMINAR_EVIDENCIA') }}" == "1";
                let puede_eliminar = admin || admin_evidencia;
                puede_eliminar = (permiso_eliminar && response[x]['validado'] == 'false') || puede_eliminar;

                const actividad_id = response[x]['actividad_id'];
                const actividad_nombre = response[x]['actividad_nombre'];
                const evidencia_id = response[x]['evidencia_id'];
                const responsable = ucwords(response[x]['responsable_nombre']);
                const totalParticipantes = parseInt(response[x]['participantes_total'], 10) || 0;
                const alumnoIndividual = response[x]['alumno_nombre'] === null ? null : ucwords(response[x]['alumno_nombre']);
                const alumno = (function () {
                    if (alumnoIndividual) {
                        return { icono: 'fa-user-graduate', texto: 'Alumno: ' + alumnoIndividual, titulo: alumnoIndividual };
                    }
                    if (totalParticipantes > 0) {
                        const etiqueta = totalParticipantes === 1 ? 'Participante: 1' : 'Participantes: ' + totalParticipantes;
                        return {
                            icono: 'fa-users',
                            texto: etiqueta,
                            titulo: totalParticipantes + (totalParticipantes === 1 ? ' alumno participa en la actividad' : ' alumnos participan en la actividad')
                        };
                    }
                    return { icono: 'fa-user-slash', texto: 'Sin participantes en la actividad', titulo: '' };
                })();
                const fecha = response[x]['fecha_creacion'];
                const isPDF = getExtension(archivo) === 'pdf';
                const imagen_url = isPDF ? asset('images/pdf_icono2.png') : asset('storage/evidencias', actividad_nombre, archivo);
                const archivo_url = asset('storage/evidencias', actividad_nombre, archivo);

                if (isPDF) { pdfs++; } else { imagenes++; }

                galeria.appendChild(crearElementoParaGaleria(
                    nombre_original, responsable, alumno, fecha, imagen_url, archivo_url,
                    isPDF, actividad_id, evidencia_id, puede_eliminar, response[x]['validado'],
                    tituloEvidencia(nombre_original, x + 1)
                ));
            }

            actualizarResumen(response.length, pdfs, imagenes);
            agregarImagenesAViewer();
        }

        function actualizarBotonNueva() {
            if (!plantilla.nueva) { return; }
            const actividad = $('#actividades_id').val();
            const responsable = $('#responsables_id').val();

            if (actividad && responsable && responsable !== 'nulo') {
                const url = "{{ route('evidencias.create') }}" + '?id_actividad=' + encodeURIComponent(actividad) + '&id_responsable=' + encodeURIComponent(responsable);
                plantilla.nueva.href = url;
                plantilla.nueva.classList.remove('disabled');
                plantilla.nueva.setAttribute('aria-disabled', 'false');
                plantilla.nueva.removeAttribute('tabindex');
            } else {
                plantilla.nueva.href = "{{ route('evidencias.create') }}";
                plantilla.nueva.classList.add('disabled');
                plantilla.nueva.setAttribute('aria-disabled', 'true');
                plantilla.nueva.setAttribute('tabindex', '-1');
            }
        }

        function comboResponsables() {
            $('#actividades_id').change(function (event) {
                event.preventDefault();
                const actividad_id = $(this).val();
                Cookies.set('evidencia_actividad', actividad_id, { expires: 1 });
                let todos = true;

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: "{{ route('evidencias.peticion') }}",
                    data: { id: actividad_id },
                    success: function (response) {
                        $('#responsables_id').empty();
                        const autenticacion = "{{ Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA') }}" == "1";
                        if (autenticacion) {
                            $('#responsables_id').append("<option value='nulo' selected>Todos los responsables</option>");
                        }
                        for (let x = 0; x < response.length; x++) {
                            $('#responsables_id').append("<option value=" + response[x]['id'] + ">" + response[x]['name'] + "</option>");
                        }

                        const cookie_responsable = Cookies.get('evidencia_responsable');
                        if ($("#responsables_id option[value='" + cookie_responsable + "']").length != 0 && cookie_responsable != null) {
                            todos = false;
                            $('#responsables_id').val(cookie_responsable);
                            $('#responsables_id').trigger('change');
                        }
                        actualizarBotonNueva();
                    },
                    error: function () {
                        console.log('Error al cargar responsables');
                    }
                });

                vaciarGaleria();
                mostrarCargando(false);

                if (actividad_id && actividad_id.length > 0 && todos) {
                    mostrarCargando(true);
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: "{{ route('evidencias.galeria') }}",
                        data: {
                            responsable_id: $('#responsables_id').val(),
                            actividad_id: actividad_id
                        },
                        success: function (response) {
                            vaciarGaleria();
                            agregaEvidencias(response);
                        },
                        error: function () {
                            console.log('Error al cargar la galería');
                            mostrarVacio(true, 'No fue posible cargar las evidencias. Intenta de nuevo.');
                        },
                        complete: function () {
                            mostrarCargando(false);
                        }
                    });
                }
            });
        }

        function peticionGaleria() {
            $('#responsables_id').change(function (event) {
                event.preventDefault();
                const actividad_id = $('#actividades_id').val();
                const responsable_id = $(this).val();
                Cookies.set('evidencia_responsable', responsable_id, { expires: 1 });
                actualizarBotonNueva();

                if (!actividad_id) {
                    vaciarGaleria();
                    return;
                }

                mostrarCargando(true);
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: "{{ route('evidencias.galeria') }}",
                    data: {
                        responsable_id: responsable_id,
                        actividad_id: actividad_id
                    },
                    success: function (response) {
                        vaciarGaleria();
                        agregaEvidencias(response);
                    },
                    error: function () {
                        console.log('Error al cargar la galería');
                        mostrarVacio(true, 'No fue posible cargar las evidencias. Intenta de nuevo.');
                    },
                    complete: function () {
                        mostrarCargando(false);
                    }
                });
            });
        }

        function cookiesEvidencia() {
            const actividad_id = Cookies.get('evidencia_actividad');
            if ($("#actividades_id option[value='" + actividad_id + "']").length != 0 && actividad_id != null) {
                $('#actividades_id').val(actividad_id);
                $('#actividades_id').trigger('change');
            }
        }

        function initProcesoEliminar(event) {
            const dataset = event.currentTarget.dataset;
            $('#actividad_id').val(dataset.actividad);
            $('#archivo_eliminar').val(dataset.evidencia_id);
            $('#modal-eliminar-body').html('¿Estás seguro de eliminar la evidencia <strong>' + dataset.archivo + '</strong>?');
            $('#modalEliminar').modal('show');
        }

        function eliminarEvidencia() {
            const actividad = $('#actividad_id').val();
            const archivo_id = $('#archivo_eliminar').val();
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "{{ route('evidencias.eliminar') }}",
                data: {
                    actividad: actividad,
                    archivo: archivo_id
                },
                success: function () {
                    swal('Éxito', 'Evidencia eliminada', 'success');
                    $('#responsables_id').trigger('change');
                    $('#modalEliminar').modal('hide');
                },
                error: function (response) {
                    printError(response);
                    $('#modalEliminar').modal('hide');
                }
            });
        }

        function addEventListeners() {
            $('#eliminar').on('click', eliminarEvidencia);
        }

        $(document).ready(function () {
            addEventListeners();
            comboResponsables();
            peticionGaleria();
            cookiesEvidencia();
            actualizarBotonNueva();
        });
    </script>

    {{-- Puente entre los buscadores y los selects originales: la lógica de la vista no cambia. --}}
    <script type="text/javascript">
        (function () {
            const actividadSelect = document.getElementById('actividades_id');
            const responsableSelect = document.getElementById('responsables_id');
            const actividadCombo = document.getElementById('actividad_combo');
            const responsableCombo = document.getElementById('responsable_combo');
            const actividadValue = document.getElementById('actividad_value');
            const responsableValue = document.getElementById('responsable_value');

            if (!actividadSelect || !responsableSelect || !actividadCombo || !responsableCombo || !actividadValue || !responsableValue) {
                return;
            }

            function textoSeleccionado(select) {
                const opcion = select.options[select.selectedIndex];
                return opcion ? opcion.text : '';
            }

            function sincronizarActividad() {
                const valor = actividadSelect.value || '';
                responsableCombo.cbxSetParams({ actividad_id: valor });
                if (valor === '') {
                    actividadCombo.cbxReset();
                    return;
                }
                actividadCombo.cbxSetSelection({ value: valor, label: textoSeleccionado(actividadSelect) });
            }

            function sincronizarResponsable() {
                const valor = responsableSelect.value || '';
                if (valor === '' || valor === 'nulo') {
                    responsableCombo.cbxReset();
                    return;
                }
                responsableCombo.cbxSetSelection({ value: valor, label: textoSeleccionado(responsableSelect) });
            }

            actividadValue.addEventListener('change', function () {
                const valor = this.value || '';
                if (actividadSelect.value === valor) { return; }

                responsableCombo.cbxSetParams({ actividad_id: valor });
                responsableCombo.cbxReset();
                actividadSelect.value = valor;
                $(actividadSelect).trigger('change');
                if (typeof actualizarBotonNueva === 'function') { actualizarBotonNueva(); }
            });

            responsableValue.addEventListener('change', function () {
                const valor = this.value || 'nulo';
                if (responsableSelect.value === valor) { return; }

                responsableSelect.value = valor;
                $(responsableSelect).trigger('change');
            });

            new MutationObserver(sincronizarResponsable).observe(responsableSelect, { childList: true });

            $(document).ready(function () {
                sincronizarActividad();
                sincronizarResponsable();
            });
        })();
    </script>
@endsection
