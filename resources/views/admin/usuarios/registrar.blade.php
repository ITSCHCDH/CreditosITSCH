@extends('template.molde')

@section('title','Usuarios | Creación')

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-users" style="color:#2d6da3"></i>
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">Usuarios</a>
        <span class="text-muted">/</span>
        Creación
    </span>
@endsection

@push('styles')
<style>
    .nu-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .nu-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .nu-card-head h1{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .nu-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .nu-card-body{padding:1.25rem}
    .nu-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .nu-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .nu-pass{position:relative}
    .nu-pass .form-control{padding-right:2.75rem}
    .nu-pass .nu-pass-toggle{position:absolute;top:50%;right:.55rem;transform:translateY(-50%);border:0;background:transparent;color:#6b7280;padding:.35rem;line-height:1;border-radius:.4rem}
    .nu-pass .nu-pass-toggle:hover{color:#102b4a;background:#edf3f8}
    .nu-checks{display:flex;flex-wrap:wrap;gap:.5rem 1.25rem;margin-bottom:.35rem}
    .nu-checks .form-check{margin:0}
    @media(max-width:767.98px){
        .nu-card-body{padding:1rem}
    }
</style>
@endpush

@section('contenido')
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Revisá los datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usuarios.store') }}" id="formUsuario">
        @csrf

        <div class="row g-3">
            {{-- Datos personales --}}
            <div class="col-12 col-xl-6">
                <article class="nu-card h-100">
                    <div class="nu-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="nu-icon"><i class="fa-solid fa-id-card"></i></span>
                            <div>
                                <h1>Datos personales</h1>
                                <p>Nombre completo y correo institucional.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nu-card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="name" class="form-control" autofocus required maxlength="100" value="{{ old('name') }}" placeholder="Ej. Ana López">
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="usuario@itsch.edu.mx">
                        </div>
                    </div>
                </article>
            </div>

            {{-- Acceso --}}
            <div class="col-12 col-xl-6">
                <article class="nu-card h-100">
                    <div class="nu-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="nu-icon"><i class="fa-solid fa-key"></i></span>
                            <div>
                                <h1>Acceso</h1>
                                <p>Contraseña inicial del usuario.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nu-card-body">
                        <div class="mb-3 nu-pass">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" required minlength="4" maxlength="60" autocomplete="new-password">
                            <button type="button" class="nu-pass-toggle" data-target="password" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <div class="mb-0 nu-pass">
                            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="4" maxlength="60" autocomplete="new-password">
                            <button type="button" class="nu-pass-toggle" data-target="password_confirmation" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Entre 4 y 60 caracteres.</p>
                    </div>
                </article>
            </div>

            {{-- Área y estado --}}
            <div class="col-12">
                <article class="nu-card">
                    <div class="nu-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="nu-icon"><i class="fa-solid fa-building-columns"></i></span>
                            <div>
                                <h1>Área y estado</h1>
                                <p>Ubicación del usuario y permisos generales.</p>
                            </div>
                        </div>
                    </div>
                    <div class="nu-card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="area">Área</label>
                                <select id="area" name="area" class="form-select" required>
                                    @if ($areas->count() == 1)
                                        <option value="{{ $areas[0]->id }}" selected>{{ $areas[0]->nombre }}</option>
                                    @else
                                        <option value="" disabled selected>Seleccione un área</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" @selected(old('area') == $area->id)>{{ $area->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="sit_carrera_id">Carrera SIT</label>
                                <select id="sit_carrera_id" name="sit_carrera_id" class="form-select">
                                    <option value="">Sin carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" @selected(old('sit_carrera_id') == $carrera->id)>{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="active">Estado</label>
                                <select id="active" name="active" class="form-select" required>
                                    <option value="" disabled selected>¿El usuario está activo?</option>
                                    <option value="true" @selected(old('active') === 'true')>Sí</option>
                                    <option value="false" @selected(old('active') === 'false')>No</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="tutor">¿Puede ser tutor?</label>
                                <select id="tutor" name="tutor" class="form-select" required>
                                    <option value="" disabled selected>¿Podrá ser nombrado tutor?</option>
                                    <option value="1" @selected(old('tutor') === '1')>Sí</option>
                                    <option value="0" @selected(old('tutor') === '0')>No</option>
                                </select>
                            </div>

                            @if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_ROLES_USUARIOS']))
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="roles_id">Roles</label>
                                    <select id="roles_id" class="form-select" multiple data-placeholder="Seleccionar roles (opcional)" name="roles_id[]">
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}" @selected(in_array($rol->id, old('roles_id', [])))>{{ $rol->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Opcional; podés asignarlos ahora o después.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="nu-card mt-3">
            <div class="nu-footer">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus me-2"></i>Registrar usuario
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.nu-pass-toggle').on('click', function () {
                var destino = document.getElementById($(this).data('target'));
                if (!destino) { return; }

                var oculto = destino.type === 'password';
                destino.type = oculto ? 'text' : 'password';
                $(this).find('i').toggleClass('fa-eye', !oculto).toggleClass('fa-eye-slash', oculto);
            });
        });
    </script>
@endsection
