@extends('template.molde')

@section('title','Usuarios | Modificar')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-user-pen" style="color:#2d6da3"></i>
        <a href="{{ route('usuarios.index') }}" class="text-decoration-none">Usuarios</a>
        <span class="text-muted">/</span>
        Modificar
    </span>
@endsection

@push('styles')
<style>
    .usuario-edit-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .usuario-edit-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .usuario-edit-head h1,.usuario-edit-head h2{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .usuario-edit-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .usuario-edit-body{padding:1.25rem}
    .usuario-edit-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .usuario-edit-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .usuario-edit-pass{position:relative}
    .usuario-edit-pass .form-control{padding-right:2.75rem}
    .usuario-edit-pass-toggle{position:absolute;top:50%;right:.55rem;transform:translateY(-50%);border:0;background:transparent;color:#6b7280;padding:.35rem;line-height:1;border-radius:.4rem}
    .usuario-edit-pass-toggle:hover{color:#102b4a;background:#edf3f8}
    .usuario-edit-status{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .55rem;border-radius:999px;font-size:.76rem;font-weight:600}
    .usuario-edit-status--active{background:#e7f5ec;color:#1b7a43}
    .usuario-edit-status--inactive{background:#fdeceb;color:#b3261e}
    @media(max-width:767.98px){
        .usuario-edit-body{padding:1rem}
        .usuario-edit-footer,.usuario-edit-footer .btn{width:100%}
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

    <form method="POST" action="{{ route('usuarios.update',$user->id) }}" id="formUsuario">
        @csrf

        <div class="row g-3">
            <div class="col-12 col-xl-7">
                <article class="usuario-edit-card h-100">
                    <div class="usuario-edit-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="usuario-edit-icon"><i class="fa-solid fa-id-card"></i></span>
                            <div>
                                <h1>Datos del usuario</h1>
                                <p>Nombre y correo institucional.</p>
                            </div>
                        </div>
                        <span class="usuario-edit-status {{ $user->active === 'true' ? 'usuario-edit-status--active' : 'usuario-edit-status--inactive' }}">
                            <i class="fa-solid {{ $user->active === 'true' ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                            {{ $user->active === 'true' ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <div class="usuario-edit-body">
                        <div class="mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input
                                type="text"
                                id="nombre"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                maxlength="100"
                                required
                                autofocus
                            >
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-5">
                <article class="usuario-edit-card h-100">
                    <div class="usuario-edit-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="usuario-edit-icon"><i class="fa-solid fa-shield-halved"></i></span>
                            <div>
                                <h2>Contraseña</h2>
                                <p>Déjala vacía para conservar la actual.</p>
                            </div>
                        </div>
                    </div>
                    <div class="usuario-edit-body">
                        <div class="mb-3 usuario-edit-pass">
                            <label class="form-label" for="password">Nueva contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                minlength="4"
                                maxlength="60"
                                autocomplete="new-password"
                                placeholder="Opcional"
                            >
                            <button type="button" class="usuario-edit-pass-toggle" data-target="password" title="Mostrar u ocultar contraseña">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0 usuario-edit-pass">
                            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                minlength="4"
                                maxlength="60"
                                autocomplete="new-password"
                                placeholder="Repite la nueva contraseña"
                            >
                            <button type="button" class="usuario-edit-pass-toggle" data-target="password_confirmation" title="Mostrar u ocultar confirmación">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-12">
                <article class="usuario-edit-card">
                    <div class="usuario-edit-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="usuario-edit-icon"><i class="fa-solid fa-building-columns"></i></span>
                            <div>
                                <h2>Área y asignaciones</h2>
                                <p>Carrera, dependencia y disponibilidad del usuario.</p>
                            </div>
                        </div>
                    </div>
                    <div class="usuario-edit-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="area">Área</label>
                                <select id="area" name="area" class="form-select @error('area') is-invalid @enderror" required>
                                    @if ($areas->count() === 1)
                                        <option value="{{ $areas[0]->id }}" selected>{{ $areas[0]->nombre }}</option>
                                    @else
                                        <option value="">Seleccione un área</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" @selected((string) old('area', $user->area) === (string) $area->id)>
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('area')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="sit_carrera_id">Carrera SIT</label>
                                <select id="sit_carrera_id" name="sit_carrera_id" class="form-select">
                                    <option value="">Sin carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" @selected((string) old('sit_carrera_id', $user->sit_carrera_id) === (string) $carrera->id)>
                                            {{ $carrera->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="active">Estado</label>
                                <select id="active" name="active" class="form-select" required>
                                    <option value="true" @selected(old('active', $user->active) === 'true')>Activo</option>
                                    <option value="false" @selected(old('active', $user->active) === 'false')>Inactivo</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="tutor">¿Puede ser tutor?</label>
                                <select id="tutor" name="tutor" class="form-select" required>
                                    <option value="1" @selected((string) old('tutor', $user->tutor) === '1')>Sí</option>
                                    <option value="0" @selected((string) old('tutor', $user->tutor) === '0')>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="usuario-edit-card mt-3">
            <div class="usuario-edit-footer">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios
                </button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.usuario-edit-pass-toggle').on('click', function () {
            const destino = document.getElementById($(this).data('target'));
            if (!destino) { return; }

            const mostrar = destino.type === 'password';
            destino.type = mostrar ? 'text' : 'password';
            $(this).find('i').toggleClass('fa-eye', !mostrar).toggleClass('fa-eye-slash', mostrar);
        });

        $('#formUsuario').on('submit', function (event) {
            const password = $('#password').val();
            const confirmation = $('#password_confirmation').val();

            if (password && password !== confirmation) {
                event.preventDefault();
                $('#password_confirmation').addClass('is-invalid');
                $('#password_confirmation').nextAll('.invalid-feedback').remove();
                $('#password_confirmation').after('<div class="invalid-feedback d-block">Las contraseñas no coinciden.</div>');
                $('#password_confirmation').focus();
            }
        });
    });
</script>
@endsection
