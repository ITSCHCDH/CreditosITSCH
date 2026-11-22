@extends('template.molde')

@section('title','Nueva área administrativa')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2 flex-wrap">
        <i class="fa-solid fa-sitemap" style="color:#2d6da3"></i>
        <a href="{{ route('areas.inicio') }}" class="text-decoration-none">Áreas administrativas</a>
        <span class="text-muted">/</span>
        Nueva área
    </span>
@endsection

@push('styles')
<style>
    .area-create-card{border:1px solid #e4eaf1;border-radius:1.15rem;background:#fff;box-shadow:0 .55rem 1.35rem rgba(29,78,116,.08);overflow:hidden}
    .area-create-head{display:flex;align-items:center;gap:.75rem;padding:1.15rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .area-create-icon{width:44px;height:44px;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8}
    .area-create-head h1{margin:0;font-size:1.05rem;font-weight:700;color:#102b4a}
    .area-create-head p{margin:.15rem 0 0;color:#6b7280;font-size:.82rem}
    .area-create-body{padding:1.25rem}
    .area-create-footer{display:flex;justify-content:flex-end;gap:.5rem;padding:1rem 1.25rem;border-top:1px solid #edf1f5;background:#f8fafc}
    .area-help{display:flex;align-items:flex-start;gap:.65rem;padding:.75rem;border-radius:.75rem;background:#edf3f8;color:#4b5563;font-size:.85rem}
</style>
@endpush

@section('contenido')
    @if ($errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <strong>Revisa los datos:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('areas.guardar') }}" method="post" id="formCrearArea">
        @csrf
        <article class="area-create-card">
            <div class="area-create-head">
                <span class="area-create-icon"><i class="fa-solid fa-building-columns"></i></span>
                <div>
                    <h1>Datos del área</h1>
                    <p>Captura el departamento administrativo interno.</p>
                </div>
            </div>
            <div class="area-create-body">
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre del área</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-signature"></i></span>
                        <input type="text" name="nombre" id="nombre" placeholder="Ej. Desarrollo Académico"
                            class="form-control" value="{{ old('nombre') }}" maxlength="150" required autofocus>
                    </div>
                </div>
                <div class="area-help">
                    <i class="fa-solid fa-circle-info mt-1 text-primary"></i>
                    <span>Esta área se utiliza para adscribir usuarios administrativos. Las carreras se gestionan desde el catálogo institucional SIT.</span>
                </div>
                <input type="hidden" name="tipo" value="otro">
            </div>
            <div class="area-create-footer">
                <a href="{{ route('areas.inicio') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar área
                </button>
            </div>
        </article>
    </form>
@endsection
