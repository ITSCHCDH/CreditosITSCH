<!-- Menu del sistema -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Navbar brand -->
            <a class="navbar-brand" href="#">
            <img src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png" height="16" alt="" loading="lazy"
                style="margin-top: -3px;" />
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
            aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarExample01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (Auth::guard('alumno')->check())
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="{{ route('alumnos.home_avance')}}">Inicio</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="{{ url('/home') }}">Inicio</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mensajes.index') }}">Mensajes</a>
                </li>

                @if (Auth::guard('web')->check())       
                    @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('alumnos.index')}}" rel="nofollow">Alumnos</a>
                        </li>
                    @endif 
                    @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS'))                 
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('creditos.index')}}" rel="nofollow">Creditos</a>
                        </li>   
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ACTIVIDAD','VIP_ACTIVIDAD','VER_PARTICIPANTES','VIP_EVIDENCIA','VER_EVIDENCIA']))             
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Actividades</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::User()->can('VIP')|| Auth::User()->can('VER_ACTIVIDAD') || Auth::User()->can('VIP_ACTIVIDAD') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                    <a class="dropdown-item" href="{{route('actividades.index')}}">Administrar actividades</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']))
                                    <a class="dropdown-item" href="{{route('participantes.index')}}">Agregar participantes</a>
                                @endif
                                @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA') || Auth::User()->can('VER_EVIDENCIA') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                    <a class="dropdown-item" href="{{route('evidencias.index')}}">Evidencia</a>
                                @endif
                            </div>
                        </li> 
                    @endif  
                    @if (Auth::User()->hasAnyPermission('VIP','VIP_AVANCE_ALUMNO','VER_AVANCE_ALUMNO','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VER_REPORTES_CARRERA','VIP_REPORTES'))           
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Avance</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                                    <a class="dropdown-item" href="{{ route('verifica_evidencia.avance_alumno') }}">Avance</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                                    <a class="dropdown-item" href="{{ route('verifica_evidencia.index') }}">Verificar evidencia</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA','VIP']))
                                    <a class="dropdown-item" href="{{ route('verifica_evidencia.reportes') }}">Reporte</a>
                                @endif
                            </div>
                        </li>
                    @endif                        
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Administración</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                                    <a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                                @endif
                                @if(Auth::User()->hasAnyPermission('VIP','VER_AREAS','VIP_SOLO_LECTURA'))
                                    <a class="dropdown-item" href="{{ route('areas.inicio') }}">Areas</a>
                                @endif 
                                @if (Auth::User()->hasAnyPermission('VIP','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA'))
                                    <a class="dropdown-item" href="{{ route('constancias.index') }}">Constancias</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                                    <a class="dropdown-item" href="{{ route('ImportExcel.index') }}">Modificar password alumnos</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                                    <a class="dropdown-item" href="{{ route('ImportExcel.altaAlumnos') }}">Insertar alumnos desde excel</a>   
                                @endif                            
                            </div>
                        </li>
                @endif        
            </ul>   
            <ul class="navbar-nav ml-auto mr-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('perfil.index') }}">Mi perfil</a> 
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <i class="material-icons" style="font-size:15px"></i>
                            {{ __('Salir') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>        
                </li>
            </ul>            
        </div>
    </nav>
    <!-- Navbar -->

    {{-- <p>        
        @if(Auth::guard('web')->check())
            <label for="check" class="fa fa-bars colMen " data-toggle="modal" data-target="#myModal">Menu</label>
        @endif
    </p> --}}
    
    {{-- <div id="accordion">  --}}          
        {{-- @if (Auth::guard('alumno')->check())
            <div class="card ">
                <div class="card-header">
                    <a class="card-link colMen" href={{ route('alumnos.home_avance')}}>
                        <i class="fa fa-home" style="font-size:15px"></i>
                        <span> &nbsp;&nbsp;Inicio</span>
                    </a>
                </div>     
            </div>  
        @else
            <div class="card">
                <div class="card-header">
                    <a class="card-link colMen" href={{ url('/home') }}>
                        <i class="fa fa-home" style="font-size:15px"></i>
                        <span >&nbsp;&nbsp;Inicio</span>
                    </a>
                </div>     
            </div>    
        @endif  --}}       
       {{--  @if (Auth::guard('web')->check())   --}}     
            {{-- @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))
                <div class="card">
                    <div class="card-header">    
                        <a class="card-link colMen" href="{{route('alumnos.index')}}">
                            <i class="fa fa-graduation-cap" style="font-size:15px"></i>
                            <span >&nbsp;&nbsp;Alumnos</span>
                        </a>
                    </div>     
                </div>                
            @endif     --}}    
           {{--  @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS')) 
                <div class="card">
                    <div class="card-header">          
                        <a class="card-link colMen" href="{{route('creditos.index')}}">
                            <i class="fa fa-fw fa-table" style="font-size:15px"></i>
                            <span >&nbsp;&nbsp;Créditos</span>
                        </a> 
                    </div>     
                </div>          
            @endif  --}}
            {{-- @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ACTIVIDAD','VIP_ACTIVIDAD','VER_PARTICIPANTES','VIP_EVIDENCIA','VER_EVIDENCIA']))                  
                <div class="card">
                    <div class="card-header">
                        <a class="card-link colMen" data-toggle="collapse" href="#collapseOne">
                            <i class="fa fa-fw fa-list-ul" style="font-size:15px"></i>
                            <span >&nbsp;&nbsp;Actividades&nbsp;&nbsp;</span>
                            <i class='fas fa-angle-down'></i>                        
                        </a>
                    </div>                   
                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                            @if (Auth::User()->can('VIP')|| Auth::User()->can('VER_ACTIVIDAD') || Auth::User()->can('VIP_ACTIVIDAD') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                <div class="card-body">
                                    <a class="colTxtSub" href="{{route('actividades.index')}}">
                                        <i class="fa fa-futbol-o" style="font-size:10px"></i>
                                        <span >&nbsp;&nbsp;Administrar actividades</span>
                                    </a>
                                </div>
                            @endif
                            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']))
                                <div class="card-body">
                                    <a class="colTxtSub" href="{{route('participantes.index')}}">
                                        <i class="fa fa-users" style="font-size:10px"></i>
                                        <span >&nbsp;&nbsp;Agregar participantes</span>
                                    </a>
                                </div>
                            @endif
                            @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA') || Auth::User()->can('VER_EVIDENCIA') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                <div class="card-body">
                                    <a class="colTxtSub" href="{{route('evidencias.index')}}">
                                        <i class="fa fa-camera" style="font-size:10px"></i>
                                        <span >&nbsp;&nbsp;Evidencia</span>
                                    </a>
                                </div>
                             @endif
                        </div>               
                </div>
            @endif --}}
            {{-- @if (Auth::User()->hasAnyPermission('VIP','VIP_AVANCE_ALUMNO','VER_AVANCE_ALUMNO','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VER_REPORTES_CARRERA','VIP_REPORTES'))
                <div class="card">
                    <div class="card-header">
                        <a class="collapsed card-link colMen" data-toggle="collapse" href="#collapseTwo">
                            <i class="fa fa-pie-chart" style="font-size:15px"></i>
                            <span >&nbsp;&nbsp;Avances&nbsp;&nbsp;</span>
                            <i class='fas fa-angle-down'></i>
                        </a>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                            <div class="card-body ">
                                <a class="colTxtSub" href="{{ route('verifica_evidencia.avance_alumno') }}">
                                    <i class="fa fa-bar-chart-o" style="font-size:10px"></i>
                                    <span >&nbsp;&nbsp;Avance</span>
                                </a>
                            </div>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                            <div class="card-body">
                                <a class="colTxtSub" href="{{ route('verifica_evidencia.index') }}">
                                    <i class="fa fa-calendar-check-o" style="font-size:10px"></i>
                                    <span >&nbsp;&nbsp;Verificar evidencia</span>
                                </a>
                            </div>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA','VIP']))
                            <div class="card-body">
                                <a class="colTxtSub" href="{{ route('verifica_evidencia.reportes') }}">
                                    <i class="fa fa-file-pdf-o" style="font-size:10px"></i>
                                    <span >&nbsp;&nbsp;Reportes</span>
                                </a>
                            </div>
                        @endif
                    </div>           
                </div>
            @endif --}}
            {{-- <div class="card"> --}}
               {{--  <div class="card-header">
                    <a class="collapsed card-link colMen" data-toggle="collapse" href="#collapseThree">
                        <i class="fa fa-gear" style="font-size:15px"></i>
                        <span >&nbsp;&nbsp;Administración&nbsp;&nbsp;</span>
                        <i class='fas fa-angle-down'></i>                        
                    </a>
                </div> --}}
                {{-- <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <a class="colTxtSub" href="{{ route('perfil.index') }}">
                            <i class="fa fa-user" style="font-size:10px"></i>
                            <span >&nbsp;&nbsp;Mi perfil</span>
                        </a>
                    </div> --}}
                  {{--   @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('usuarios.index') }}">
                                <i class="fa fa-users" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Usuarios</span>
                            </a>
                        </div>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('roles.index') }}">
                                <i class="fa fa-address-card" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Roles</span>
                            </a>
                        </div>
                    @endif
                    @if(Auth::User()->hasAnyPermission('VIP','VER_AREAS','VIP_SOLO_LECTURA'))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('areas.inicio') }}">
                                <i class="fa fa-map-marker" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Areas</span>
                            </a>
                        </div>
                    @endif
                    @if (Auth::User()->hasAnyPermission('VIP','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA'))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('constancias.index') }}">
                                <i class="fa fa-print" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Constancias</span>
                            </a>
                        </div>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('ImportExcel.index') }}">
                                <i class="glyphicon glyphicon-import" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Modificar password alumnos</span>
                            </a>
                        </div>
                    @endif   
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                        <div class="card-body">
                            <a class="colTxtSub" href="{{ route('ImportExcel.altaAlumnos') }}">
                                <i class="glyphicon glyphicon-circle-arrow-up" style="font-size:10px"></i>
                                <span >&nbsp;&nbsp;Insertar alumnos desde excel</span>
                            </a>
                        </div>
                    @endif --}}
            {{--     </div>
            </div> --}}
           {{--  <div class="card">
                <div class="card-header"> 
                    <a  class="colMen" href="{{ route('mensajes.index') }}">
                        <i class='far fa-envelope' style="font-size:15px"></i>
                        <span >&nbsp;&nbsp;Mensajes</span>
                    </a>
                </div>     
            </div>  --}}
           {{--  @if(Auth::guard('web')->check())
                <div class="card">
                    <div class="card-header">       
                        <a class="colMen"  onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
                            <i class="material-icons" style="font-size:15px">exit_to_app</i>
                            <span >&nbsp;&nbsp;Cerrar sesión </span>
                        </a>
                        <!-- Creamos el formulario en orden para poder cerrar sesion -->
                        <form id="logout-form2" action="{{ route('logout')}}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form> 
                    </div>     
                </div>       
            @endif  --}}
       {{--  @endif  --}}           
   {{--  </div>    --}}               


       
       
  

    

