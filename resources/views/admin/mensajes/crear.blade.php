@extends('template.molde')

@section('title','Crear mensaje')

@section('links')
<link rel="stylesheet" href="{{ asset('plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}">
<style>
    .message-composer { max-width:980px; margin:auto; border:1px solid #e7edf4; border-radius:1.1rem; background:#fff; box-shadow:0 1rem 2.25rem rgba(29,78,116,.12),0 .25rem .65rem rgba(16,43,74,.07); overflow:hidden; }
    .message-composer-head { display:flex; align-items:center; gap:.75rem; padding:1rem 1.25rem; background:#f8fafc; border-bottom:1px solid #edf1f5; }
    .message-composer-head i { width:38px; height:38px; display:grid; place-items:center; border-radius:.7rem; color:#173c66; background:#edf3f8; }
    .message-composer-head h1 { margin:0; color:#102b4a; font-size:1.15rem; }
    .message-composer-body { padding:1.25rem; }
    .recipient-select { min-height:46px; }
</style>
@endsection

@section('ruta')
@endsection

@section('contenido')
<div class="message-breadcrumb-card">
    <i class="fa-solid fa-message"></i>
    <div><a class="text-decoration-none" href="{{ route('mensajes.index') }}">Mensajes</a><span class="mx-2">/</span><strong>Crear mensaje</strong></div>
</div>
<div class="message-control-card">
    <div><h1>Nuevo mensaje</h1><p>Redacta el asunto y selecciona los destinatarios.</p></div>
    <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Bandeja</a>
</div>
<form action="{{ route('mensajes.enviar') }}" method="post" class="message-composer">
    @csrf
    <div class="message-composer-head">
        <i class="fa-solid fa-envelope-open-text"></i>
        <h1>Nuevo mensaje</h1>
    </div>
    <div class="message-composer-body">
        <input type="hidden" name="creador_id" value="{{ Auth::User()->id }}">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="sender">De</label>
                <input type="text" id="sender" value="{{ Auth::User()->name }}" class="form-control" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="destinatarios">Para</label>
                <select id="destinatarios" class="form-select recipient-select" multiple required name="destinatarios_id[]">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label" for="notificacion">Asunto</label>
                <input type="text" id="notificacion" name="notificacion" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label" for="textarea-mensaje">Mensaje</label>
                <textarea id="textarea-mensaje" class="form-control" name="mensaje" rows="8" required></textarea>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-paper-plane me-2"></i>Enviar
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script src="{{ asset('plugins/Trumbowyg-master/dist/trumbowyg.min.js') }}"></script>
<script>
    $("#textarea-mensaje").trumbowyg({lang:'es',autogrow:true});
</script>
@endsection
