<!-- Menu del sistema -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Navbar brand -->
            <a class="navbar-brand" href="#">
            <img src="{{ asset('images/itsch.jpg') }}" height="22" alt="Logo del ITSCH" loading="lazy"
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
                        <a class="nav-link" aria-current="page" href="{{ route('alumnos.home_avance')}}" title="Inicio"><i class="fas fa-home"></i></a>
                    </li>                   
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="{{ route('alumnos.sta.ficha',1) }}" title="Créditos">Ficha</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="{{ url('/home') }}" title="Inicio"><i class="fas fa-home"></i></a>
                    </li>
                @endif  
                @if (Auth::guard('web')->check())                                        
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
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                                    <a class="dropdown-item" href="{{ route('verifica_evidencia.index') }}">Verificar evidencia</a>
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
                                @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA','VIP']))
                                    <a class="dropdown-item" href="{{ route('verifica_evidencia.reportes') }}">Reporte</a>
                                @endif
                            </div>
                        </li>
                    @endif   
                    {{-- Menú de STA --}}
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_STA','STA_COR_CARRERA','STA_PROFESOR','STA_TUTOR','STA_DEP_TUTORIA']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">STA</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_COR_CARRERA') || Auth::User()->can('VIP'))                                    
                                    <a class="dropdown-item" href="{{ route('analisis.index') }}">Jefes de carrera</a>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_PROFESOR') || Auth::User()->can('VIP'))                                    
                                    <a class="dropdown-item" href="{{ route('profesores.index') }}">Profesor</a>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_TUTOR') || Auth::User()->can('VIP'))                          
                                    <a class="dropdown-item" href="{{ route('tutores.index') }}">Tutor</a>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_DEP_TUTORIA') || Auth::User()->can('VIP'))                                     
                                    <a class="dropdown-item" href="{{ route('tutorias.index') }}">Departamento tutorias</a>
                                @endif
                            </div>
                        </li>
                    @endif      
                    <!-- Menú sistema medico -->
                    @if (Auth::User()->hasAnyPermission(['VIP','VER_CITAS_MEDICAS','MODIFICAR_CITAS_MEDICAS']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Sistema Médico</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_MEDICO']))
                                    <a class="dropdown-item" href="{{ route('medico.index') }}">Agenda médica</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_CITAS_MEDICAS']))
                                    <a class="dropdown-item" href="{{ route('paciente.index.citas') }}">Mis cita</a>
                                @endif
                            </div>
                        </li>
                    @endif                    
                    <!-- Menú de administración -->
                    @if (Auth::User()->hasAnyPermission(['VIP','VER_USUARIOS']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Administración</a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                @if(Auth::User()->hasAnyPermission('VIP','VER_AREAS','VIP_SOLO_LECTURA'))
                                    <a class="dropdown-item" href="{{ route('areas.inicio') }}">Areas</a>
                                @endif 
                                @if (Auth::User()->hasAnyPermission('VIP','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA'))
                                    <a class="dropdown-item" href="{{ route('constancias.index') }}">Constancias</a>
                                @endif                                    
                                @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS'))                                 
                                    <a class="dropdown-item" href="{{route('creditos.index')}}">Creditos</a>                                    
                                @endif                                    
                                <hr>                                   
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))                                   
                                    <a class="dropdown-item" href="{{route('alumnos.index')}}">Alumnos</a>                                   
                                @endif   
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                                    <a class="dropdown-item" href="{{ route('ImportExcel.index') }}">Modificar password alumnos</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                                    <a class="dropdown-item" href="{{ route('ImportExcel.altaAlumnos') }}">Insertar alumnos desde excel</a>   
                                @endif 
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS','VER_AREAS','VER_ALUMNOS']))
                                    <a class="dropdown-item" href="{{ route('alumnos.bajas.view') }}">Baja de alumnos</a>
                                @endif
                                <hr>
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                                    <a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                                @endif                                                     
                            </div>
                        </li>
                    @endif                       
                @endif        
            </ul>   
            <ul class="navbar-nav ml-auto mr-4">
                <li class="nav-item dropdown">
                    @if (!Auth::guard('alumno')->check())
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                    @else
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::guard('alumno')->user()->nombre }}</a>
                    @endif
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        @if (!Auth::guard('alumno')->check())
                            <a class="dropdown-item" href="{{ route('perfil.index') }}">Mi perfil</a> 
                        @else
                            <a class="dropdown-item" href="{{ route('alumnos.perfil',$alumno_data[0]->alumno_id) }}">Mi perfil</a>
                        @endif
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


       
       
  

    

