@extends('template.molde')

@section('title','Ver evidencias')

@section('ruta')
    <span class="d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-check" style="color:#2d6da3"></i>
        <a href="{{ route('verifica_evidencia.index') }}" class="text-decoration-none">Verificar evidencias</a>
        <span class="text-muted">/</span>
        Archivos
    </span>
@endsection

@section('links')
<style>
    .evidence-view-control,.evidence-view-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06)}
    .evidence-view-control{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding:.9rem 1rem}
    .evidence-view-control h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .evidence-view-control p{margin:.2rem 0 0;color:#6b7280;font-size:.88rem}
    .evidence-grid{display:grid;grid-template-columns:1fr;gap:1rem}
    .evidence-view-card{overflow:hidden}
    .evidence-view-head{display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .evidence-view-head i{width:38px;height:38px;display:grid;place-items:center;border-radius:.7rem;color:#173c66;background:#edf3f8}
    .evidence-view-head h2{margin:0;color:#102b4a;font-size:1.02rem}
    .evidence-view-meta{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.5rem;padding:.85rem 1.25rem;color:#64748b;font-size:.86rem}
    .evidence-view-meta strong{color:#334155}
    .evidence-preview{min-height:260px;display:flex;align-items:center;justify-content:center;padding:1rem;background:#eef3f8}
    .evidence-preview img{max-width:100%;max-height:520px;border-radius:.75rem;box-shadow:0 .65rem 1.5rem rgba(16,43,74,.14)}
    .pdf-evidence-layout{display:grid;grid-template-columns:220px minmax(0,1fr);align-items:stretch}
    .pdf-evidence-info{padding:1.25rem;border-right:1px solid #edf1f5;background:#fff}
    .pdf-evidence-info .evidence-view-meta{display:flex;flex-direction:column;gap:.85rem;padding:0}
    .evidence-view-meta div{display:flex;flex-direction:column;gap:.15rem}
    .pdf-evidence-side{min-width:0}
    .pdf-toolbar{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:.55rem;width:100%;padding:.75rem;border-bottom:1px solid #edf1f5;background:#f8fafc}
    .pdf-toolbar button{min-width:42px}
    .pdf-canvas-wrap{width:100%;min-height:760px;overflow:auto;background:#dfe6ef;padding:1.25rem}
    .pdf-canvas-wrap canvas{display:block;margin:auto;width:min(100%,980px)!important;height:auto!important;background:#fff;box-shadow:0 .55rem 1.5rem rgba(16,43,74,.18)}
    .evidence-actions{display:flex;justify-content:flex-end;gap:.5rem;padding:.85rem 1.25rem}
    .evidence-empty{grid-column:1/-1;padding:3.5rem 1.25rem;text-align:center;color:#64748b;border:1px dashed #cbd5e1;border-radius:1rem;background:#fff}
    @media(max-width:991.98px){.evidence-grid{grid-template-columns:1fr}.evidence-view-control{align-items:flex-start;flex-direction:column}.evidence-view-control .btn{width:100%}.pdf-evidence-layout{grid-template-columns:1fr}.pdf-evidence-info{border-right:0;border-bottom:1px solid #edf1f5}}
</style>
@endsection

@section('contenido')
<div class="evidence-view-control">
    <div><h1>Evidencias de la actividad</h1><p>Visualiza imágenes y PDF sin salir de la aplicación.</p></div>
    <div class="d-flex gap-2 flex-wrap">
        @if($puede_validar)
            @if($actividad_validada === 'true')
                <span class="btn btn-success rounded-pill disabled"><i class="fa-solid fa-circle-check me-2"></i>Ya validada</span>
            @else
                <form action="{{ route('verifica_evidencia.store') }}" method="post" class="mb-0">
                    @csrf
                    <input type="hidden" name="actividades_link" value="false">
                    <input type="hidden" name="id_evidencias[]" value="{{ $actividad_evidencia_id }}">
                    <button type="submit" class="btn btn-success rounded-pill"><i class="fa-solid fa-circle-check me-2"></i>Validar evidencia</button>
                </form>
            @endif
        @endif
        <a href="{{ route('verifica_evidencia.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="fa-solid fa-arrow-left me-2"></i>Volver</a>
    </div>
</div>

<div class="evidence-grid">
    @forelse($evidencias as $evi)
        @php
            $extension = strtolower(pathinfo($evi->nom_imagen, PATHINFO_EXTENSION));
            $url = asset('storage/evidencias/'.$evi->actividad_nombre.'/'.$evi->nom_imagen);
        @endphp
        <article class="evidence-view-card">
            <div class="evidence-view-head">
                <i class="fa-solid {{ $extension === 'pdf' ? 'fa-file-pdf' : 'fa-image' }}"></i>
                <h2>{{ $evi->nom_imagen }}</h2>
            </div>
            @if($extension === 'pdf')
                <div class="pdf-evidence-layout">
                    <aside class="pdf-evidence-info">
                        <div class="evidence-view-meta">
                            <div><span>Actividad</span><strong>{{ $evi->actividad_nombre }}</strong></div>
                            <div><span>Responsable</span><strong>{{ $evi->usuario_nombre }}</strong></div>
                            <div><span>Fecha de subida</span><strong>{{ $evi->fecha_subida }}</strong></div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-up-right-from-square me-2"></i>Abrir</a>
                            <a href="{{ $url }}" download class="btn btn-primary rounded-pill"><i class="fa-solid fa-download me-2"></i>Descargar</a>
                        </div>
                    </aside>
                    <div class="pdf-evidence-side">
                        <div class="pdf-toolbar">
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill pdf-prev" data-pdf="{{ $evi->actividad_evidencia_id }}"><i class="fa-solid fa-chevron-left"></i></button>
                            <span class="small">Página <strong class="pdf-page" data-pdf="{{ $evi->actividad_evidencia_id }}">1</strong> / <strong class="pdf-total" data-pdf="{{ $evi->actividad_evidencia_id }}">--</strong></span>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill pdf-next" data-pdf="{{ $evi->actividad_evidencia_id }}"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                        <div class="pdf-canvas-wrap">
                            <canvas class="pdf-canvas" data-pdf="{{ $evi->actividad_evidencia_id }}" data-url="{{ $url }}"></canvas>
                        </div>
                    </div>
                </div>
            @elseif(in_array($extension,['jpg','jpeg','png','gif','webp']))
                <div class="evidence-view-meta">
                    <div><span>Actividad</span><strong>{{ $evi->actividad_nombre }}</strong></div>
                    <div><span>Responsable</span><strong>{{ $evi->usuario_nombre }}</strong></div>
                    <div class="col-span-2"><span>Fecha de subida</span><strong>{{ $evi->fecha_subida }}</strong></div>
                </div>
                <div class="evidence-preview">
                    <img src="{{ $url }}" alt="Evidencia de {{ $evi->actividad_nombre }}">
                </div>
            @else
                <div class="evidence-view-meta">
                    <div><span>Actividad</span><strong>{{ $evi->actividad_nombre }}</strong></div>
                    <div><span>Responsable</span><strong>{{ $evi->usuario_nombre }}</strong></div>
                    <div class="col-span-2"><span>Fecha de subida</span><strong>{{ $evi->fecha_subida }}</strong></div>
                </div>
                <div class="evidence-preview"><i class="fa-solid fa-file fa-3x text-secondary"></i></div>
            @endif

            @if($extension !== 'pdf')
                <div class="evidence-actions">
                    <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline-primary rounded-pill"><i class="fa-solid fa-up-right-from-square me-2"></i>Abrir</a>
                    <a href="{{ $url }}" download class="btn btn-primary rounded-pill"><i class="fa-solid fa-download me-2"></i>Descargar</a>
                </div>
            @endif
        </article>
    @empty
        <div class="evidence-empty">
            <i class="fa-solid fa-folder-open fa-3x mb-3"></i>
            <h2 class="h5">No hay evidencias disponibles</h2>
            <p class="mb-0">Esta actividad todavía no cuenta con archivos registrados.</p>
        </div>
    @endforelse
</div>
@endsection

@section('js')
<script src="{{ asset('js/pdf_viewer/pdf.js') }}"></script>
<script>
    if (window.pdfjsLib) {
        pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('js/pdf_viewer/pdf.worker.js') }}";

        const pdfState = {};

        document.querySelectorAll('.pdf-canvas').forEach(async function(canvas) {
            const id = canvas.dataset.pdf;
            try {
                const pdf = await pdfjsLib.getDocument(canvas.dataset.url).promise;
                pdfState[id] = { pdf: pdf, page: 1 };
                document.querySelector('.pdf-total[data-pdf="' + id + '"]').textContent = pdf.numPages;
                renderPdfPage(id);
            } catch (error) {
                console.error('No fue posible cargar el PDF', error);
            }
        });

        async function renderPdfPage(id) {
            const state = pdfState[id];
            if (!state) return;
            const page = await state.pdf.getPage(state.page);
            const canvas = document.querySelector('.pdf-canvas[data-pdf="' + id + '"]');
            const context = canvas.getContext('2d');
            const viewport = page.getViewport({ scale: 2.0 });
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            await page.render({ canvasContext: context, viewport: viewport }).promise;
            document.querySelector('.pdf-page[data-pdf="' + id + '"]').textContent = state.page;
        }

        document.querySelectorAll('.pdf-prev').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.dataset.pdf;
                if (!pdfState[id] || pdfState[id].page <= 1) return;
                pdfState[id].page--;
                renderPdfPage(id);
            });
        });

        document.querySelectorAll('.pdf-next').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.dataset.pdf;
                if (!pdfState[id] || pdfState[id].page >= pdfState[id].pdf.numPages) return;
                pdfState[id].page++;
                renderPdfPage(id);
            });
        });
    }
</script>
@endsection
