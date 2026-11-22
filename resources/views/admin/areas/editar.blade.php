@extends('template.molde')

@section('title','Editar área administrativa')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2 flex-wrap">
        <i class="fa-solid fa-sitemap" style="color:#2d6da3"></i>
        <a href="{{ route('areas.inicio') }}" class="text-decoration-none">Áreas administrativas</a>
        <span class="text-muted">/</span>
        Editar
    </span>
@endsection

@push('styles')
<style>
    .area-edit-card{border:1px solid #e4eaf1;border-radius:1.15rem;background:#fff;box-shadow:0 .55rem 1.35rem rgba(29,78,116,.08);overflow:hidden}
    .area-edit-head{display:flex;align-items:center;gap:.75rem;padding:1.15rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .area-edit-icon{width:44px;height:44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8}
    .area-edit-head h1{margin:0;font-size:1.05rem;font-weight:700;color:#102b4a}
    .area-edit-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .area-edit-body{padding:1.25rem}
    .area-edit-footer{display:flex;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc}
</style>
@endpush

@section('contenido')
    <form action="{{ route('areas.actualizar',$area->id) }}" method="post">
        @csrf
        <article class="area-edit-card">
            <div class="area-edit-head">
                <span class="area-edit-icon"><i class="fa-solid fa-building-columns"></i></span>
                <div>
                    <h1>{{ $area->nombre }}</h1>
                    <p>Actualiza el nombre del departamento administrativo.</p>
                </div>
            </div>
            <div class="area-edit-body">
                <label class="form-label" for="nombre">Nombre del área</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-signature"></i></span>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                        value="{{ old('nombre', $area->nombre) }}" maxlength="150" required autofocus>
                </div>
            </div>
            <div class="area-edit-footer">
                <a href="{{ route('areas.inicio') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar cambios
                </button>
            </div>
        </article>
    </form>
@endsection
