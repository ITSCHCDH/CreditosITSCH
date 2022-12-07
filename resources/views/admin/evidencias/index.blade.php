@extends('template.molde')

@section('title','Evidencias')

@section('ruta')
  @if ($ruta)
    <a href="{{ route('participantes.index') }}">Participantes</a>
    /
    <label class="label label-success"> Evidencias</label>
  @else
    <label class="label label-success"> Evidencias</label>
  @endif
@endsection

@section('links')
  <link href="{{ asset('css/viewer.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/creditos/app.css') }}" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
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
        <select name="actividades_id" id="actividades_id" class="form-control select-input placeholder-active active" required>
          <option value="" selected>Seleccione una actividad</option>
          @foreach ($actividades as $act)
            <option value="{{ $act->id }}">{{ $act->nombre }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <!-- Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
            al que estan asignados los participantes -->
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text bg-info">Responsable</span>
        </div>
        <select class="form-control" required method="GET" name="responsables_id" id="responsables_id">
          @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA'))
            <option value="nulo">Todos los responsables</option>
          @else
            <option value="{{ Auth::User()->id }}">{{ Auth::User()->name }}</option>
          @endif
        </select>
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
                                        responsable,
                                        alumno,
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
        let archivo_elem = crearDetalleSublista('Archivo: ', nameWithoutExtension(archivo_nombre));
        let responsable_elem = crearDetalleSublista('Responsable: ', responsable);
        let alumno_elem = crearDetalleSublista('Alumno: ', alumno);
        let fecha_elem = crearDetalleSublista('Fecha: ', fecha);
        appendChildren(detalles_lista, archivo_elem, responsable_elem, alumno_elem, fecha_elem);

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

      function comboResponsables(){
        $('#actividades_id').change(function(event){
          event.preventDefault();
          var actividad_id = $(this).val();
          Cookies.set('evidencia_actividad',actividad_id,{ expires:1});
          var todos = true;
          $.ajax({
            type:'GET',
            dataType: 'json',
            url:"{{ route('evidencias.peticion') }}",
            data:{
              id: actividad_id
            },
            success: function(response){
              $('#responsables_id').empty();
              var autenticacion = "{{ Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VIP_EVIDENCIA') }}"=="1"?true:false;
              if (autenticacion) {
                $('#responsables_id').append("<option value='nulo' selected>Todos los responsables</option>");
              }
              for(var x=0; x<response.length; x++){
                $('#responsables_id').append("<option value="+response[x]['id']+">"+response[x]['name']+"</option>");
              }
              var cookie_responsable = Cookies.get('evidencia_responsable');
              if($("#responsables_id option[value='"+cookie_responsable+"']").length!=0 && cookie_responsable!=null){
                todos= false;
                $('#responsables_id').val(cookie_responsable);
                $('#responsables_id').trigger('change');
              }
            },
            error:function(){
              console.log('Error!!!! :(');
            }
          });
          vaciarGaleria();
          if(actividad_id.length>0 && todos){
            var actividad_id = $('#actividades_id').val();
            var responsable_id = $('#responsables_id').val();
            $.ajax({
              type:'GET',
              dataType:'json',
              url:"{{ route('evidencias.galeria') }}",
              data:{
                responsable_id: responsable_id,
                actividad_id: actividad_id
              },
              success: function(response){
                agregaEvidencias(response);
                agregarImagenesAViewer();
              },
              error: function(){
                console.log('Error :(');
              }
            });
          }
        });
      }

      function agregaEvidencias(response){
        for(var x=0; x<response.length; x++){
          var archivo = response[x]['nom_imagen'].toString();
          var nombre_original = isNull(response[x]['nom_original']) ? archivo : response[x]['nom_original'];
          var admin = "{{ Auth::User()->can('VIP')}}" == "1" ? true : false;
          var admin_evidencia = "{{ Auth::User()->can('VIP_EVIDENCIA') }}" == "1" ? true : false;
          var permiso_eliminar = "{{ Auth::User()->can('ELIMINAR_EVIDENCIA') }}" == "1" ? true : false;
          var puede_eliminar = admin || admin_evidencia;
          puede_eliminar = (permiso_eliminar && response[x]['validado']=="false") || puede_eliminar;
          let actividad_id = response[x]['actividad_id'];
          let actividad_nombre = response[x]['actividad_nombre'];
          let evidencia_id = response[x]['evidencia_id'];
          let responsable = ucwords(response[x]['responsable_nombre']);
          let alumno_nombre = response[x]['alumno_nombre'] === null ? 'NA' : ucwords(response[x]['alumno_nombre']);
          let fecha = response[x]['fecha_creacion'];
          let pdf_icono = asset('images/pdf_icono2.png');
          let isPDF = getExtension(archivo) === 'pdf';
          let imagen_url = (isPDF ? pdf_icono : asset('storage/evidencias', actividad_nombre, archivo));
          let archivo_url = asset('storage/evidencias', actividad_nombre, archivo);
          let elem = crearElementoParaGaleria(nombre_original, responsable, alumno_nombre, fecha, imagen_url, archivo_url, isPDF, actividad_id, evidencia_id, puede_eliminar);
          $('#gallery-container').append(elem);
        }
      }

      function peticionGaleria(){
        $('#responsables_id').change(function(event){
          event.preventDefault();
          var actividad_id = $('#actividades_id').val();
          var responsable_id = $('#responsables_id').val();
          Cookies.set('evidencia_responsable',responsable_id,{ expires: 1});
          $.ajax({
            type:'GET',
            dataType:'json',
            url:'{{ route('evidencias.galeria') }}',
            data:{
              responsable_id: responsable_id,
              actividad_id: actividad_id
            },
            success: function(response){
              vaciarGaleria();
              agregaEvidencias(response);
              agregarImagenesAViewer();
            },error: function(){
              console.log('Error :(');
            }
          });
        });
      }

      function vaciarGaleria() {
        let galeriaNode = document.getElementById("gallery-container");
        while (galeriaNode.firstChild) {
            galeriaNode.removeChild(galeriaNode.firstChild);
        }
      }

      function cookiesEvidencia(){
        var actividad_id = Cookies.get('evidencia_actividad');
        if($("#actividades_id option[value='"+actividad_id+"']").length!=0 && actividad_id!=null){
          $('#actividades_id').val(actividad_id);
          $('#actividades_id').trigger('change');
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
            url: "{{ route('evidencias.eliminar') }}",
            data:{
              actividad: actividad,
              archivo: archivo_id,
            },
            success: function(response){
              swal('Exito', 'Evidencia eliminada', 'success');
              $('#responsables_id').trigger('change');
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
        comboResponsables();
        peticionGaleria();
        cookiesEvidencia();
      });
    </script>
  @endsection
@endsection
