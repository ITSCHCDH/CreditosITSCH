<style>
    .system-navbar {
        min-height: 68px;
        padding: .55rem 1.25rem;
        background: linear-gradient(135deg, #102b4a 0%, #173c66 72%, #1f4f7d 100%) !important;
        box-shadow: 0 .5rem 1.5rem rgba(16, 43, 74, .22);
    }
    .system-navbar .navbar-brand {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-right: 1.25rem;
        font-weight: 700;
        letter-spacing: .02em;
    }
    .system-navbar .brand-mark {
        width: 38px;
        height: 38px;
        padding: .2rem;
        border-radius: .65rem;
        background: #fff;
        object-fit: contain;
    }
    .system-navbar .nav-link {
        display: flex;
        align-items: center;
        gap: .45rem;
        min-height: 42px;
        margin: 0 .08rem;
        padding: .55rem .75rem !important;
        border-radius: .65rem;
        color: rgba(255, 255, 255, .86) !important;
        font-weight: 500;
        transition: .18s ease;
    }
    .system-navbar .nav-link i {
        width: 18px;
        text-align: center;
    }
    .system-navbar .nav-link:hover,
    .system-navbar .nav-link:focus,
    .system-navbar .nav-item.active > .nav-link,
    .system-navbar .nav-item.show > .nav-link {
        color: #fff !important;
        background: rgba(255, 255, 255, .12);
    }
    .system-navbar .dropdown-menu {
        min-width: 245px;
        margin-top: .55rem;
        padding: .55rem;
        border: 1px solid rgba(16, 43, 74, .08);
        border-radius: .85rem;
        box-shadow: 0 .85rem 2.25rem rgba(16, 43, 74, .18);
    }
    .system-navbar .dropdown-item {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .65rem .75rem;
        border-radius: .55rem;
        color: #334155;
    }
    .system-navbar .dropdown-item i {
        width: 20px;
        color: #173c66;
        text-align: center;
    }
    .system-navbar .dropdown-item:hover,
    .system-navbar .dropdown-item:focus {
        color: #102b4a;
        background: #edf3f8;
    }
    .system-navbar .dropdown-divider {
        margin: .35rem .35rem;
    }
    .system-navbar .account-menu {
        margin-left: .75rem;
    }
    .system-navbar .account-toggle {
        max-width: 220px;
        background: rgba(255, 255, 255, .08);
    }
    .system-navbar .account-name {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .system-navbar .logout-item,
    .system-navbar .logout-item i {
        color: #b42318;
    }
    @media (max-width: 991.98px) {
        .system-navbar { padding: .6rem 1rem; }
        .system-navbar .container-fluid {
            flex-wrap: nowrap;
        }
        .system-navbar .navbar-collapse {
            margin-top: .75rem;
            padding: .75rem;
            border-radius: .85rem;
            background: rgba(8, 29, 52, .55);
            max-height: calc(100vh - 92px);
            overflow-y: auto;
            overscroll-behavior: contain;
        }
        .system-navbar .account-menu {
            margin: .5rem 0 0;
        }
        .system-navbar .account-toggle {
            max-width: none;
        }
        .system-navbar .dropdown-menu {
            width: 100%;
            min-width: 0;
            border: 0;
            box-shadow: none;
            background: rgba(255, 255, 255, .97);
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark system-navbar" aria-label="Navegación principal">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ Auth::guard('alumno')->check() ? route('alumnos.home_avance') : url('/home') }}">
            <img class="brand-mark" src="{{ asset('images/itsch.jpg') }}" alt="ITSCH" loading="lazy">
            <span class="d-none d-sm-inline">STA</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#systemNavbar" aria-controls="systemNavbar"
                aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="systemNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (Auth::guard('alumno')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumnos.home_avance') }}">
                            <i class="fa-solid fa-house"></i><span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumnos.sta.ficha', 1) }}">
                            <i class="fa-solid fa-id-card"></i><span>Ficha</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paciente.alumno.index.citas') }}">
                            <i class="fa-solid fa-calendar-check"></i><span>Mis citas</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/home') }}">
                            <i class="fa-solid fa-house"></i><span>Inicio</span>
                        </a>
                    </li>
                @endif

                @if (Auth::guard('web')->check())
                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ACTIVIDAD','VIP_ACTIVIDAD','VER_PARTICIPANTES','VIP_EVIDENCIA','VER_EVIDENCIA']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuActividades"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-layer-group"></i><span>Actividades</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuActividades">
                                @if (Auth::User()->can('VIP') || Auth::User()->can('VER_ACTIVIDAD') || Auth::User()->can('VIP_ACTIVIDAD') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                    <li><a class="dropdown-item" href="{{ route('actividades.index') }}"><i class="fa-solid fa-sliders"></i>Administrar actividades</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']))
                                    <li><a class="dropdown-item" href="{{ route('participantes.index') }}"><i class="fa-solid fa-user-plus"></i>Agregar participantes</a></li>
                                @endif
                                @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_EVIDENCIA') || Auth::User()->can('VER_EVIDENCIA') || Auth::User()->can('VIP_SOLO_LECTURA'))
                                    <li><a class="dropdown-item" href="{{ route('evidencias.index') }}"><i class="fa-solid fa-file-image"></i>Evidencias</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA']))
                                    <li><a class="dropdown-item" href="{{ route('verifica_evidencia.index') }}"><i class="fa-solid fa-circle-check"></i>Verificar evidencia</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_AVANCE_ALUMNO','VER_AVANCE_ALUMNO','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VERIFICAR_EVIDENCIA','VER_REPORTES_CARRERA','VIP_REPORTES']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuAvance"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-chart-line"></i><span>Avance</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuAvance">
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_AVANCE_ALUMNO']))
                                    <li><a class="dropdown-item" href="{{ route('verifica_evidencia.avance_alumno') }}"><i class="fa-solid fa-chart-column"></i>Avance</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VER_REPORTES_CARRERA','VIP_REPORTES','VIP_SOLO_LECTURA','VIP']))
                                    <li><a class="dropdown-item" href="{{ route('verifica_evidencia.reportes') }}"><i class="fa-solid fa-chart-pie"></i>Reportes</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::User()->hasAnyPermission(['VIP','VIP_STA','STA_COR_CARRERA','STA_PROFESOR','STA_TUTOR','STA_DEP_TUTORIA']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuSta"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-graduation-cap"></i><span>STA</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuSta">
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_COR_CARRERA') || Auth::User()->can('VIP'))
                                    <li><a class="dropdown-item" href="{{ route('analisis.index') }}"><i class="fa-solid fa-building-columns"></i>Jefes de carrera</a></li>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_PROFESOR') || Auth::User()->can('VIP'))
                                    <li><a class="dropdown-item" href="{{ route('profesores.index') }}"><i class="fa-solid fa-chalkboard-user"></i>Profesor</a></li>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_TUTOR') || Auth::User()->can('VIP'))
                                    <li><a class="dropdown-item" href="{{ route('tutores.index') }}"><i class="fa-solid fa-user-tie"></i>Tutor</a></li>
                                @endif
                                @if (Auth::User()->can('VIP_STA') || Auth::User()->can('STA_DEP_TUTORIA') || Auth::User()->can('VIP'))
                                    <li><a class="dropdown-item" href="{{ route('tutorias.index') }}"><i class="fa-solid fa-users-gear"></i>Departamento de tutorías</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::User()->hasAnyPermission(['VIP','VER_CITAS_MEDICAS','MODIFICAR_CITAS_MEDICAS']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuMedico"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-notes-medical"></i><span>Médico</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuMedico">
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_MEDICO']))
                                    <li><a class="dropdown-item" href="{{ route('medico.index') }}"><i class="fa-solid fa-calendar-days"></i>Agenda médica</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','CREAR_CITAS_MEDICAS']))
                                    <li><a class="dropdown-item" href="{{ route('paciente.index.citas') }}"><i class="fa-solid fa-calendar-check"></i>Mis citas</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::User()->hasAnyPermission(['VIP','VER_USUARIOS']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuAdministracion"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gears"></i><span>Administración</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="menuAdministracion">
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_AREAS','VIP_SOLO_LECTURA']))
                                    <li><a class="dropdown-item" href="{{ route('areas.inicio') }}"><i class="fa-solid fa-sitemap"></i>Áreas</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_CONSTANCIAS','MODIFICAR_CONSTANCIAS_CARRERA']))
                                    <li><a class="dropdown-item" href="{{ route('constancias.index') }}"><i class="fa-solid fa-certificate"></i>Constancias</a></li>
                                @endif
                                @if (Auth::User()->can('VIP') || Auth::User()->can('VIP_SOLO_LECTURA') || Auth::User()->can('VER_CREDITOS'))
                                    <li><a class="dropdown-item" href="{{ route('creditos.index') }}"><i class="fa-solid fa-award"></i>Créditos</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                @if (Auth::User()->hasAnyPermission(['VIP','VER_ALUMNOS','VIP_SOLO_LECTURA']))
                                    <li><a class="dropdown-item" href="{{ route('alumnos.index') }}"><i class="fa-solid fa-user-graduate"></i>Alumnos</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA']))
                                    <li><a class="dropdown-item" href="{{ route('ImportExcel.index') }}"><i class="fa-solid fa-key"></i>Modificar contraseñas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('ImportExcel.altaAlumnos') }}"><i class="fa-solid fa-file-excel"></i>Insertar alumnos</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS','VER_AREAS','VER_ALUMNOS']))
                                    <li><a class="dropdown-item" href="{{ route('alumnos.bajas.view') }}"><i class="fa-solid fa-user-minus"></i>Bajas de alumnos</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_USUARIOS']))
                                    <li><a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users"></i>Usuarios</a></li>
                                @endif
                                @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VER_ROLES']))
                                    <li><a class="dropdown-item" href="{{ route('roles.index') }}"><i class="fa-solid fa-shield-halved"></i>Roles</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav account-menu">
                <li class="nav-item dropdown">
                    @if (Auth::guard('alumno')->check())
                        @php $nombreCuenta = Auth::guard('alumno')->user()->nombreCompleto ?? Auth::guard('alumno')->user()->nombre; @endphp
                        <a class="nav-link dropdown-toggle account-toggle" href="#" id="menuCuentaAlumno"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>
                            <span class="account-name">{{ $nombreCuenta }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuCuentaAlumno">
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-item">
                                        <i class="fa-solid fa-right-from-bracket"></i>Salir
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @elseif (Auth::guard('web')->check())
                        <a class="nav-link dropdown-toggle account-toggle" href="#" id="menuCuentaUsuario"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>
                            <span class="account-name">{{ Auth::User()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuCuentaUsuario">
                            <li><a class="dropdown-item" href="{{ route('perfil.index') }}"><i class="fa-solid fa-user-pen"></i>Mi perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-item">
                                        <i class="fa-solid fa-right-from-bracket"></i>Salir
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
