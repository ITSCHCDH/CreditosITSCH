@extends('template.molde')

@section('title','Mi perfil')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-user" style="color:#2d6da3"></i>
        Mi perfil
    </span>
@endsection

@push('styles')
<style>
    .perfil-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .perfil-card-head{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc;border-radius:1rem 1rem 0 0}
    .perfil-card-head h1,.perfil-card-head h2{margin:0;color:#102b4a;font-size:1.05rem;font-weight:700}
    .perfil-card-head p{margin:.15rem 0 0;color:#6b7280;font-size:.83rem}
    .perfil-card-body{padding:1.25rem}
    .perfil-icon{width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
    .perfil-identity{display:flex;align-items:center;gap:1rem;min-width:0}
    .perfil-avatar{width:76px;height:76px;flex:0 0 76px;display:grid;place-items:center;border-radius:1rem;background:linear-gradient(145deg,#edf3f8,#dbe7f2);color:#173c66;font-size:2rem}
    .perfil-name{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700;overflow-wrap:anywhere}
    .perfil-email{margin:.25rem 0 0;color:#6b7280;font-size:.88rem;overflow-wrap:anywhere}
    .perfil-info{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;margin-top:1.1rem}
    .perfil-info-item{display:flex;align-items:flex-start;gap:.65rem;min-width:0;padding:.75rem;border:1px solid #edf1f5;border-radius:.75rem;background:#fbfdff}
    .perfil-info-item i{width:18px;margin-top:.12rem;color:#2d6da3;text-align:center}
    .perfil-info-item span{display:block;color:#6b7280;font-size:.75rem;text-transform:uppercase;letter-spacing:.03em}
    .perfil-info-item strong{display:block;margin-top:.12rem;color:#102b4a;font-size:.88rem;overflow-wrap:anywhere}
    .perfil-role-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.65rem}
    .perfil-role{display:flex;align-items:center;gap:.65rem;min-width:0;padding:.75rem;border:1px solid #edf1f5;border-radius:.75rem;background:#fbfdff;color:#334155}
    .perfil-role i{width:32px;height:32px;flex:0 0 32px;display:grid;place-items:center;border-radius:.55rem;background:#edf3f8;color:#173c66;font-size:.82rem}
    .perfil-role strong{min-width:0;overflow-wrap:anywhere;font-size:.86rem}
    .perfil-security-item{display:flex;align-items:center;gap:.75rem;padding:.8rem 0;border-bottom:1px solid #edf1f5}
    .perfil-security-item:last-child{border-bottom:0;padding-bottom:0}
    .perfil-security-icon{width:38px;height:38px;flex:0 0 38px;display:grid;place-items:center;border-radius:.65rem;background:#edf3f8;color:#173c66}
    .perfil-security-copy{min-width:0;flex:1 1 auto}
    .perfil-security-copy strong{display:block;color:#102b4a;font-size:.88rem}
    .perfil-security-copy span{display:block;margin-top:.1rem;color:#6b7280;font-size:.78rem}
    .perfil-footer{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc;border-radius:0 0 1rem 1rem}
    @media(max-width:767.98px){
        .perfil-card-body{padding:1rem}
        .perfil-identity{align-items:flex-start}
        .perfil-avatar{width:60px;height:60px;flex-basis:60px;font-size:1.5rem}
        .perfil-info,.perfil-role-list{grid-template-columns:1fr}
        .perfil-footer,.perfil-footer .btn{width:100%}
    }
</style>
@endpush

@section('contenido')
    @php
        $usuario = Auth::User();
        $iniciales = collect(preg_split('/\s+/', trim((string) $usuario->name)))
            ->filter()
            ->take(2)
            ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
            ->implode('');
    @endphp

    <div class="row g-3">
        <div class="col-12 col-xl-7">
            <article class="perfil-card h-100">
                <div class="perfil-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="perfil-icon"><i class="fa-solid fa-id-card"></i></span>
                        <div>
                            <h1>Datos personales</h1>
                            <p>Información principal de tu cuenta.</p>
                        </div>
                    </div>
                    <span class="badge rounded-pill {{ $usuario->active === 'true' ? 'bg-success' : 'bg-secondary' }}">
                        <i class="fa-solid {{ $usuario->active === 'true' ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                        {{ $usuario->active === 'true' ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="perfil-card-body">
                    <div class="perfil-identity">
                        <span class="perfil-avatar">{{ $iniciales ?: 'U' }}</span>
                        <div class="min-w-0">
                            <p class="perfil-name">{{ strtoupper($usuario->name) }}</p>
                            <p class="perfil-email">{{ $usuario->email }}</p>
                        </div>
                    </div>

                    <div class="perfil-info">
                        <div class="perfil-info-item">
                            <i class="fa-solid fa-building-columns"></i>
                            <div>
                                <span>Área</span>
                                <strong>{{ $data_usuario->area_nombre }}</strong>
                            </div>
                        </div>
                        <div class="perfil-info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <span>Correo institucional</span>
                                <strong>{{ $usuario->email }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-12 col-xl-5">
            <article class="perfil-card h-100">
                <div class="perfil-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="perfil-icon"><i class="fa-solid fa-shield-halved"></i></span>
                        <div>
                            <h2>Seguridad y acceso</h2>
                            <p>Contraseña y roles asignados.</p>
                        </div>
                    </div>
                </div>
                <div class="perfil-card-body">
                    <div class="perfil-security-item">
                        <span class="perfil-security-icon"><i class="fa-solid fa-key"></i></span>
                        <div class="perfil-security-copy">
                            <strong>Contraseña</strong>
                            <span>Protege el acceso a tu cuenta.</span>
                        </div>
                        <a href="{{ route('perfil.password_reset_view') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen me-1"></i>Cambiar
                        </a>
                    </div>
                    <div class="perfil-security-item">
                        <span class="perfil-security-icon"><i class="fa-solid fa-user-shield"></i></span>
                        <div class="perfil-security-copy">
                            <strong>Roles</strong>
                            <span>{{ count($roles) }} asignado(s)</span>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-12">
            <article class="perfil-card">
                <div class="perfil-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <span class="perfil-icon"><i class="fa-solid fa-list-check"></i></span>
                        <div>
                            <h2>Roles asignados</h2>
                            <p>Permisos derivados de tu perfil.</p>
                        </div>
                    </div>
                </div>
                <div class="perfil-card-body">
                    @if(count($roles) > 0)
                        <div class="perfil-role-list">
                            @foreach($roles as $rol)
                                <div class="perfil-role">
                                    <i class="fa-solid fa-user-tag"></i>
                                    <strong>{{ $rol }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fa-solid fa-user-slash d-block mb-2"></i>
                            No tienes roles asignados.
                        </div>
                    @endif
                </div>
                <div class="perfil-footer">
                    <a href="{{ route('perfil.password_reset_view') }}" class="btn btn-primary">
                        <i class="fa-solid fa-key me-2"></i>Cambiar contraseña
                    </a>
                </div>
            </article>
        </div>
    </div>
@endsection
