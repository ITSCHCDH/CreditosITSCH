@extends('template.molde')

@section('title','Roles | Editar')

@section('ruta')
    <span class="d-inline-flex align-items-center flex-wrap gap-2">
        <i class="fa-solid fa-shield-halved" style="color:#2d6da3"></i>
        <a href="{{ route('roles.index') }}" class="text-decoration-none">Roles y permisos</a>
        <span class="text-muted">/</span>
        Editar
    </span>
@endsection

@push('styles')
<style>
    .er-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .er-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .er-card-head h1{margin:0;color:#102b4a;font-size:1.02rem;font-weight:700}
    .er-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .er-card-body{padding:1.25rem}
    .er-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1rem}
    .er-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    .er-dato{display:flex;justify-content:space-between;gap:.75rem;padding:.55rem 0;border-bottom:1px dashed #e7edf4;font-size:.88rem}
    .er-dato:last-of-type{border-bottom:0}
    .er-dato span:first-child{color:#6b7280}
    .er-dato span:last-child{color:#102b4a;font-weight:600;text-align:right}
    .er-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .55rem;border-radius:999px;background:#edf3f8;color:#173c66;font-size:.78rem;font-weight:600}
    @media(max-width:767.98px){
        .er-card-body{padding:1rem}
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

    <div class="row g-3">
        <div class="col-12 col-xl-7">
            <form action="{{ route('roles.role_actualizar', $role->id) }}" method="post" id="formRolEditar">
                @csrf
                <article class="er-card h-100">
                    <div class="er-card-head">
                        <div class="d-flex align-items-center gap-2">
                            <span class="er-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                            <div>
                                <h1>Datos del rol</h1>
                                <p>Cambiá el nombre con el que se identifica el rol.</p>
                            </div>
                        </div>
                        <span class="er-badge"><i class="fa-solid fa-hashtag"></i>{{ $role->id }}</span>
                    </div>
                    <div class="er-card-body">
                        <label class="form-label" for="name">Nombre del rol</label>
                        <input type="text" id="name" name="name" class="form-control" required maxlength="100" value="{{ old('name', $role->name) }}" placeholder="Nombre del rol" autofocus>
                        <p class="text-muted small mt-2 mb-0">El nombre debe ser único. Cambiarlo no afecta los permisos ni los usuarios asignados.</p>
                    </div>
                    <div class="er-footer">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios
                        </button>
                    </div>
                </article>
            </form>
        </div>

        <div class="col-12 col-xl-5">
            <article class="er-card h-100">
                <div class="er-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="er-icon"><i class="fa-solid fa-circle-info"></i></span>
                        <div>
                            <h1>Resumen</h1>
                            <p>Estado actual del rol.</p>
                        </div>
                    </div>
                </div>
                <div class="er-card-body">
                    <div class="er-dato">
                        <span>Identificador</span>
                        <span>{{ $role->id }}</span>
                    </div>
                    <div class="er-dato">
                        <span>Permisos asignados</span>
                        <span>{{ $asignados }} de {{ $totalPermisos }}</span>
                    </div>
                    <div class="er-dato">
                        <span>Usuarios con el rol</span>
                        <span>{{ $usuarios }}</span>
                    </div>
                    <div class="er-dato">
                        <span>Última actualización</span>
                        <span>{{ optional($role->updated_at)->format('d/m/Y H:i') ?? '—' }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('roles.role_ver_permisos', $role->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-regular fa-eye me-2"></i>Ver permisos
                        </a>
                        @if (Auth::User()->hasAnyPermission(['VIP','ASIGNAR_REMOVER_PERMISOS_A_ROLES']))
                            <a href="{{ route('roles.roles_asignar_permisos_vista', $role->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-shield-halved me-2"></i>Asignar permisos
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
