@extends('template.molde')

@section('title','Agregar evidencia')

@section('links')
<style>
    .evidence-breadcrumb,.evidence-control,.evidence-card,.upload-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .evidence-breadcrumb{display:flex;align-items:center;gap:.65rem;min-height:64px;margin-bottom:.75rem;padding:.8rem 1rem;color:#64748b}
    .evidence-breadcrumb i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .evidence-breadcrumb strong{color:#102b4a}
    .evidence-control{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.9rem 1rem}
    .evidence-control h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .evidence-control p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
    .evidence-card{overflow:hidden;margin-bottom:1rem}
    .evidence-card-head{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .evidence-card-head i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .evidence-card-head h2{margin:0;color:#102b4a;font-size:1.05rem}
    .evidence-card-body{padding:1.25rem}
    .evidence-card .form-control,.evidence-card .form-select{min-height:48px;border-radius:.75rem}
    .upload-card{padding:1.25rem;text-align:center}
    .upload-dropzone{min-height:220px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:2px dashed #b8c7d9;border-radius:1rem;background:#f8fafc;cursor:pointer;transition:.18s ease}
    .upload-dropzone:hover{border-color:#173c66;background:#edf3f8}
    .upload-dropzone i{font-size:2.25rem;color:#173c66}
    .upload-dropzone strong{display:block;margin:.75rem 0 .25rem;color:#102b4a}
    .upload-dropzone span{color:#64748b;font-size:.88rem}
    #archivos{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
    #evidence-file-name{min-height:24px;margin-top:.75rem;color:#475569;font-size:.88rem}
    @media(max-width:767.98px){.evidence-control{align-items:flex-start;flex-direction:column}.evidence-control .btn{width:100%}.upload-dropzone{min-height:180px}}
</style>
@endsection

@section('contenido')
<div class="evidence-breadcrumb">
    <i class="fa-solid fa-camera"></i>
    <div><a class="text-decoration-none" href="{{ route('participantes.index') }}">Participantes</a><span class="mx-2">/</span><strong>Agregar evidencia</strong></div>
</div>

<div class="evidence-control">
    <div><h1>Nueva evidencia</h1><p>Carga uno o varios archivos PDF, JPG, JPEG o PNG.</p></div>
    <a href="{{ route('participantes.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Volver</a>
</div>

<form action="{{ route('evidencias.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-lg-7">
            <article class="evidence-card">
                <div class="evidence-card-head"><i class="fa-solid fa-circle-info"></i><h2>Información de la evidencia</h2></div>
                <div class="evidence-card-body">
                    <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                    <input type="hidden" name="responsables" id="responsables" value="{{ $responsable->id }}">
                    <div class="mb-3">
                        <label class="form-label" for="id_asig_activi">Actividad</label>
                        <input type="text" name="id_asig_activi" id="id_asig_activi" value="{{ $actividad->nombre }}" class="form-control" readonly required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="resp">Responsable</label>
                        <input type="text" name="resp" id="resp" value="{{ $responsable->name }}" class="form-control" readonly required>
                    </div>
                    <div>
                        <label class="form-label" for="valida">Responsable que valida</label>
                        @if($validador != null)
                            <select id="valida" name="valida" class="form-select" disabled>
                                <option value="{{ $validador->id }}" selected>{{ $validador->name }}</option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="No asignado" readonly>
                        @endif
                    </div>
                </div>
            </article>
        </div>

        <div class="col-lg-5">
            <article class="upload-card">
                <label class="upload-dropzone" for="archivos">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <strong>Seleccionar archivos</strong>
                    <span>PDF, JPG, JPEG o PNG · múltiples archivos</span>
                </label>
                <input type="file" name="archivos[]" id="archivos" multiple required accept=".pdf,.jpg,.jpeg,.png">
                <div id="evidence-file-name">Ningún archivo seleccionado</div>
            </article>
        </div>

        <div class="col-12 d-flex justify-content-end gap-2">
            <a href="{{ route('participantes.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar evidencia</button>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
    document.getElementById('archivos').addEventListener('change', function () {
        const label = document.getElementById('evidence-file-name');
        if (!this.files.length) {
            label.textContent = 'Ningún archivo seleccionado';
            return;
        }
        label.textContent = this.files.length === 1
            ? this.files[0].name
            : this.files.length + ' archivos seleccionados';
    });
</script>
@endsection
