<!-- Menu del sistema -->
<div class="container">
    <p>
        <input type="checkbox" id="check">
        @if(Auth::guard('web')->check())
            <label for="check" class="fa fa-bars colMen " id="labMen">Menu</label>
        @endif
    </p>
    
    <div id="accordion">           
        @if (Auth::guard('alumno')->check())
            <div class="card ">
                <div class="card-header">
                    <a class="card-link colMen" href="/alumnos/home">
                        <i class="fa fa-home"></i>
                        <span class="spaMenu">Inicio</span>
                    </a>
                </div>     
            </div>  
        @else
            <div class="card">
                <div class="card-header">
                    <a class="card-link colMen" href="/home">
                        <i class="fa fa-home"></i>
                        <span class="spaMenu">Inicio</span>
                    </a>
                </div>     
            </div>    
        @endif        
        @if (Auth::guard('web')->check())       
            @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))
            <div class="card">
                <div class="card-header">    
                    <a class="card-link colMen" href="{{route('alumnos.index')}}">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="spaMenu">Alumnos</span>
                    </a>
                </div>     
            </div>                
            @endif        
            @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS')) 
            <div class="card">
                <div class="card-header">          
                    <a class="card-link colMen" href="{{route('creditos.index')}}">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="spaMenu">Créditos</span>
                    </a> 
                </div>     
            </div>          
            @endif 
            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ACTIVIDAD','VIP_ACTIVIDAD','VER_PARTICIPANTES','VIP_EVIDENCIA','VER_EVIDENCIA']))                  
                <div class="card">
                    <div class="card-header">
                        <a class="card-link colMen" data-toggle="collapse" href="#collapseOne">
                            <i class="fa fa-fw fa-list-ul"></i>
                            <span class="spaMenu">Actividades</span>                        
                        </a>
                    </div>                   
                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                            @if (Auth::User()->can('VIP')|| Auth::User()->can('VER_ACTIVIDAD') || Auth::User()->can('VIP_ACTIVIDAD') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                <div class="card-body">
                                    <a class="colMen" href="{{route('actividades.index')}}">
                                        <i class="fa fa-futbol-o"></i>
                                        <span class="etSubMenu">Administrar actividades</span>
                                    </a>
                                </div>
                            @endif
                            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']))
                                <div class="card-body">
                                    <a class="colMen" href="{{route('participantes.index')}}">
                                        <i class="fa fa-users"></i>
                                        <span class="etSubMenu">Agregar participantes</span>
                                    </a>
                                </div>
                            @endif
                            @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA') || Auth::User()->can('VER_EVIDENCIA') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                <div class="card-body">
                                    <a class="colMen" href="{{route('evidencias.index')}}">
                                        <i class="fa fa-camera"></i>
                                        <span class="etSubMenu">Evidencia</span>
                                    </a>
                                </div>
                             @endif
                        </div>               
                </div>
            @endif
            @if (Auth::User()->hasAnyPermission('VIP','VIP_AVANCE_ALUMNO','VER_AVANCE_ALUMNO','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VER_REPORTES_CARRERA','VIP_REPORTES'))
                <div class="card">
                    <div class="card-header">
                        <a class="collapsed card-link colMen" data-toggle="collapse" href="#collapseTwo">
                            <i class="fa fa-pie-chart"></i>
                            <span class="spaMenu">Avances</span>
                        </a>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                            <div class="card-body">
                                <a class="colMen" href="{{ route('verifica_evidencia.avance_alumno') }}">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span class="etSubMenu">Avance</span>
                                </a>
                            </div>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                            <div class="card-body">
                                <a class="colMen" href="{{ route('verifica_evidencia.index') }}">
                                    <i class="fa fa-calendar-check-o"></i>
                                    <span class="etSubMenu">Verificar evidencia</span>
                                </a>
                            </div>
                        @endif
                        @if (Auth::User()->hasAnyPermission('VIP','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA'))
                            <div class="card-body">
                                <a class="colMen" href="{{ route('constancias.index') }}">
                                    <i class="fa fa-print"></i>
                                    <span class="etSubMenu">Constancias</span>
                                </a>
                            </div>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA','VIP']))
                            <div class="card-body">
                                <a class="colMen" href="{{ route('verifica_evidencia.reportes') }}">
                                    <i class="fa fa-file-pdf-o"></i>
                                    <span class="etSubMenu">Reportes</span>
                                </a>
                            </div>
                        @endif
                    </div>           
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link colMen" data-toggle="collapse" href="#collapseThree">
                        <i class="fa fa-lock"></i>
                        <span class="spaMenu">Administración</span>
                        <i class="fa fa-chevron-right flesub"></i>
                    </a>
                </div>
                <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        <a class="colMen" href="{{ route('perfil.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="etSubMenu">Mi perfil</span>
                        </a>
                    </div>
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                        <div class="card-body">
                            <a class="colMen" href="{{ route('usuarios.index') }}">
                                <i class="fa fa-users"></i>
                                <span class="etSubMenu">Usuarios</span>
                            </a>
                        </div>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                        <div class="card-body">
                            <a class="colMen" href="{{ route('roles.index') }}">
                                <i class="fa fa-address-card"></i>
                                <span class="etSubMenu">Roles</span>
                            </a>
                        </div>
                    @endif
                    @if(Auth::User()->hasAnyPermission('VIP','VER_AREAS','VIP_SOLO_LECTURA'))
                        <div class="card-body">
                            <a class="colMen" href="{{ route('areas.inicio') }}">
                                <i class="fa fa-map-marker"></i>
                                <span class="etSubMenu">Areas</span>
                            </a>
                        </div>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                        <div class="card-body">
                            <a class="colMen" href="{{ route('ImportExcel.index') }}">
                                <i class="glyphicon glyphicon-import"></i>
                                <span class="etSubMenu">Modificar password alumnos</span>
                            </a>
                        </div>
                    @endif   
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                        <div class="card-body">
                            <a class="colMen" href="{{ route('ImportExcel.altaAlumnos') }}">
                                <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                <span class="etSubMenu">Insertar alumnos desde excel</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header"> 
                    <a  class="colMen" href="{{ route('mensajes.index') }}">
                        <i class="fa fa-envelope"></i>
                        <span class="spaMenu">Mensajes</span>
                    </a>
                </div>     
            </div> 
            @if(Auth::guard('web')->check())
                <div class="card">
                    <div class="card-header">       
                        <a class="colMen"  onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
                            <i class="fa fa-fw fa-sign-out"></i>
                            <span class="spaMenu">Cerrar sesión </span>
                        </a>
                        <!-- Creamos el formulario en orden para poder cerrar sesion -->
                        <form id="logout-form2" action="{{ route('logout')}}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form> 
                    </div>     
                </div>       
            @endif 
        @endif            
    </div>                  
</div>

       
       
  

    

