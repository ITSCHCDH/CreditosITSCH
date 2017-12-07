<!-- Menu del sistema -->
<nav class="menu">
    <ul>
        <li class="botMen">
            <a class="etMenu" href="/home">
                <i class="fa fa-home"></i>
                <span class="spaMenu">Inicio</span>
            </a>
        </li>
        <li class="botMen">
            <a class="etMenu" href="{{route('alumnos.index')}}">
                <i class="fa fa-graduation-cap"></i>
                <span class="spaMenu">Alumnos</span>
            </a>
        </li>
        <li class="botMen">
            <a class="etMenu" href="{{route('creditos.index')}}">
                <i class="fa fa-fw fa-table"></i>
                <span class="spaMenu">Creditos</span>
            </a>
        </li>
        <li class="botMen" >
            <a class="etMenu" href="" data-parent="">
                <i class="fa fa-fw fa-wrench"></i>
                <span class="spaMenu">Actividades</span>
                <i class="fa fa-chevron-right flesub"></i>
            </a>
            <ul class="subMenu" >
                <li>
                    <a class="etSubMenu" href="{{route('actividades.index')}}">
                        <i class="fa fa-futbol-o"></i>
                        <span class="etSubMenu">Crear Actividad</span>
                    </a>
                </li>
                <li>
                    <a class="etSubMenu" href="{{route('participantes.index')}}">
                        <i class="fa fa-users"></i>
                        <span class="etSubMenu">Agregar participantes</span>
                    </a>
                </li>
                <li>
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
                <span class="spaMenu">Avance</span>
                <i class="fa fa-chevron-right flesub"></i>
            </a>
            <ul class="subMenu" id="">
                <li>
                    <a class="etSubMenu" href="#">
                        <i class="fa fa-calendar-check-o"></i>
                        <span class="etSubMenu">Verificar evidencia</span>
                    </a>
                </li>
                <li>
                    <a class="etSubMenu" href="#">
                        <i class="fa fa-print"></i>
                        <span class="etSubMenu">Constancias</span>
                    </a>
                </li>
                <li>
                    <a class="etSubMenu" href="#">
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
                <li>
                    <a class="etSubMenu" href="#">
                        <i class="fa fa-users"></i>
                        <span class="etSubMenu">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a class="etSubMenu" href="#">
                        <i class="fa fa-address-card"></i>
                        <span class="etSubMenu">Roles</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="botMen">
            <a class="etMenu" href="#">
                <i class="fa fa-fw fa-sign-out"></i>
                <span class="spaMenu">Cerrar sesión </span>
            </a>
        </li>
    </ul>
</nav>

