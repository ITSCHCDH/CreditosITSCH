<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CREDITSCH') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('cssMenu/estilos.css')}}">

    <!-- Fondo de particulas -->
     <link rel="stylesheet" href="{{asset('cssParticles/style.css')}}">  
     <style>
         .mdshover:hover{
           color: #fff !important;
         }
     </style>
</head>


<body>

    <!-- particles.js container --> 
  <div id="particles-js"></div> 
  <!-- stats - count particles --> 
  <div class="count-particles"> <span class="js-count-particles">--</span> particles </div> 
            <div id="app">
                <nav class="navbar navbar-default navbar-static-top" style="background-color:#2d3e50;">
                    <div class="container pull-left" style="margin-left: 70px; width: 93%;">
                        <div class="navbar-header">
                               <!-- Imagen ITSCH -->
                                @if (Auth::guard('web')->check())
                                   <a  href="{{ url('/home') }}">
                                       <div style="text-align: center;">
                                           <img src="{{ asset('images/itsch.jpg') }}" border="0" width="35" height="45" class="img-rounded">
                                           <br>
                                           <p style="font-family: sans-serif; color:#fff;">CREDITSCH</p>
                                       </div>
                                   </a>
                                @elseif(Auth::guard('alumno')->check())
                                    <a  href="{{ route('alumnos.home_avance') }}">
                                        <div style="text-align: center;">
                                            <img src="{{ asset('images/itsch.jpg') }}" border="0" width="35" height="45" class="img-rounded">
                                            <br>
                                            <p style="font-family: sans-serif; color:#fff;">CREDITSCH</p>
                                        </div>
                                    </a>
                                @else
                                    <a  href="{{ url('/') }}">
                                        <div style="text-align: center;">
                                            <img src="{{ asset('images/itsch.jpg') }}" border="0" width="35" height="45" class="img-rounded">
                                            <br>
                                            <p style="font-family: sans-serif; color:#fff;">CREDITSCH</p>
                                        </div>
                                    </a>
                                @endif
                                
                        </div>

                        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                            <!-- Left Side Of Navbar -->
                            <ul class="nav navbar-nav">
                                &nbsp;
                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="nav navbar-nav navbar-right">
                                <!-- Authentication Links -->
                                @if (Auth::guard('alumno')->check())
                                    <li>
                                        <a href="{{ route('alumnos.home_avance') }}" class="dropdown-toggle mdshover" style="font-size: 1vw;" class="mdshover">Home</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle mdshover" data-toggle="dropdown" role="button" aria-expanded="true" style="font-size: 1vw; background: #2d3e50;" >
                                            {{ Auth::guard('alumno')->user()->nombre }} <span class="caret"></span>
                                        </a>

                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('alumnos.logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();" style="font-size: 1vw;">
                                                    Cerrar sesión
                                                </a>

                                                <form id="logout-form" action="{{ route('alumnos.logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @elseif (Auth::guard('web')->check())
                                    <li>
                                        <a href="{{ url('/home') }}" style="font-size: 1vw;" class="mdshover">Home</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle mdshover" style="font-size: 1vw; background: #2d3e50;" data-toggle="dropdown" role="button" aria-expanded="false">
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>

                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();" style="font-size: 1vw;">
                                                    Cerrar sesión
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>

                @yield('content')
            </div>

    <!-- Scripts -->    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('plugins/vendorTem/jquery/jquery.min.js')}}"></script>

    <!-- particles.js lib - https://github.com/VincentGarreau/particles.js --> 
    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
    <!-- stats.js lib --> 
    <script src="http://threejs.org/examples/js/libs/stats.min.js"></script>
    <script  src="jsParticles/index.js"></script>

    @yield('js')
</body>
 @include('template.partes.pie')
</html>
