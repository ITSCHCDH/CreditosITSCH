<!-- Menu del sistema -->
<nav class="menu" id="idMenu">
    <ul>
        <li class="botMen">
            @if (Auth::guard('alumno')->check())
                <a class="etMenu" href="/alumnos/home">
                    <i class="fa fa-home"></i>
                    <span class="spaMenu">Inicio</span>
                </a>
            @else
                <a class="etMenu" href="/home">
                    <i class="fa fa-home"></i>
                    <span class="spaMenu">Inicio</span>
                </a>
            @endif
            
        </li>
        @if (Auth::guard('web')->check())
            @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))
                <li class="botMen">
                    <a class="etMenu" href="{{route('alumnos.index')}}">
                        <i class="fa fa-graduation-cap"></i>
                        <span class="spaMenu">Alumnos</span>
                    </a>
                </li>
            @endif
            @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS'))
                <li class="botMen">
                    <a class="etMenu" href="{{route('creditos.index')}}">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="spaMenu">Creditos</span>
                    </a>
                </li>
            @endif
            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ACTIVIDAD','VIP_ACTIVIDAD','VER_PARTICIPANTES','VIP_EVIDENCIA','VER_EVIDENCIA']))
                <li class="botMen">

                    <a class="etMenu" href="" data-parent="">
                        <i class="fa fa-fw fa-list-ul"></i>
                        <span class="spaMenu">Actividades</span>
                        <i class="fa fa-chevron-right flesub"></i>
                    </a>
                    <ul class="subMenu" >
                        @if (Auth::User()->can('VIP')|| Auth::User()->can('VER_ACTIVIDAD') || Auth::User()->can('VIP_ACTIVIDAD') || Auth::User()->can('VIP_SOLO_LECTURA'))
                            <li class='tamSubMenu'>
                                <a class="etSubMenu" href="{{route('actividades.index')}}">
                                    <i class="fa fa-futbol-o"></i>
                                    <span class="etSubMenu">Crear Actividad</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']))
                            <li class='tamSubMenu'>
                                <a class="etSubMenu" href="{{route('participantes.index')}}">
                                    <i class="fa fa-users"></i>
                                    <span class="etSubMenu">Agregar participantes</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA') || Auth::User()->can('VER_EVIDENCIA') || Auth::User()->can('VIP_SOLO_LECTURA'))
                        <li class='tamSubMenu'>
                                <a class="etSubMenu" href="{{route('evidencias.index')}}">
                                    <i class="fa fa-camera"></i>
                                    <span class="etSubMenu">Evidencia</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            
            <li class="botMen">
                <a class="etMenu" href="" data-parent="">
                    <i class="fa fa-pie-chart"></i>
                    <span class="spaMenu">Avances</span>
                    <i class="fa fa-chevron-right flesub"></i>
                </a>
                <ul class="subMenu" id="">
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                        <li class='tamSubMenu'>
                            <a class="etSubMenu" href="{{ route('verifica_evidencia.avance_alumno') }}">
                                <i class="fa fa-bar-chart-o"></i>
                                <span class="etSubMenu">Avance</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                        <li class='tamSubMenu'>
                            <a class="etSubMenu" href="{{ route('verifica_evidencia.index') }}">
                                <i class="fa fa-calendar-check-o"></i>
                                <span class="etSubMenu">Verificar evidencia</span>
                            </a>
                        </li>
                    @endif
                    
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('constancias.index') }}">
                            <i class="fa fa-print"></i>
                            <span class="etSubMenu">Constancias</span>
                        </a>
                    </li>
                    @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA']))
                        <li class='tamSubMenu'>
                            <a class="etSubMenu" href="{{ route('verifica_evidencia.reportes') }}">
                                <i class="fa fa-file-pdf-o"></i>
                                <span class="etSubMenu">Reportes</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES','VER_USUARIOS']))
                <li class="botMen">
                    <a class="etMenu"  href="#">
                        <i class="fa fa-lock"></i>
                        <span class="spaMenu">Administración</span>
                        <i class="fa fa-chevron-right flesub"></i>
                    </a>
                    <ul class="subMenu" id="">
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                            <li class='tamSubMenu'>
                                <a class="etSubMenu" href="{{ route('usuarios.index') }}">
                                    <i class="fa fa-users"></i>
                                    <span class="etSubMenu">Usuarios</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                            <li class='tamSubMenu'>
                                <a class="etSubMenu" href="{{ route('roles.index') }}">
                                    <i class="fa fa-address-card"></i>
                                    <span class="etSubMenu">Roles</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        @endif
        @if (Auth::guard('alumno')->check())
            <li class="botMen">http://127.0.0.1:8000/login
                <a class="etMenu" href="{{ route('alumnos.actividades') }}">
                    <i class="fa fa-fw fa-list-ul"></i>
                    <span class="spaMenu">Actividades</span>
                </a>
            </li>
            <li class="botMen">
                <a class="etMenu" href="{{ route('alumnos.avance') }}">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="spaMenu">Avance</span>
                </a>
            </li>
            
        @endif
        <li class="botMen">
            <a class="etMenu" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-sign-out"></i>
                <span class="spaMenu">Cerrar sesión </span>
            </a>
            <!-- Creamos el formulario en orden para poder cerrar sesion -->
            @if (Auth::guard('web')->check())
                <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <form id="logout-form" action="{{ route('alumnos.logout')}}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
            
        </li>
    </ul>
</nav>

