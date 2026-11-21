<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Creditsch|@yield('title','Default')</title>
        <link rel="icon" href="{{ asset('images/itsch.ico') }}">
        <meta name="description" content="Este es el sistema de administración de créditos complementarios del TECNM Campus Ciudad Hidalgo, que permite el control del avance de los créditos de cada estudiante.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
        
        <!-- Bootstrap 5 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">

        <!-- DataTables para Bootstrap 4 -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
       
        {{-- MDBootstrap --}}
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}"/>
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
        <!-- MDB -->
        <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}" />
        {{-- Estilos sta --}}
        <link rel="stylesheet" href="{{ asset('css/sta/estilos.css') }}" />
        <!-- Incluir SweetAlert2 CSS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            .error {
                border: 1px solid red;
            }
            body {
                min-height: 100vh;
            }
            .system-footer {
                border-top: 1px solid rgba(255, 255, 255, .08);
                background: linear-gradient(135deg, #102b4a 0%, #173c66 100%);
                color: rgba(255, 255, 255, .86);
            }
            .system-footer-inner {
                min-height: 132px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1.5rem;
                padding-top: 1.25rem;
                padding-bottom: 1.25rem;
            }
            .system-footer-brand {
                display: flex;
                align-items: center;
                gap: .75rem;
            }
            .system-footer-logo {
                width: 52px;
                height: 52px;
                padding: .2rem;
                border-radius: .65rem;
                background: #fff;
                object-fit: contain;
            }
            .system-footer-brand strong {
                font-size: 1.05rem;
            }
            .system-footer-brand strong,
            .system-footer-brand span {
                display: block;
            }
            .system-footer-brand span {
                color: rgba(255, 255, 255, .62);
                font-size: .82rem;
            }
            .update-monitor {
                min-width: 265px;
                display: flex;
                align-items: center;
                gap: .75rem;
                padding: .65rem .85rem;
                border: 1px solid rgba(255, 255, 255, .11);
                border-radius: .85rem;
                background: rgba(255, 255, 255, .07);
            }
            .update-monitor-icon {
                width: 38px;
                height: 38px;
                display: grid;
                place-items: center;
                flex: 0 0 auto;
                border-radius: 50%;
                color: #b8f2c9;
                background: rgba(74, 222, 128, .12);
            }
            .update-monitor-copy {
                min-width: 0;
            }
            .update-monitor-copy strong,
            .update-monitor-copy span {
                display: block;
            }
            .update-monitor-copy strong {
                color: #fff;
                font-size: .88rem;
            }
            .update-monitor-copy span {
                overflow: hidden;
                color: rgba(255, 255, 255, .68);
                font-size: .78rem;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .update-status-dot {
                width: 8px;
                height: 8px;
                flex: 0 0 auto;
                border-radius: 50%;
                background: #4ade80;
                box-shadow: 0 0 0 .25rem rgba(74, 222, 128, .12);
            }
            .footer-social {
                display: flex;
                align-items: center;
                gap: .65rem;
            }
            .footer-social-label {
                color: rgba(255, 255, 255, .68);
                font-size: .82rem;
            }
            .footer-social-link {
                width: 42px;
                height: 42px;
                display: grid;
                place-items: center;
                border: 1px solid rgba(255, 255, 255, .14);
                border-radius: 50%;
                color: #fff;
                background: rgba(255, 255, 255, .07);
                text-decoration: none;
                transition: .18s ease;
            }
            .footer-social-link:hover,
            .footer-social-link:focus {
                color: #102b4a;
                background: #fff;
                transform: translateY(-2px);
            }
            .messages-toolbar {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
            }
            .messages-toolbar h1 {
                margin: 0;
                color: #102b4a;
                font-size: clamp(1.5rem, 3vw, 2.1rem);
                font-weight: 700;
            }
            .messages-toolbar p {
                margin: .35rem 0 0;
                color: #6b7280;
            }
            .message-actions {
                display: flex;
                gap: .55rem;
                flex-wrap: wrap;
            }
            .message-actions .btn {
                border-radius: .75rem;
            }
            .message-panel {
                border: 1px solid #e7edf4;
                border-radius: 1.1rem;
                background: #fff;
                overflow: hidden;
                box-shadow:
                    0 1rem 2.25rem rgba(29, 78, 116, .12),
                    0 .25rem .65rem rgba(16, 43, 74, .07);
            }
            .message-panel table {
                margin: 0;
            }
            .message-panel tbody tr.unread {
                background: #f5f9fd;
            }
            .message-panel tbody tr.unread td {
                font-weight: 600;
                color: #102b4a;
            }
            .message-sender {
                display: flex;
                align-items: center;
                gap: .65rem;
            }
            .message-avatar {
                width: 38px;
                height: 38px;
                display: grid;
                place-items: center;
                flex: 0 0 auto;
                border-radius: .7rem;
                color: #173c66;
                background: #edf3f8;
            }
            .message-status {
                width: 9px;
                height: 9px;
                display: inline-block;
                border-radius: 50%;
                background: #cbd5e1;
            }
            .message-status.unread {
                background: #2563a8;
                box-shadow: 0 0 0 .18rem rgba(37, 99, 168, .12);
            }
            .message-breadcrumb-card,
            .message-control-card {
                border: 1px solid #e7edf4;
                border-radius: 1rem;
                background: #fff;
                box-shadow:
                    0 .75rem 1.5rem rgba(29, 78, 116, .10),
                    0 .18rem .45rem rgba(16, 43, 74, .06);
            }
            .message-breadcrumb-card {
                display: flex;
                align-items: center;
                gap: .65rem;
                min-height: 64px;
                margin-bottom: .75rem;
                padding: .8rem 1rem;
                color: #64748b;
            }
            .message-breadcrumb-card i {
                width: 38px;
                height: 38px;
                display: grid;
                place-items: center;
                flex: 0 0 auto;
                border-radius: .7rem;
                color: #173c66;
                background: #edf3f8;
            }
            .message-breadcrumb-card strong {
                color: #102b4a;
            }
            .message-control-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
                padding: .8rem 1rem;
            }
            .message-control-card h1 {
                margin: 0;
                color: #102b4a;
                font-size: 1.25rem;
                font-weight: 700;
            }
            .message-control-card p {
                margin: .2rem 0 0;
                color: #6b7280;
                font-size: .88rem;
            }
            @media (max-width: 767.98px) {
                .system-footer-inner {
                    align-items: flex-start;
                    flex-direction: column;
                    padding: 1rem 0;
                }
                .update-monitor {
                    width: 100%;
                    min-width: 0;
                }
                .footer-social {
                    width: 100%;
                }
                .messages-toolbar,
                .message-actions {
                    width: 100%;
                }
                .messages-toolbar {
                    align-items: flex-start;
                    flex-direction: column;
                }
                .message-control-card {
                    align-items: flex-start;
                    flex-direction: column;
                }
                .message-actions .btn {
                    flex: 1;
                }
            }
        </style>

        @yield('links')
        @stack('styles')
    </head>
    <body>
        <!--Main Navigation-->
        <header>
           @include('template.partes.menu')
        </header>

        <!--Section: Content-->
        <section class="text-center text-md-start">

            @include('sweetalert::alert')
            <div class="row">
                <div class="d-none d-lg-block col-lg-1"></div>
                <div class="col-12 col-lg-10 px-3 px-md-4" style="margin-bottom: 200px;">
                    <p></p>
                    @hasSection('ruta')
                        <h3 class="mb-4">@yield('ruta')</h3>
                    @endif
                    @yield('contenido','Default')<!-- Contenido general del sistema -->
                </div>
                <div class="d-none d-lg-block col-lg-1"></div>
            </div>
        </section>
        <!--Section: Content-->

        <footer class="system-footer">
            <div class="container system-footer-inner">
                <div class="system-footer-brand">
                    <img class="system-footer-logo" src="{{ asset('images/itsch.jpg') }}" alt="ITSCH" loading="lazy">
                    <div>
                        <strong>Creditsch · ITSCH</strong>
                        <span>Créditos complementarios y trayectoria académica</span>
                    </div>
                </div>

                <div class="footer-social" aria-label="Redes del creador">
                    <span class="footer-social-label">Creador</span>
                    <a class="footer-social-link"
                       href="https://www.facebook.com/profile.php?id=100057428089409"
                       target="_blank" rel="noopener noreferrer"
                       title="Facebook" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a class="footer-social-link"
                       href="https://www.linkedin.com/in/oscar-delgado-camacho-68bab2114/"
                       target="_blank" rel="noopener noreferrer"
                       title="LinkedIn" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a class="footer-social-link"
                       href="https://github.com/kioselsa"
                       target="_blank" rel="noopener noreferrer"
                       title="GitHub" aria-label="GitHub">
                        <i class="fa-brands fa-github" aria-hidden="true"></i>
                    </a>
                    <a class="footer-social-link"
                       href="https://kioselsar.com"
                       target="_blank" rel="noopener noreferrer"
                       title="Sitio web" aria-label="Sitio web">
                        <i class="fa-solid fa-globe" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="update-monitor" id="update-monitor"
                     title="{{ $systemUpdate['message'] ?? 'Actualización del sistema' }}">
                    <div class="update-monitor-icon">
                        <i class="fa-solid fa-code-branch" aria-hidden="true"></i>
                    </div>
                    <div class="update-monitor-copy">
                        <strong>Última actualización</strong>
                        <span id="update-monitor-date">
                            @if($systemUpdate['date'])
                                {{ $systemUpdate['date']->translatedFormat('d M Y · h:i A') }}
                            @else
                                Información no disponible
                            @endif
                            @if($systemUpdate['short_hash'] && $systemUpdate['short_hash'] !== 'Sin datos')
                                · {{ $systemUpdate['short_hash'] }}
                            @endif
                        </span>
                    </div>
                    <span class="update-status-dot" aria-label="Sistema actualizado"></span>
                </div>
            </div>
        </footer>


        <!-- Scripts Section -->
        <script type="text/javascript"> const ASSET_URL = "{{ asset('/') }}" </script>

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        {{-- CDN sweetalert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        {{-- Scripts para datatable y para pdfmaker --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        
       
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap 5 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>

              {{-- Librerías REQUERIDAS para los botones --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

        {{-- DataTables Core --}}
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        {{-- DataTables Buttons --}}
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

        {{-- DataTables Responsive --}}
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

        <!-- MDB -->
        <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>

        <!-- Scripts de la aplicacion -->
        <script type="text/javascript" src="{{ asset('js/utilidades.js') }}"></script>

        <script>
            (function () {
                const monitor = document.getElementById('update-monitor');
                const dateLabel = document.getElementById('update-monitor-date');
                if (!monitor || !dateLabel) return;

                async function refreshSystemUpdate() {
                    try {
                        const response = await fetch('{{ route('system.update-status') }}', {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!response.ok) return;

                        const update = await response.json();
                        monitor.title = update.message || 'Actualización del sistema';

                        if (update.date) {
                            const date = new Intl.DateTimeFormat('es-MX', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }).format(new Date(update.date));
                            dateLabel.textContent = date + (update.short_hash ? ' · ' + update.short_hash : '');
                        }
                    } catch (error) {
                        monitor.classList.add('update-monitor-offline');
                    }
                }

                refreshSystemUpdate();
                window.setInterval(refreshSystemUpdate, 60000);
            })();
        </script>

        @yield('js')

    </body>
</html>
