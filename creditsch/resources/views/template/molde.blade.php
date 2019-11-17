<!doctype html> 
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
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
    <!--Link para usar iconos google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--  Estilo de la barra de progreso   -->
    <style>
        .progress { position:relative; width:30%; border: 1px solid #7F98B2; padding: 1px; border-radius: 5px;}
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:0px; left:48%; color: #7F98B2;}
        .white-icon{
            -webkit-filter: invert(100%);
        }
    </style>
    @yield('links')

<!--Estilos de la pagina principal -->
<style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
       
    /* Set waith background color and 100% height */
    .sidenav {
      padding-top: 10px;
      background-color: #000;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #000;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 5px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>
<body>  
    <div>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container">             
                <div class="navbar-header ">                          
                    <!-- Imagen ITSCH -->               
                    @if(Auth::guard('web')->check())
                        <a  class="navbar-brand" href="{{ url('/home') }}">
                            <div style="text-align: center;">
                                <img src="{{ asset('images/itsch.jpg') }}"  width="35" height="40" >
                            </div>
                        </a>
                    @else
                        <a  class="navbar-brand" href="{{ route('alumnos.home_avance')}}">
                            <div style="text-align: center;">
                                <img src="{{ asset('images/itsch.jpg') }}"  width="35" height="40" >
                            </div>
                        </a>
                    @endif                 
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>               
                    <li><a href="#">Mensajes</a></li>
                    <li> 
                        @if(!Auth::guard('alumno')->check())             
                                <a href="{{ route('mensajes.index') }}">
                                    <i class="material-icons">contact_mail</i>
                                </a>                         
                        @endif 
                    </li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in">
                         <!-- Incluye menu de usuario -->
                        @include('template.partes.menUser')
                    </span>                    
                    </a></li>
                  </ul>
                </div>
              </div>
        </nav>
    </div>        
    <div>    
        <div class="row">
            <div class="col-sm-1">
                <!-- Incluye el menu al sistema -->
                @if(Auth::guard('web')->check())
                    @include('template.partes.menu')
                @endif                     
            </div>
            <div class="col-sm-10" id="divPrincipal">
                <div style="box-shadow: 4px 4px 10px #000;">                  
                    <ul class="breadcrumb" >
                        <li class="breadcrumb-item">
                            @if (Auth::guard('alumno')->check())
                                <label class="label label-primary">{{ Auth::User()->nombre }}</label>
                            @else
                                <a href="{{ url('/home') }}">Inicio</a>
                            @endif
                        </li>
                        <li class="breadcrumb-item active"> @yield('ruta','Default')
                        </li>
                    </ul>
                </div>                              
                <div class="text-right" id="contenido">
                    <section>
                    @include('flash::message') <!-- Esto es para mostrar los mensajes en los formularios -->
                    </section>
                    @yield('contenido','Default')<!-- Contenido general del sistema -->
                </div>                                 
            </div>
            <div class="col-sm-1">
              
            </div>
      </div>
    </div>

    <footer class="container-fluid text-center">
      <p>Copyright © ITSCH 2017|CEDEITSCH</p>
    </footer>

     
    <!-- Scripts del sistema -->
  
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
    
    @yield('js')
</body>
</html>