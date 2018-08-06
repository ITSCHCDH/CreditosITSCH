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
            <li class="botMen">
                <a class="etMenu" href="{{route('alumnos.index')}}">
                    <i class="fa fa-graduation-cap"></i>
                    <span class="spaMenu">Alumnos</span>
                </a>
            </li>
            @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA'))
                <li class="botMen">
                    <a class="etMenu" href="{{route('creditos.index')}}">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="spaMenu">Creditos</span>
                    </a>
                </li>
            @endif
            <li class="botMen" >
                <a class="etMenu" href="" data-parent="">
                    <i class="fa fa-fw fa-list-ul"></i>
                    <span class="spaMenu">Actividades</span>
                    <i class="fa fa-chevron-right flesub"></i>
                </a>
                <ul class="subMenu" >
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{route('actividades.index')}}">
                            <i class="fa fa-futbol-o"></i>
                            <span class="etSubMenu">Crear Actividad</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{route('participantes.index')}}">
                            <i class="fa fa-users"></i>
                            <span class="etSubMenu">Agregar participantes</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{route('evidencias.index')}}">
                            <i class="fa fa-camera"></i>
                            <span class="etSubMenu">Evidencia</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="botMen">
                <a class="etMenu" href="" data-parent="">
                    <i class="fa fa-pie-chart"></i>
                    <span class="spaMenu">Avances</span>
                    <i class="fa fa-chevron-right flesub"></i>
                </a>
                <ul class="subMenu" id="">
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('verifica_evidencia.avance_alumno') }}">
                            <i class="fa fa-bar-chart-o"></i>
                            <span class="etSubMenu">Avance</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('verifica_evidencia.index') }}">
                            <i class="fa fa-calendar-check-o"></i>
                            <span class="etSubMenu">Verificar evidencia</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('constancias.index') }}">
                            <i class="fa fa-print"></i>
                            <span class="etSubMenu">Constancias</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('verifica_evidencia.reportes') }}">
                            <i class="fa fa-file-pdf-o"></i>
                            <span class="etSubMenu">Reportes</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="botMen">
                <a class="etMenu"  href="#">
                    <i class="fa fa-lock"></i>
                    <span class="spaMenu">Administración</span>
                    <i class="fa fa-chevron-right flesub"></i>
                </a>
                <ul class="subMenu" id="">
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('usuarios.index') }}">
                            <i class="fa fa-users"></i>
                            <span class="etSubMenu">Usuarios</span>
                        </a>
                    </li>
                    <li class='tamSubMenu'>
                        <a class="etSubMenu" href="{{ route('roles.index') }}">
                            <i class="fa fa-address-card"></i>
                            <span class="etSubMenu">Roles</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif
        @if (Auth::guard('alumno')->check())
            <li class="botMen">
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

