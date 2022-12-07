@extends('template.molde')

@section('title','Evidencias')

@section('links')
  <link href="{{ asset('css/viewer.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/creditos/app.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('ruta')
	<a href="{{ route('alumnos.actividades') }}">Actividades</a>
	/
	<label class="label label-success">Evidencias</label>
@endsection

@section('contenido')
  <div class="row">
    <div class="col-sm-6" >
        <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text bg-info">Actividad</span>
        </div>
        <input type="text" class="form-control bg-transparent" value="{{ $actividad->nombre }}" readonly>
        <input type="hidden" id="actividad_id" value="{{ $actividad->id }}">
      </div>
    </div>
    <div class="col-sm-6">
      <!-- Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text bg-info">Encargado</span>
        </div>
        <input type="text" class="form-control bg-transparent" value="{{ $responsable->name }}" readonly>
        <input type="hidden" id="responsable_id" value="{{ $responsable->id }}">
      </div>
    </div>
  </div>
  <div class="resetear"></div>
  <div id="mensaje-parte-superior" class="alerta-padding"></div>
  <hr>

  <!-- Images galeria -->
  <div id="gallery-container" class="row" style="height:fit-content;"></div>
  <div style="display:none;" id="images-container">
    <ul id="images-list"></ul>
  </div>

  <!-- PDF Modal -->
  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pdfModalLabel">Lector PDF</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div>
            <button id="prev" class="btn btn-outline-primary">Anterior</button>
            <button id="next" class="btn btn-outline-primary">Siguiente</button>
            &nbsp; &nbsp;
            <span>Página: <span id="page_num"></span> / <span id="page_count"></span></span>
          </div>
          <canvas id="pdf-canvas"></canvas>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal para eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <input type="hidden" name="actividad_id" id="actividad_id">
  <input type="hidden" name="archivo_eliminar" id="archivo_eliminar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar evidencia</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-eliminar-body">
        ¿Estas seguro de eliminar esta evidencia?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="eliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>

  @section('js')
    <script src="{{ asset('js/pdf_viewer/pdf.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/pdf_viewer/pdf.worker.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/pdf_viewer.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/viewer.min.js') }}"></script>

    <script type="text/javascript">
      var imagenes_lista = document.getElementById('images-list');
      var imagenes_contador = 0;
      const galeria_viewer = new Viewer(imagenes_lista);

      function crearElementoParaGaleria(archivo_nombre,
                                        fecha,
                                        imagen_url,
                                        archivo_url,
                                        isPDF,
                                        actividad,
                                        evidencia_id,
                                        puede_eliminar)
      {
        let card = createElement('div', ['card']);
        let card_wrapper = createElement('div', ['col-md-3', 'col-sm-4', 'col-xxl-2', 'mt-2']);
        let img = createIMGElement(imagen_url, ['card-img-top', 'galeria-elemento', (isPDF ? 'is-PDF' : 'is-image')], archivo_nombre);
        img.addEventListener('click', displayDocument);

        if (isPDF) {
          img.dataset.pdf = archivo_url;
        } else {
          img.dataset.index = imagenes_contador++;
        }

        let card_body = createElement('div', ['card-body', 'p-1']);
        let detalles_lista = createElement('ul', ['list-group', 'list-group-flush']);
        let actividad_elem = crearDetalleSublista('Archivo: ', nameWithoutExtension(archivo_nombre));
        let fecha_elem = crearDetalleSublista('Fecha: ', fecha);
        appendChildren(detalles_lista, actividad_elem, fecha_elem);

        if (puede_eliminar) {
          let delete_button = crearLinkEliminar(actividad, evidencia_id, archivo_nombre);
          card.appendChild(delete_button);
        }

        card.appendChild(img);
        card_body.appendChild(detalles_lista);
        card.appendChild(card_body);
        card_wrapper.appendChild(card);
        return card_wrapper;
      }

      function displayDocument(event) {
        let target = event.target;
        if (target.classList.contains('is-image')) {
          galeria_viewer.view(target.dataset.index);
        } else {
          displayPdf(target.dataset.pdf);
        }
      }

      function crearLinkEliminar(actividad, evidencia_id, archivo) {
        let styles = { 'position': 'absolute', 'right': '0px' }
        let delete_icon = createIMGElement(asset('images/delete.png'), ['mds-icon', 'mds-animation-scale']);
        addStylesToElement(delete_icon, styles);
        delete_icon.dataset.actividad = actividad;
        delete_icon.dataset.evidencia_id = evidencia_id;
        delete_icon.dataset.archivo = archivo;
        delete_icon.setAttribute('title', 'Eliminar');
        delete_icon.addEventListener('click', initProcesoEliminar);
        return delete_icon;
      }

      function agregarImagenesAViewer() {
        imagenes_lista.innerHTML = '';
        imagenes_contador = 0;
        let imagenes = document.getElementsByClassName('is-image');
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

      function crearDetalleSublista(prefijo, contenido) {
        let detalle  = createElement('li', 'list-group-item');
        let texto = document.createTextNode(contenido);
        let prefijo_negritas = createElement('strong', null, prefijo);
        detalle.appendChild(prefijo_negritas);
        detalle.appendChild(texto);
        return detalle;
      }

      function cargarEvidencias(){
          vaciarGaleria();
          var actividad_id = $('#actividad_id').val();
          var responsable_id = $('#responsable_id').val();
          $.ajax({
            type:'GET',
            dataType: 'json',
            url:"{{ route('alumnos.peticion_evidencia') }}",
            data:{
              actividad_id: actividad_id,
              responsable_id: responsable_id
            },
            success: function(response){
              agregaEvidencias(response);
              agregarImagenesAViewer();
            },
            error:function(response){
              printError(response);
            }
          });
      }

      function agregaEvidencias(response){
        for(var x=0; x<response.length; x++){
          var archivo = response[x]['nom_imagen'].toString();
          var nombre_original = isNull(response[x]['nom_original']) ? archivo : response[x]['nom_original'];
          let puede_eliminar = puedeEliminarEvidencia(response[x]);
          let actividad_id = response[x]['actividad_id'];
          let actividad_nombre = response[x]['actividad_nombre'];
          let evidencia_id = response[x]['evidencia_id'];
          let fecha = response[x]['fecha_creacion'];
          let pdf_icono = asset('images/pdf_icono2.png');
          let isPDF = getExtension(archivo) === 'pdf';
          let imagen_url = (isPDF ? pdf_icono : asset('storage/evidencias', actividad_nombre, archivo));
          let archivo_url = asset('storage/evidencias', actividad_nombre, archivo);
          let elem = crearElementoParaGaleria(nombre_original, fecha, imagen_url, archivo_url, isPDF, actividad_id, evidencia_id, puede_eliminar);
          $('#gallery-container').append(elem);
        }
      }

      function puedeEliminarEvidencia(response) {
          if (response['vigente'] == 'false') {
            return false;
          } else if (response['validado'] == 'true') {
            if (response['participante_evidencia_validada'] == 'no' && response['momento_agregado'] == 'posteriormente') {
              return true
            } else {
              return false;
            }
          }
        return true;
      }

      function vaciarGaleria() {
        let galeriaNode = document.getElementById("gallery-container");
        while (galeriaNode.firstChild) {
            galeriaNode.removeChild(galeriaNode.firstChild);
        }
      }

      function initProcesoEliminar(event) {
        let dataset = event.target.dataset;
        $('#actividad_id').val(dataset.actividad);
        $('#archivo_eliminar').val(dataset.evidencia_id);
        $('#modal-eliminar-body').html('¿Estas seguro de eliminar la evidencia "' + dataset.archivo + '"?');
        $('#modalEliminar').modal('show');
      }

      function eliminarEvidencia(){
          var actividad = $('#actividad_id').val();
          var archivo_id = $('#archivo_eliminar').val();
          $.ajax({
            type: "get",
            dataType: "json",
            url: "{{ route('alumnos.eliminar_evidencia') }}",
            data:{
              actividad: actividad,
              archivo: archivo_id,
            },
            success: function(response){
              swal('Exito', 'Evidencia eliminada', 'success');
              cargarEvidencias();
              $('#modalEliminar').modal('hide');
            }, error: function(response){
              printError(response);
              $('#modalEliminar').modal('hide');
            }
          });
      }

      function addEventListeners() {
        $('#eliminar').on('click', eliminarEvidencia);
      }

      $(document).ready(function(event){
        addEventListeners();
        cargarEvidencias();
      });
    </script>
  @endsection
@endsection
