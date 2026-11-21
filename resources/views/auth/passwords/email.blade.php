<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña | ITSCH</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.3.0/css/mdb.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <style>
        body { min-height:100vh; margin:0; font-family:"Roboto","Segoe UI",sans-serif; background:linear-gradient(135deg,#eef3f8,#f8fafc); }
        .password-page { min-height:100vh; display:grid; place-items:center; padding:1.25rem; }
        .password-card { width:min(100%,920px); min-height:540px; overflow:hidden; border:0; border-radius:1.5rem; box-shadow:0 1.5rem 4rem rgba(16,43,74,.16); }
        .password-brand { min-height:540px; display:flex; flex-direction:column; justify-content:space-between; padding:2.5rem; color:#fff; background:linear-gradient(145deg,#173c66,#102b4a); }
        .password-logo { width:112px; height:112px; object-fit:contain; padding:.75rem; border-radius:1.25rem; background:#fff; }
        .password-brand h1 { max-width:10ch; margin:.5rem 0 1rem; font-size:2.25rem; line-height:1.1; }
        .password-brand p { color:rgba(255,255,255,.75); line-height:1.6; }
        .password-form-panel { min-height:540px; display:flex; align-items:center; padding:clamp(2rem,5vw,3.5rem); background:#fff; }
        .password-form { width:100%; }
        .password-form h2 { color:#102b4a; font-size:1.9rem; font-weight:700; }
        .password-form .subtitle { margin-bottom:1.75rem; color:#6b7280; }
        .password-form .form-control { min-height:3.5rem; border-radius:.75rem; }
        .password-submit { min-height:3.5rem; border-radius:.75rem; color:#fff!important; font-weight:700; background:#173c66; }
        .password-submit:hover,.password-submit:focus { background:#102b4a; color:#fff!important; }
        @media(max-width:767px){ .password-page{padding:0}.password-card{min-height:100vh;border-radius:0}.password-brand{min-height:220px;padding:1.5rem}.password-logo{width:68px;height:68px}.password-brand h1{font-size:1.5rem}.password-brand p{display:none}.password-form-panel{min-height:calc(100vh - 220px);padding:1.75rem 1.25rem} }
    </style>
</head>
<body>
@include('sweetalert::alert')
<main class="password-page">
    <div class="card password-card">
        <div class="row g-0 h-100">
            <aside class="col-md-5 password-brand">
                <img class="password-logo" src="{{ asset('images/itsch.jpg') }}" alt="ITSCH">
                <div>
                    <span class="text-warning small fw-bold text-uppercase">Cuenta ITSCH</span>
                    <h1>Recupera tu acceso</h1>
                    <p>Solicita un enlace seguro para actualizar tu contraseña administrativa.</p>
                </div>
            </aside>
            <section class="col-md-7 password-form-panel">
                <form method="POST" action="{{ route('perfil.password_reset_link') }}" class="password-form">
                    @csrf
                    <h2>¿Olvidaste tu contraseña?</h2>
                    <p class="subtitle">Ingresa el correo asociado a tu cuenta.</p>
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <div class="form-outline mb-4" data-mdb-input-init>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" autocomplete="email" required>
                        <label class="form-label" for="email">Correo electrónico</label>
                    </div>
                    <button type="submit" class="btn password-submit w-100">
                        <i class="fa-solid fa-paper-plane me-2"></i>Enviar enlace
                    </button>
                    <div class="text-center mt-4">
                        <a class="text-decoration-none" href="{{ route('login') }}">Volver al inicio de sesión</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@9.3.0/js/mdb.umd.min.js"></script>
</body>
</html>
