@extends('template.molde')

@section('title','Cambiar contraseña')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-key" style="color:#2d6da3"></i>
        <a href="{{ route('perfil.index') }}" class="text-decoration-none">Mi perfil</a>
        <span class="text-muted">/</span>
        Cambiar contraseña
    </span>
@endsection

@push('styles')
<style>
    .pass-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .pass-card-head{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .pass-card-head h1{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .pass-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .pass-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .pass-card-body{padding:1.25rem}
    .pass-field{position:relative}
    .pass-field .form-control{padding-right:2.75rem}
    .pass-toggle{position:absolute;top:50%;right:.55rem;transform:translateY(-50%);border:0;background:transparent;color:#6b7280;padding:.35rem;line-height:1;border-radius:.4rem}
    .pass-toggle:hover{color:#102b4a;background:#edf3f8}
    .pass-requirements{display:grid;gap:.35rem;padding:.75rem;border:1px solid #edf1f5;border-radius:.75rem;background:#fbfdff;color:#64748b;font-size:.78rem}
    .pass-requirements span i{width:18px;text-align:center;margin-right:.25rem}
    .pass-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    @media(max-width:767.98px){
        .pass-card-body{padding:1rem}
        .pass-footer,.pass-footer .btn{width:100%}
    }
</style>
@endpush

@section('contenido')
    @if($errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Revisá los datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perfil.password_update') }}" method="post" id="formCambiarPassword">
        @csrf
        <article class="pass-card">
            <div class="pass-card-head">
                <span class="pass-icon"><i class="fa-solid fa-shield-halved"></i></span>
                <div>
                    <h1>Cambiar contraseña</h1>
                    <p>Confirma tu contraseña actual y define una nueva.</p>
                </div>
            </div>
            <div class="pass-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="old_password">Contraseña actual</label>
                        <div class="pass-field">
                            <input type="password" id="old_password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" required autocomplete="current-password">
                            <button type="button" class="pass-toggle" data-target="old_password" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            @error('old_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="new_password">Contraseña nueva</label>
                        <div class="pass-field">
                            <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" minlength="4" maxlength="60" required autocomplete="new-password">
                            <button type="button" class="pass-toggle" data-target="new_password" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="confirm_password">Confirmar contraseña</label>
                        <div class="pass-field">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" minlength="4" maxlength="60" required autocomplete="new-password">
                            <button type="button" class="pass-toggle" data-target="confirm_password" title="Mostrar u ocultar">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="pass-requirements">
                            <span><i class="fa-solid fa-circle-check text-success"></i>Entre 4 y 60 caracteres.</span>
                            <span><i class="fa-solid fa-circle-info text-primary"></i>La confirmación debe coincidir con la contraseña nueva.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pass-footer">
                <a href="{{ route('perfil.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar contraseña
                </button>
            </div>
        </article>
    </form>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.pass-toggle').on('click', function () {
            const destino = document.getElementById($(this).data('target'));
            if (!destino) { return; }

            const mostrar = destino.type === 'password';
            destino.type = mostrar ? 'text' : 'password';
            $(this).find('i').toggleClass('fa-eye', !mostrar).toggleClass('fa-eye-slash', mostrar);
        });

        $('#formCambiarPassword').on('submit', function (event) {
            if ($('#new_password').val() !== $('#confirm_password').val()) {
                event.preventDefault();
                $('#confirm_password').addClass('is-invalid');
                $('#confirm_password').nextAll('.invalid-feedback').remove();
                $('#confirm_password').after('<div class="invalid-feedback d-block">Las contraseñas no coinciden.</div>');
                $('#confirm_password').focus();
            }
        });
    });
</script>
@endsection
