@php
    /*
    |--------------------------------------------------------------------------
    | Buscador combobox reutilizable
    |--------------------------------------------------------------------------
    | Campo de búsqueda con lista de coincidencias y acción integrada en un
    | mismo control. Requiere MDB/Bootstrap y Font Awesome (ya cargados por
    | el molde institucional).
    |
    | Uso:
    |   @include('template.partes.buscador_combobox', [
    |       'config' => [
    |           'id' => 'alumno',
    |           'action' => route('...'),
    |           'endpoint' => route('...'),
    |           'field' => 'no_control',
    |           'initial' => ['no_control' => '...', 'nombre' => '...', 'carrera' => '...'],
    |       ],
    |   ])
    |
    | El endpoint debe responder JSON con una lista de objetos cuyas claves se
    | indican en 'keys' (por defecto: no_control, nombre, carrera).
    |
    | Opciones destacadas:
    |   'bare'     => true  renderiza solo el control (sin card ni form propio),
    |                        para usarlo dentro de un formulario existente.
    |   'required' => false permite enviar el formulario sin selección.
    |   'show_submit' => false oculta el botón del componente (la acción la
    |                        dispara otro botón del formulario anfitrión).
    |
    | El control expone combo.cbxSetParams({...}) para actualizar los parámetros
    | del endpoint en caliente (por ejemplo, al cambiar otro filtro).
    */

    $options = array_merge([
        'id' => 'cbx',
        'action' => '',
        'endpoint' => '',
        'method' => 'get',
        'field' => 'no_control',
        'title' => 'Buscar',
        'title_icon' => 'fa-solid fa-magnifying-glass',
        'description' => '',
        'label' => 'Registro',
        'placeholder' => 'Escribe para buscar',
        'matches_label' => 'Coincidencias',
        'submit_label' => 'Consultar',
        'submit_icon' => 'fa-solid fa-chart-line',
        'show_submit' => true,
        'bare' => false,
        'required' => true,
        'min_chars' => 2,
        'limit' => 5,
        'query_param' => 'nombre',
        'params' => [],
        'keys' => ['value' => 'no_control', 'label' => 'nombre', 'meta' => 'carrera'],
        'initial' => null,
    ], $config ?? []);

    $options['keys'] = array_merge(
        ['value' => 'no_control', 'label' => 'nombre', 'meta' => 'carrera'],
        (array) $options['keys']
    );

    $uid = preg_replace('/[^A-Za-z0-9_-]+/', '', (string) $options['id']);
    $uid = $uid !== '' ? $uid : 'cbx';

    $minChars = max(1, (int) $options['min_chars']);
    $limit = max(1, (int) $options['limit']);

    $initialValue = '';
    $initialData = null;
    if (is_array($options['initial']) && $options['initial'] !== []) {
        $initialData = $options['initial'];
        $initialValue = (string) ($initialData[$options['keys']['value']] ?? '');
    }

    $messages = [
        'searching' => 'Buscando coincidencias...',
        'empty_state' => 'Escribe al menos '.$minChars.' caracteres para buscar.',
        'no_results' => 'Sin coincidencias. Prueba con otro término.',
        'error' => 'No fue posible completar la búsqueda. Intenta de nuevo.',
        'selected_state' => 'Seleccionado. Continúa o usa la lupa para cambiarlo.',
        'loaded_state' => 'Selección cargada desde la consulta actual.',
        'choose_first' => 'Selecciona una opción de la lista antes de continuar.',
        'change_state' => 'Escribe otro término para buscar.',
        'hint_one' => '1 coincidencia. Elige con Enter.',
        'hint_many' => '%d coincidencias. Muévete con ↑ ↓ y elige con Enter.',
        'hint_searching' => 'Buscando...',
        'hint_none' => 'Sin coincidencias',
        'hint_error' => 'Error al buscar coincidencias',
    ];

    $componentConfig = [
        'prefix' => $uid,
        'endpoint' => $options['endpoint'],
        'queryParam' => $options['query_param'],
        'params' => (object) $options['params'],
        'keys' => $options['keys'],
        'initial' => $initialData,
        'minChars' => $minChars,
        'limit' => $limit,
        'required' => (bool) $options['required'],
        'messages' => $messages,
    ];
@endphp

@push('styles')
@once
<style>
    .cbx-card{border:1px solid #e7edf4;border-radius:1rem;background:#fff;box-shadow:0 .75rem 1.5rem rgba(29,78,116,.10),0 .18rem .45rem rgba(16,43,74,.06);margin-bottom:1rem;padding:1.25rem}
    .cbx-card h1{margin:0;color:#102b4a;font-size:1.25rem;font-weight:700}
    .cbx-card p{margin:.2rem 0 1rem;color:#6b7280;font-size:.88rem}
    .cbx-card-icon{width:44px;height:44px;flex:0 0 auto;display:grid;place-items:center;border-radius:.8rem;color:#173c66;background:#edf3f8;font-size:1.05rem}
    .cbx-picker{position:relative}
    .cbx-combo{display:flex;align-items:center;gap:.6rem;min-height:52px;padding:.3rem .35rem .3rem .8rem;border:1px solid #d7dee8;border-radius:.75rem;background:#fff;transition:border-color .15s ease,box-shadow .15s ease}
    .cbx-combo.is-focused{border-color:#2d6da3;box-shadow:0 0 0 .2rem rgba(45,109,163,.15)}
    .cbx-combo>.cbx-search-icon{flex:0 0 auto;color:#64748b;font-size:.95rem}
    .cbx-input{flex:1 1 auto;min-width:5rem;border:0;outline:0;background:transparent;color:#102b4a;font-size:.95rem;line-height:1.4}
    .cbx-input::placeholder{color:#94a3b8}
    .cbx-input[hidden],.cbx-chip[hidden],.cbx-icon-btn[hidden],.cbx-panel[hidden]{display:none!important}
    .cbx-chip{display:flex;align-items:center;gap:.55rem;flex:1 1 auto;min-width:0}
    .cbx-chip-avatar{width:32px;height:32px;flex:0 0 auto;display:grid;place-items:center;border-radius:.6rem;color:#173c66;background:#e8eff6;font-size:.85rem}
    .cbx-chip-text{display:flex;flex:1 1 auto;flex-wrap:wrap;align-items:baseline;gap:.45rem;min-width:0;line-height:1.25}
    .cbx-chip-label{max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;color:#102b4a}
    .cbx-chip-meta{font-size:.78rem;color:#64748b}
    .cbx-actions{display:flex;align-items:center;gap:.2rem;margin-left:auto;flex:0 0 auto}
    .cbx-icon-btn{width:34px;height:34px;display:grid;place-items:center;border:0;border-radius:.6rem;background:transparent;color:#64748b;cursor:pointer;transition:background-color .15s ease,color .15s ease}
    .cbx-icon-btn:hover,.cbx-icon-btn:focus-visible{background:#eef3f8;color:#173c66}
    .cbx-icon-btn:focus-visible{outline:2px solid #2d6da3;outline-offset:2px}
    .cbx-submit{flex:0 0 auto;display:inline-flex;align-items:center;justify-content:center;gap:.45rem;min-height:44px;padding:.45rem 1.05rem;border-radius:.6rem;font-weight:600;white-space:nowrap}
    .cbx-submit:disabled{opacity:.55}
    .cbx-panel{position:absolute;z-index:1080;top:calc(100% + .35rem);right:0;left:0;max-height:22rem;padding:.35rem;overflow-y:auto;border:1px solid #e2e8f0;border-radius:.85rem;background:#fff;box-shadow:0 1rem 2rem rgba(16,43,74,.16)}
    .cbx-option{display:flex;align-items:center;gap:.7rem;width:100%;padding:.55rem .65rem;border:0;border-radius:.6rem;background:transparent;text-align:left;color:#102b4a}
    .cbx-option+.cbx-option{margin-top:.15rem}
    .cbx-option:hover,.cbx-option.is-active{background:#eef4fa}
    .cbx-option:focus-visible{outline:2px solid #2d6da3;outline-offset:-2px}
    .cbx-option-avatar{width:34px;height:34px;flex:0 0 auto;display:grid;place-items:center;border-radius:.6rem;color:#173c66;background:#e8eff6;font-size:.88rem}
    .cbx-option-body{flex:1 1 auto;min-width:0}
    .cbx-option-label{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.92rem;font-weight:600;color:#102b4a}
    .cbx-option-meta{display:flex;flex-wrap:wrap;align-items:center;gap:.4rem;margin-top:.15rem;font-size:.78rem;color:#64748b}
    .cbx-option-badge{padding:.05rem .5rem;border-radius:999px;background:#eef3f8;color:#173c66;font-size:.72rem;font-weight:700;letter-spacing:.02em}
    .cbx-option-arrow{margin-left:auto;color:#94a3b8;font-size:.78rem}
    .cbx-state{display:flex;align-items:center;gap:.6rem;padding:.7rem;border-radius:.6rem;color:#64748b;font-size:.86rem}
    .cbx-hint{display:block;margin-top:.4rem;font-size:.78rem;color:#6b7280}
    .cbx-hint[data-state="error"]{color:#b91c1c}
    .cbx-hint[data-state="ok"]{color:#15803d}
    @media(max-width:767.98px){.cbx-combo{flex-wrap:wrap;padding:.35rem}.cbx-panel{max-height:17rem}}
    @media(max-width:575.98px){.cbx-submit{order:3;width:100%;margin-top:.25rem}}
</style>
@endonce
@endpush

@if(! $options['bare'])
<article class="cbx-card">
    <div class="d-flex align-items-start align-items-sm-center gap-3 mb-3">
        <span class="cbx-card-icon"><i class="{{ $options['title_icon'] }}" aria-hidden="true"></i></span>
        <div>
            <h1>{{ $options['title'] }}</h1>
            @if($options['description'] !== '')
                <p class="mb-0">{{ $options['description'] }}</p>
            @endif
        </div>
    </div>
    <form action="{{ $options['action'] }}" method="{{ $options['method'] }}" id="{{ $uid }}_form" autocomplete="off" novalidate>
@endif
        <input type="hidden" name="{{ $options['field'] }}" id="{{ $uid }}_value" value="{{ $initialValue }}">
        <div>
            <label class="form-label" for="{{ $uid }}_input">{{ $options['label'] }}</label>
            <div class="cbx-picker" id="{{ $uid }}_picker">
                <div class="cbx-combo" id="{{ $uid }}_combo">
                    <i class="fa-solid fa-magnifying-glass cbx-search-icon" aria-hidden="true"></i>
                    <input type="text" id="{{ $uid }}_input" class="cbx-input" placeholder="{{ $options['placeholder'] }}" autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="{{ $uid }}_panel" aria-describedby="{{ $uid }}_status">
                    <div class="cbx-chip" id="{{ $uid }}_chip" hidden>
                        <span class="cbx-chip-avatar"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>
                        <span class="cbx-chip-text">
                            <span class="cbx-chip-label" id="{{ $uid }}_chip_label"></span>
                            <span class="cbx-chip-meta" id="{{ $uid }}_chip_meta"></span>
                        </span>
                    </div>
                    <div class="cbx-actions">
                        <button type="button" class="cbx-icon-btn" id="{{ $uid }}_clear" aria-label="Quitar selección" hidden><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                        <button type="button" class="cbx-icon-btn" id="{{ $uid }}_toggle" aria-label="Mostrar u ocultar coincidencias" aria-expanded="false"><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></button>
                    </div>
                    @if($options['show_submit'])
                        <button type="submit" class="btn btn-primary cbx-submit" id="{{ $uid }}_submit" @if($initialValue === '') disabled @endif><i class="{{ $options['submit_icon'] }}" aria-hidden="true"></i><span>{{ $options['submit_label'] }}</span></button>
                    @endif
                </div>
                <div class="cbx-panel" id="{{ $uid }}_panel" role="listbox" aria-label="{{ $options['matches_label'] }}" hidden>
                    <div class="cbx-state"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><span>Escribe al menos {{ $minChars }} caracteres para buscar.</span></div>
                </div>
                <small class="cbx-hint" id="{{ $uid }}_status" role="status" aria-live="polite"></small>
            </div>
        </div>
@if(! $options['bare'])
    </form>
</article>
@endif

<script>
    (function () {
        const config = @json($componentConfig);
        const byId = function (suffix) { return document.getElementById(config.prefix + suffix); };
        const combo = byId('_combo');

        if (!combo || combo.dataset.cbxReady === '1') { return; }
        combo.dataset.cbxReady = '1';

        const form = byId('_form');
        const picker = byId('_picker');
        const input = byId('_input');
        const panel = byId('_panel');
        const chip = byId('_chip');
        const chipLabel = byId('_chip_label');
        const chipMeta = byId('_chip_meta');
        const clearButton = byId('_clear');
        const toggleButton = byId('_toggle');
        const hiddenControl = byId('_value');
        const submitButton = byId('_submit');
        const status = byId('_status');

        const messages = config.messages;
        const keys = config.keys;
        const minChars = config.minChars;
        const limit = config.limit;
        const required = config.required !== false;

        let matches = [];
        let activeIndex = -1;
        let debounceTimer = null;
        let requestSeq = 0;
        let lastQuery = '';
        let liveParams = Object.assign({}, config.params || {});

        const normalize = function (value) { return String(value || '').replace(/\s+/g, ' ').trim(); };
        const isOpen = function () { return !panel.hidden; };

        combo.cbxSetParams = function (extra) {
            liveParams = Object.assign(liveParams, extra || {});
        };

        function setHint(message, state) {
            status.textContent = message || '';
            if (state) { status.dataset.state = state; } else { status.removeAttribute('data-state'); }
        }

        function setSubmitEnabled(enabled) {
            if (!submitButton) { return; }
            submitButton.disabled = required ? !enabled : false;
        }

        function openPanel() {
            panel.hidden = false;
            toggleButton.setAttribute('aria-expanded', 'true');
            input.setAttribute('aria-expanded', 'true');
        }

        function closePanel() {
            panel.hidden = true;
            toggleButton.setAttribute('aria-expanded', 'false');
            input.setAttribute('aria-expanded', 'false');
            input.removeAttribute('aria-activedescendant');
            activeIndex = -1;
        }

        function renderState(icon, message, spin) {
            panel.innerHTML = '';
            const state = document.createElement('div');
            state.className = 'cbx-state';
            const iconEl = document.createElement('i');
            iconEl.className = 'fa-solid ' + icon + (spin ? ' fa-spin' : '');
            iconEl.setAttribute('aria-hidden', 'true');
            const text = document.createElement('span');
            text.textContent = message;
            state.append(iconEl, text);
            panel.appendChild(state);
            matches = [];
            activeIndex = -1;
            openPanel();
        }

        function setActive(index) {
            const optionNodes = panel.querySelectorAll('.cbx-option');
            if (!optionNodes.length) { return; }
            activeIndex = ((index % optionNodes.length) + optionNodes.length) % optionNodes.length;
            optionNodes.forEach(function (node, position) {
                const active = position === activeIndex;
                node.classList.toggle('is-active', active);
                node.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            const current = optionNodes[activeIndex];
            input.setAttribute('aria-activedescendant', current.id);
            current.scrollIntoView({ block: 'nearest' });
        }

        function moveActive(delta) {
            const count = panel.querySelectorAll('.cbx-option').length;
            if (!count) { return; }
            const base = activeIndex < 0 ? (delta > 0 ? -1 : 0) : activeIndex;
            setActive(base + delta);
        }

        function renderMatches(rows) {
            matches = rows.slice(0, limit);
            panel.innerHTML = '';
            activeIndex = -1;

            matches.forEach(function (row, index) {
                const option = document.createElement('button');
                option.type = 'button';
                option.className = 'cbx-option';
                option.id = config.prefix + '_option_' + index;
                option.setAttribute('role', 'option');
                option.setAttribute('aria-selected', 'false');

                const avatar = document.createElement('span');
                avatar.className = 'cbx-option-avatar';
                avatar.innerHTML = '<i class="fa-solid fa-user-graduate" aria-hidden="true"></i>';

                const body = document.createElement('span');
                body.className = 'cbx-option-body';
                const label = document.createElement('span');
                label.className = 'cbx-option-label';
                label.textContent = normalize(row[keys.label]) || '—';
                const meta = document.createElement('span');
                meta.className = 'cbx-option-meta';
                const badge = document.createElement('span');
                badge.className = 'cbx-option-badge';
                badge.textContent = normalize(row[keys.value]);
                meta.appendChild(badge);
                if (row[keys.meta]) {
                    const extra = document.createElement('span');
                    extra.textContent = normalize(row[keys.meta]);
                    meta.appendChild(extra);
                }
                body.append(label, meta);

                const arrow = document.createElement('i');
                arrow.className = 'fa-solid fa-chevron-right cbx-option-arrow';
                arrow.setAttribute('aria-hidden', 'true');

                option.append(avatar, body, arrow);
                option.addEventListener('click', function () { choose(index); });
                option.addEventListener('mousemove', function () { setActive(index); });
                panel.appendChild(option);
            });

            openPanel();
        }

        function setSelection(row) {
            const value = normalize(row[keys.value]);
            const label = normalize(row[keys.label]) || 'Seleccionado';
            const meta = normalize(row[keys.meta]);

            hiddenControl.value = value;
            setSubmitEnabled(true);
            chipLabel.textContent = label;
            chipLabel.title = label;
            chipMeta.textContent = meta !== '' ? value + ' · ' + meta : value;
            chipMeta.title = chipMeta.textContent;
            chip.hidden = false;
            input.hidden = true;
            input.value = '';
            clearButton.hidden = false;
            matches = [];
            closePanel();
            setHint(messages.selected_state, 'ok');
        }

        function clearSelection(focusInput) {
            hiddenControl.value = '';
            setSubmitEnabled(false);
            chip.hidden = true;
            chipLabel.textContent = '';
            chipMeta.textContent = '';
            input.hidden = false;
            clearButton.hidden = true;
            matches = [];
            activeIndex = -1;
            closePanel();
            if (focusInput) { input.focus(); }
        }

        function choose(index) {
            const row = matches[index];
            if (!row) { return; }
            setSelection(row);
            if (submitButton) { submitButton.focus(); }
        }

        function buildUrl(query) {
            const params = new URLSearchParams(liveParams);
            params.set(config.queryParam, query);
            const separator = String(config.endpoint).indexOf('?') === -1 ? '?' : '&';
            return config.endpoint + separator + params.toString();
        }

        function fetchMatches(query) {
            const seq = ++requestSeq;
            renderState('fa-circle-notch', messages.searching, true);
            setHint(messages.hint_searching);

            fetch(buildUrl(query), { headers: { 'Accept': 'application/json' } })
                .then(function (response) {
                    if (!response.ok) { throw new Error('HTTP ' + response.status); }
                    return response.json();
                })
                .then(function (rows) {
                    if (seq !== requestSeq) { return; }
                    if (!Array.isArray(rows) || rows.length === 0) {
                        renderState('fa-circle-question', messages.no_results);
                        setHint(messages.hint_none, 'error');
                        return;
                    }
                    renderMatches(rows);
                    const total = Math.min(rows.length, limit);
                    setHint(total === 1 ? messages.hint_one : messages.hint_many.replace('%d', total));
                })
                .catch(function () {
                    if (seq !== requestSeq) { return; }
                    renderState('fa-triangle-exclamation', messages.error);
                    setHint(messages.hint_error, 'error');
                });
        }

        function scheduleSearch(query) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () { fetchMatches(query); }, 300);
        }

        input.addEventListener('input', function () {
            const query = normalize(this.value);
            lastQuery = query;
            hiddenControl.value = '';
            setSubmitEnabled(false);
            clearTimeout(debounceTimer);
            requestSeq++;

            if (query.length < minChars) {
                renderState('fa-magnifying-glass', messages.empty_state);
                setHint('');
                return;
            }
            scheduleSearch(query);
        });

        input.addEventListener('focus', function () {
            combo.classList.add('is-focused');
            if (matches.length) { openPanel(); }
        });

        input.addEventListener('blur', function () {
            combo.classList.remove('is-focused');
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                if (!isOpen() && matches.length) { openPanel(); }
                if (matches.length) { moveActive(event.key === 'ArrowDown' ? 1 : -1); }
                return;
            }
            if (event.key === 'Enter') {
                if (isOpen() && activeIndex >= 0) {
                    event.preventDefault();
                    choose(activeIndex);
                }
                return;
            }
            if (event.key === 'Escape' && isOpen()) {
                event.preventDefault();
                closePanel();
                return;
            }
            if (event.key === 'Tab') { closePanel(); }
        });

        toggleButton.addEventListener('click', function () {
            if (!input.hidden) {
                if (isOpen()) {
                    closePanel();
                    return;
                }
                input.focus();
                if (lastQuery.length >= minChars) {
                    scheduleSearch(lastQuery);
                } else {
                    renderState('fa-magnifying-glass', messages.empty_state);
                }
                return;
            }
            lastQuery = '';
            clearSelection(true);
            setHint(messages.change_state);
        });

        clearButton.addEventListener('click', function () {
            lastQuery = '';
            input.value = '';
            clearSelection(true);
            setHint('');
        });

        document.addEventListener('click', function (event) {
            if (!picker.contains(event.target)) { closePanel(); }
        });

        if (form && required) {
            form.addEventListener('submit', function (event) {
                if (hiddenControl.value) { return; }
                event.preventDefault();
                clearSelection(false);
                input.focus();
                setHint(messages.choose_first, 'error');
            });
        }

        if (config.initial && normalize(config.initial[keys.value]) !== '') {
            setSelection(config.initial);
            lastQuery = '';
            setHint(messages.loaded_state);
        }
    })();
</script>
