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

  <!-- Modal -->
  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pdfModalLabel">Lector PDF</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div>
            <button id="prev">Anterior</button>
            <button id="next">Siguiente</button>
            &nbsp; &nbsp;
            <span>Página: <span id="page_num"></span> / <span id="page_count"></span></span>
          </div>
          <canvas id="pdf-canvas"></canvas>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
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

      function crearElementoParaGaleria(archivo_nombre, responsable, alumno, fecha, imagen_url, archivo_url, isPDF) {
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
        let responsable_elem = crearDetalleSublista('Responsable: ', responsable);
        let alumno_elem = crearDetalleSublista('Alumno: ', alumno);
        let fecha_elem = crearDetalleSublista('Fecha: ', fecha);
        appendChildren(detalles_lista, actividad_elem, responsable_elem, alumno_elem, fecha_elem);

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
          var eliminar_evidencia = "";
          var admin = "{{ Auth::User()->can('VIP')}}" == "1" ? true : false;
          var admin_evidencia = "{{ Auth::User()->can('VIP_EVIDENCIA') }}" == "1" ? true : false;
          var permiso_eliminar = "{{ Auth::User()->can('ELIMINAR_EVIDENCIA') }}" == "1" ? true : false;
          if(admin || admin_evidencia){
            eliminar_evidencia = "<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-validado = '"+response[x]['validado']+"'data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
              +"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
              +"</a>";
          }else if(permiso_eliminar && response[x]['validado']=="false"){
            if(response[x]['user_id']=="{{ Auth::User()->id }}"){
              eliminar_evidencia = "<a href='#' data-actividad='"+response[x]['actividad_nombre']+"' data-archivo='"+response[x]['evidencia_id']+"' data-validado = '"+response[x]['validado']+"'data-archivo_nombre='"+archivo+"' class='eliminar-evidencia'>"
                +"<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>"
                +"</a>";
            }
          }
          let actividad_nombre = response[x]['actividad_nombre'];
          let responsable = ucwords(response[x]['responsable_nombre']);
          let alumno_nombre = response[x]['alumno_nombre'] === null ? 'NA' : ucwords(response[x]['alumno_nombre']);
          let fecha = response[x]['fecha_creacion'];
          let pdf_icono = asset('images/pdf_icono2.png');
          let isPDF = getExtension(archivo) === 'pdf';
          let imagen_url = (isPDF ? pdf_icono : asset('storage/evidencias', actividad_nombre, archivo));
          let archivo_url = asset('storage/evidencias', actividad_nombre, archivo);
          $('#gallery-container').append(crearElementoParaGaleria(nombre_original, responsable, alumno_nombre, fecha, imagen_url, archivo_url, isPDF));
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

      function elhover(){
        $(document).on('mouseover','.gallery' ,function(event){
          $(this).find('img.eliminar').css('visibility','visible');
        });
        $(document).on('mouseout','.gallery' ,function(event){
          $(this).find('img.eliminar').css('visibility','hidden');
        });
      }

      function cookiesEvidencia(){
        var actividad_id = Cookies.get('evidencia_actividad');
        if($("#actividades_id option[value='"+actividad_id+"']").length!=0 && actividad_id!=null){
          $('#actividades_id').val(actividad_id);
          $('#actividades_id').trigger('change');
        }
      }

      function eliminarEvidencia(){
        $(document).on('click','.eliminar-evidencia',function(event){
          event.preventDefault();
          var confirmacion = confirm("¿Estas seguro que deseas eliminar esta evidencia?");
          if(confirmacion){
            var actividad = $(this).attr('data-actividad');
            var archivo_id = $(this).attr('data-archivo');
            var archivo_nombre = $(this).attr('data-archivo_nombre');
            var validado_msj = $(this).attr('data-validado');
            var validado = true;
            if(validado_msj=="true"){
              validado = confirm("La evidencia se encuentra actualmente validada,¿Seguro que deseas continuar?");
            }
            if(validado){
              $.ajax({
                type: "get",
                dataType: "json",
                url: "{{ route('evidencias.eliminar') }}",
                data:{
                  actividad: actividad,
                  archivo: archivo_id,
                  archivo_nombre: archivo_nombre
                },
                success: function(response){
                  mostrarMensaje(response['mensaje'],'mensaje-parte-superior',response['tipo']);
                  $('#responsables_id').trigger('change');
                }, error: function(){
                  mostrarMensaje("Error al eliminar la evidencia",'mensaje-parte-superior','error');
                }
              });
            }
          }
        });
      }

      $(document).ready(function(event){
        comboResponsables();
        peticionGaleria();
        elhover();
        cookiesEvidencia();
        eliminarEvidencia();
      });
    </script>
  @endsection
@endsection
