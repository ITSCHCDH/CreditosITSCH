<!doctype html> 
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inicio|@yield('title','Default')</title>
    <link rel="stylesheet" href="{{asset('menu/css/fontello.css')}}">
    <link rel="stylesheet" href="{{asset('cssMenu/estilos.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssReportes/reportes.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cssAutocompletar/autocompletar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/cssTable/jquery.dataTables.min.css') }}">
    <!-- Custom fonts for this template-->
    <link href="{{asset('plugins/vendorTem/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{asset('complementos/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('complementos/css/bootstrap-theme.css')}}" rel="stylesheet">

    @yield('links')
</head>
<body>
        <style type="text/css">
            .alerta-padding{
                padding: 10px;
            }
        </style>
        <!-- Seccion de menu del sistema, mensajes de alerta y elementos de busqueda -->
        <div class="content-all" style="position: relative; z-index: 999 !important;">
            <header>
            </header>
        <input type="checkbox" id="check">
            @if(Auth::guard('web')->check())
                <label for="check" class="fa fa-bars" id="menu">Menu</label>
            @endif
            <!-- Imagen ITSCH -->
            <div style="position: fixed;left: 97%;top: 8px;">
                <a  href="{{ url('/home') }}">
                    <div style="text-align: center;">
                        <img src="{{ asset('images/itsch.jpg') }}" border="0" width="35" height="40" class="img-rounded">
                    </div>
                </a>
            </div>

            <!-- Incluye sistema de alertas-->
            @include('template.partes.alertas')

            <!-- Incluye el menu al sistema -->
            @if(Auth::guard('web')->check())
                @include('template.partes.menu')
            @endif

        </div>
        <!--Contenido principal del sistema  -->
        <main id="cuerpo">
            <!--Div para el contenido de todo el sistema -->
            <div class="container" id="divPrincipal">
                <div class="container-fluid">
                    <ol class="breadcrumb" style="box-shadow: 2px 2px 7px #999;">
                        <li class="breadcrumb-item">
                            @if (Auth::guard('alumno')->check())
                                <label class="label label-primary">{{ Auth::User()->nombre }}</label>
                            @else
                                <a href="{{ url('/home') }}">Inicio</a>
                            @endif
                        </li>
                        <li class="breadcrumb-item active"> @yield('ruta','Default')
                        </li>
                    </ol>
                    <div class="container" id="contenido">
                        <div class="col-md-12">
                            <h2>Sistema de creditos complementarios CREDITSCH</h2>
                            <section>
                                @include('flash::message') <!-- Esto es para mostrar los mensajes en los formularios -->
                            </section>
                            @yield('contenido','Default')<!-- Contenido general del sistema -->
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <!-- Incluye el pie de pagina en el sistema -->
    @include('template.partes.pie')
    <script src="{{asset('plugins/vendorTem/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('complementos/js/bootstrap.js')}}"></script>
    @if(Auth::guard('web')->check())
        <script src="{{asset('js2/js2.js')}}"> </script>
    @endif
    <script  src="{{ asset('plugins/jsTable/jquery.dataTables.min.js') }}"></script>
    <!-- Script para ocultar los mensajes de Flash -->

    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(300);
    </script>
    <!-- Paquete para los mensajes tipo bootstrap, para notificaciones en formularios -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript">
        // Funcion para manejar mensajes desde javascript 
        function mostrarMensaje(mensaje_texto,mensaje_id,mensaje_tipo){
            var mensaje = document.getElementById(mensaje_id);
            switch (mensaje_tipo){
                case "error":
                    mensaje.innerHTML= "<div class='alert-danger alerta-padding' id='mensaje-unico-mds'>"+
                    mensaje_texto+"</div>";
                break;
                case "exito":
                    mensaje.innerHTML= "<div class='alert-success alerta-padding' id='mensaje-unico-mds'>"+
                    mensaje_texto+"</div>";
                break;  
                case "neutral":
                    mensaje.innerHTML= "<div class='alert-info alerta-padding' id='mensaje-unico-mds'>"+
                    mensaje_texto+"</div>";
                break;
                case "advertencia":
                    mensaje.innerHTML= "<div class='alert-warning alerta-padding' id='mensaje-unico-mds'>"+
                    mensaje_texto+"</div>";
                break;
                default:
                    mensaje.innerHTML= "<div class='alert-info alerta-padding' id='mensaje-unico-mds'>"+
                    mensaje_texto+"</div>";
            }
            $('#mensaje-unico-mds').delay(4000).fadeOut(2000);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                type: "get",
                cache: false,
                url: "{{ route('mensajes.nuevos_mensajes') }}",
                success: function(response){
                    var numero_mensajes_recibidos = document.getElementById('no-mensajes-recibidos');
                    var div_mensajes_recibidos = document.getElementById('div-mensajes-recibidos');
                    div_mensajes_recibidos.innerHTML = "";
                    if(response['no_mensajes']==0){
                        numero_mensajes_recibidos.innerHTML = "No tienes mensajes";
                        div_mensajes_recibidos.innerHTML +="<div class='dropdown-divider'></div>";
                    }else if(response['no_mensajes']==1){
                        numero_mensajes_recibidos.innerHTML = response['no_mensajes']+" nuevo mensaje";
                        for (var i = 0; i < response['data'].length; i++) {
                            if (i!=0){
                                div_mensajes_recibidos.innerHTML +="<div class='dropdown-divider'></div>";
                            }
                            var temp_ruta = "{{ route('mensajes.ver',['mensaje_id' => 'aux','receptor_id' => 'mds']) }}";
                            temp_ruta = temp_ruta.replace('aux',response['data'][i]['mensaje_id']);
                            temp_ruta = temp_ruta.replace('mds',response['data'][i]['receptor_id']);
                            div_mensajes_recibidos.innerHTML += "<a class='dropdown-item' href='"+temp_ruta+"'>"+
                            "<span class='text-success'>"+
                            "<strong>"+
                            "<i class='fa fa-long-arrow-up fa-fw'></i>Mensaje "+(i+1)+": </strong>"+
                            "</span>"+
                            "<span class='small float-right text-muted'>"+response['data'][i]['fecha'].substring(11,16)+"</span>"+
                            "<div class='dropdown-message small'>"+response['data'][i]['notificacion']+"<div>"+
                            "</a>";
                        }
                    }else{
                        numero_mensajes_recibidos.innerHTML = response['no_mensajes']+" nuevos mensajes";
                        for (var i = 0; i < response['data'].length; i++) {
                            if (i!=0){
                                div_mensajes_recibidos.innerHTML +="<div class='dropdown-divider'></div>";
                            }
                            var temp_ruta = "{{ route('mensajes.ver',['mensaje_id' => 'aux','receptor_id' => 'mds']) }}";
                            temp_ruta = temp_ruta.replace('aux',response['data'][i]['mensaje_id']);
                            temp_ruta = temp_ruta.replace('mds',response['data'][i]['receptor_id']);
                            div_mensajes_recibidos.innerHTML += "<a class='dropdown-item' href='"+temp_ruta+"'>"+
                            "<span class='text-success'>"+
                            "<strong>"+
                            "<i class='fa fa-long-arrow-up fa-fw'></i>Mensaje "+(i+1)+": </strong>"+
                            "</span>"+
                            "<span class='small float-right text-muted'>"+response['data'][i]['fecha'].substring(11,16)+"</span>"+
                            "<div class='dropdown-message small'>"+response['data'][i]['notificacion']+"<div>"+
                            "</a>";
                        }
                    }
                },error: function(){
                    console.log('Error al recibir los mensajes nuevos');
                }
            });
        });
    </script>
    @yield('js')
</body>
</html>