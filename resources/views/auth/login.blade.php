<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | ITSCH</title>

    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.3.0/css/mdb.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --itsch-blue: #173c66;
            --itsch-blue-dark: #102b4a;
            --itsch-gold: #c79a2b;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Roboto", "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 15% 15%, rgba(199, 154, 43, 0.13), transparent 26rem),
                linear-gradient(135deg, #eef3f8 0%, #f8fafc 100%);
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.25rem;
        }

        .login-card {
            width: min(100%, 980px);
            min-height: 620px;
            overflow: hidden;
            border: 0;
            border-radius: 1.5rem;
            box-shadow: 0 1.5rem 4rem rgba(16, 43, 74, 0.16);
        }

        .login-brand {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 620px;
            padding: 3.25rem;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(23, 60, 102, 0.96), rgba(10, 34, 61, 0.98)),
                var(--itsch-blue);
        }

        .login-brand::after {
            content: "";
            position: absolute;
            right: -7rem;
            bottom: -7rem;
            width: 18rem;
            height: 18rem;
            border: 3.25rem solid rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .brand-logo {
            width: 112px;
            height: 112px;
            object-fit: contain;
            padding: 0.75rem;
            border-radius: 1.25rem;
            background: #fff;
            box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.18);
        }

        .brand-eyebrow {
            color: #efd58a;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
        }

        .brand-copy h1 {
            max-width: 8ch;
            margin: 0.75rem 0 1rem;
            font-size: clamp(2.25rem, 4vw, 3.75rem);
            line-height: 0.98;
            font-weight: 700;
        }

        .brand-copy p {
            max-width: 24rem;
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.65;
        }

        .login-form-panel {
            display: flex;
            align-items: center;
            min-height: 620px;
            padding: clamp(2rem, 6vw, 4.5rem);
            background: #fff;
        }

        .login-form {
            width: 100%;
        }

        .login-form h2 {
            margin-bottom: 0.5rem;
            color: var(--itsch-blue-dark);
            font-size: clamp(1.75rem, 3vw, 2.25rem);
            font-weight: 700;
        }

        .login-form .subtitle {
            margin-bottom: 2.25rem;
            color: #6b7280;
        }

        .form-outline .form-control {
            min-height: 3.5rem;
            border-radius: 0.75rem;
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            z-index: 3;
            width: 2.75rem;
            height: 2.75rem;
            transform: translateY(-50%);
            border: 0;
            border-radius: 50%;
            color: #64748b;
            background: transparent;
        }

        .password-toggle:hover,
        .password-toggle:focus-visible {
            color: var(--itsch-blue);
            background: #eef3f8;
            outline: none;
        }

        .password-field .form-control {
            padding-right: 3.75rem;
        }

        .login-button {
            min-height: 3.25rem;
            margin-top: 0.25rem;
            border-radius: 0.75rem;
            background: var(--itsch-blue);
            box-shadow: 0 0.75rem 1.5rem rgba(23, 60, 102, 0.2);
            font-weight: 700;
            text-transform: none;
        }

        .login-button:hover,
        .login-button:focus {
            background: var(--itsch-blue-dark);
        }

        .recovery-link {
            color: var(--itsch-blue);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .recovery-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 767px) {
            .login-page {
                align-items: start;
                padding: 0;
            }

            .login-card {
                min-height: 100vh;
                border-radius: 0;
            }

            .login-brand {
                min-height: 260px;
                padding: 2rem;
            }

            .brand-logo {
                width: 76px;
                height: 76px;
            }

            .brand-copy h1 {
                max-width: none;
                font-size: 2.25rem;
            }

            .brand-copy p {
                display: none;
            }

            .login-form-panel {
                min-height: calc(100vh - 260px);
                padding: 2.25rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('sweetalert::alert')

    <main class="login-page">
        <div class="card login-card">
            <div class="row g-0 h-100">
                <aside class="col-md-5 login-brand">
                    <img src="{{ asset('images/itsch.jpg') }}" class="brand-logo" alt="Instituto Tecnológico Superior de Huetamo">

                    <div class="brand-copy">
                        <span class="brand-eyebrow">Instituto Tecnológico Superior de Huetamo</span>
                        <h1>Tu trayectoria académica</h1>
                        <p>Consulta tus actividades, avances y servicios institucionales desde un solo acceso.</p>
                    </div>
                </aside>

                <section class="col-md-7 login-form-panel" aria-labelledby="login-title">
                    <form method="POST" action="{{ url('/login') }}" class="login-form" id="frm_login">
                        @csrf

                        <h2 id="login-title">Iniciar sesión</h2>
                        <p class="subtitle">Ingresa con tu correo institucional o de cuenta.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="form-outline mb-4" data-mdb-input-init>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                autocomplete="email"
                                required
                                autofocus
                            >
                            <label class="form-label" for="email">Correo electrónico</label>
                        </div>

                        <div class="form-outline password-field mb-4" data-mdb-input-init>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >
                            <label class="form-label" for="password">Contraseña</label>
                            <button type="button" class="password-toggle" id="password-toggle" aria-label="Mostrar contraseña" title="Mostrar contraseña">
                                <i class="fa-solid fa-eye-slash" id="password-icon" aria-hidden="true"></i>
                            </button>
                        </div>

                        <button class="btn login-button w-100" type="submit">
                            Entrar al sistema
                        </button>

                        <div class="text-center mt-4">
                            <a class="recovery-link" href="{{ route('perfil.password_mail') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.3.0/js/mdb.umd.min.js"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('password-toggle');
        const passwordIcon = document.getElementById('password-icon');

        passwordToggle.addEventListener('click', function () {
            const visible = passwordInput.type === 'text';
            passwordInput.type = visible ? 'password' : 'text';
            passwordIcon.className = visible ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            passwordToggle.setAttribute('aria-label', visible ? 'Mostrar contraseña' : 'Ocultar contraseña');
            passwordToggle.setAttribute('title', visible ? 'Mostrar contraseña' : 'Ocultar contraseña');
        });
    </script>
</body>
</html>
