# Bitácora de cambios — Sistema Creditos

Este archivo registra cronológicamente todos los cambios, decisiones y pendientes del proyecto de migración al esquema `sit`. Entradas más recientes arriba.

## Estado actual

**Última entrada:** 2026-11-21 15:11 · **Entradas registradas:** 42 · **Último commit previo a esta sesión:** `cee9d6a` (2026-11-21 14:59).

**Verificaciones de cierre (última: 2026-11-21 13:45):**

| Verificación | Resultado |
|---|---|
| `php artisan test` (suite completa) | ✅ 17 passed, 62 assertions |
| Migración `2026_11_21_120000_remove_legacy_alumno_foreign_keys_from_creditos` | ✅ Ejecutada (batch 3) |
| FKs de `creditos` que apuntan a `creditos.alumnos` | ✅ 0 restantes (26 FK en total en el esquema) |
| `public/storage` (enlaces de evidencias) | ✅ Existe |
| Árbol de trabajo Git | ⚠️ Pendiente de commit al registrar esta entrada |
| Buscador de alumnos (`template.partes.buscador_combobox`) | ✅ 43 + 17 pruebas de interacción, 12 + 38 + 12 de render, capturas en 3 anchos |
| Reporte de avance sobre `sit.alumnos` | ✅ 21 + 12 pruebas con datos reales, 10 + 10 de render, 8 de sincronización; 1.11 s en el peor caso |
| Galería de evidencias | ✅ 7 pruebas del endpoint, 13 de render y 19 de DOM |
| Buscadores en evidencias | ✅ 10 pruebas de endpoints, 11 de render y 14 de integración |
| Jefes de carrera sobre SIT | ✅ 28 pruebas con datos reales, 12 de render y 8 de regresión |

### Riesgos abiertos

| # | Riesgo | Evidencia | Prioridad |
|---|---|---|---|
| 1 | Identidad académica aún duplicada: 13 controladores usan `App\Models\Alumno` (11) o la conexión `contEsc` (4) | `app/Http/Controllers/*` | Alta |
| 2 | SQL crudo con concatenación de `$busqueda` en `VerificaEvidenciaController::avanceAlumno()` (8 consultas); el reporte ya migró a SIT | Inyección SQL latente | Alta |
| 3 | Sin clave puente estable entre `sit.alumnos` y las tablas auxiliares de `creditos` (`personales`, `padres`, `direcciones`, `historiales_clinicos`); `id_alu` sobrevive sin FK | Verificación 2026-11-21 12:56 | Alta |
| 4 | Contraseña de prueba `Prueba123!` documentada y `PruebaActividadesSeeder` versionado | Entrada 2026-11-21 12:10 | Media |
| 5 | El login depende del CDN `mdb-ui-kit@9.3.0` (jsdelivr) mientras el resto usa assets locales | `resources/views/auth/login.blade.php` | Media |
| 6 | Cambios de interfaz sin validación en navegador autenticado | Lista siguiente | Media |
| 7 | `creditos.areas` y `sit.cat_carreras` no comparten id; la equivalencia se resuelve por nombre | `mapaCarreras()` en `VerificaEvidenciaController` | Media |
| 8 | `creditos.alumnos` está vacía (0 filas): el reporte ya usa `sit.alumnos`, pero avance, constancias y altas todavía leen esa tabla | Verificación 2026-11-21 13:45 | Alta |

### Validación visual pendiente

Estas entradas están marcadas como completadas pero su verificación en navegador sigue abierta:

- 2026-11-21 15:11 — Jefes de carrera migrado de contEsc a SIT
- 2026-11-21 14:57 — Encabezado de página en avance del alumno
- 2026-11-21 14:54 — Encabezado de página en verifica_evidencia
- 2026-11-21 14:52 — Encabezado de página en participantes
- 2026-11-21 14:48 — Filtros de evidencias con el buscador reutilizable
- 2026-11-21 14:27 — UX de la galería de evidencias
- 2026-11-21 14:15 — Filtros de reportes en cascada y sin campos obligatorios
- 2026-11-21 13:38 — Filtro de carreras unificado con el catálogo del SIT
- 2026-11-21 13:31 — Buscador de alumnos del SIT en reportes
- 2026-11-21 13:26 — UX de reportes con cards
- 2026-11-21 13:13 — Buscador de alumnos en un solo control (validado en vista previa estática, no en la app autenticada)
- 2026-11-21 11:49 — Corrección de actividades y participantes con alumnos SIT
- 2026-11-20 19:40 — UX moderna del módulo de mensajes
- 2026-11-20 19:30 — Actualización del menú principal con MDB y Font Awesome
- 2026-11-20 19:15 — Corrección definitiva de la vista Mis citas
- 2026-11-20 19:12 — Corrección de la vista Mis citas del alumno
- 2026-11-20 19:09 — Reingeniería frontend del área de alumno
- 2026-11-20 18:53 — Modernización UX de la entrada al sistema

### ADR pendientes

- ADR: identidad y autenticación de alumnos (`sit.users` frente a identidad propia de `creditos`).
- ADR: estrategia de claves de alumno (`id`, `no_control`, `user_id` y mapeo histórico).
- ADR: mapeo de `creditos.alumnos` a `sit.alumnos`.
- ADR: destino funcional de las 28 tablas de `creditos` sin equivalente en `sit`.
- ADR: conservación o migración de datos personales sensibles y credenciales.

## Convenciones de la bitácora

**Campos por entrada:** `Estatus`, `Agente`, `Módulo` y `Prompt/Tarea original`; después `Archivos modificados`, `Decisiones tomadas` y, de forma opcional, `Diagnóstico`, `Acción realizada`, `Datos creados`, `Consultas SQL`, `Archivos eliminados`, `Pendientes / Deuda técnica`, `Tests ejecutados` y `Referencias`.

**Estados:** `✅ completado` significa *implementado*, no necesariamente verificado en navegador. Esa verificación se sigue aparte en [Estado actual](#estado-actual) para no reescribir el historial. Cuando se agregue una entrada nueva, usar además `🚧 en progreso` o `❌ revertido` en lugar de forzar `✅`.

**Etiquetas de módulo:** las entradas conservan la etiqueta original con la que se registraron; el nombre canónico se indica en la tabla del índice.

### Componentes reutilizables

| Parcial | Uso |
|---|---|
| `template.partes.buscador_combobox` | Buscador con lista de coincidencias y acción integrada en un solo control |

Se invoca con `@include` y un arreglo `config`; todo lo demás tiene valores por defecto:

```blade
@include('template.partes.buscador_combobox', [
    'config' => [
        'id' => 'alumno',                                   // prefijo único de ids
        'title' => 'Buscar alumno',
        'description' => 'Escribe nombre o número de control.',
        'label' => 'Alumno',
        'action' => route('verifica_evidencia.avance_alumno'),
        'endpoint' => route('verifica_evidencia.alumnos_busqueda'),
        'field' => 'no_control',                            // input oculto del formulario
        'params' => ['peticion' => '0'],                    // parámetros extra del endpoint
        'query_param' => 'nombre',                          // parámetro que lleva la búsqueda
        'keys' => ['value' => 'no_control', 'label' => 'nombre', 'meta' => 'carrera'],
        'initial' => $alumnoInicial,                        // preselección opcional
        'submit_label' => 'Consultar avance',
    ],
])
```

Notas de implementación:

- El CSS viaja en `@push('styles')` + `@once`; el molde lo renderiza en el `head` mediante `@stack('styles')`, y se emite una sola vez aunque haya varias instancias.
- Cada instancia usa ids con prefijo (`{id}_combo`, `{id}_input`, `{id}_value`…) y su propio JavaScript con guard `cbxReady`, por lo que pueden convivir varias en una página.
- El endpoint debe responder JSON con una lista de objetos; `keys` mapea qué campo es el valor, la etiqueta y el metadato. Con `meta => ''` el chip muestra solo valor y etiqueta.
- Opciones de integración: `bare => true` renderiza solo el control (sin card ni formulario propios, para formularios existentes), `required => false` permite enviar sin selección, `show_submit => false` oculta el botón propio y `show_value => false` evita mostrar el id interno en el chip.
- El control expone `combo.cbxSetParams({ ... })` para actualizar en caliente los parámetros del endpoint; la vista de reportes lo usa para acoplar la carrera elegida a la búsqueda.
- También expone `combo.cbxSetSelection({ value, label, meta })` y `combo.cbxReset()`, y emite `change` en su input oculto al seleccionar o limpiar, para que la vista anfitriona reaccione sin acoplarse al componente.

**Para registrar una entrada nueva:**

1. Fecha y hora local (`America/Mexico_City`, UTC−6) en el encabezado, formato `### [YYYY-MM-DD HH:MM] — Título`.
2. Módulo canónico y agente responsable.
3. Hash de commit cuando el cambio ya esté versionado, o la nota de que quedó sin commit.
4. Si toca esquema: si la migración se ejecutó y en qué base.
5. Si el cambio es de interfaz: marcar explícitamente la validación en navegador como pendiente o realizada.

## Índice

- [Estado actual](#estado-actual)
- [Convenciones de la bitácora](#convenciones-de-la-bitácora)
- [Bitácora cronológica](#bitácora-cronológica)
- [Inventario inicial del sistema](#inventario-inicial-del-sistema)

| Módulo | Etiqueta en entradas | Entradas | Rango |
|---|---|---|---|
| Créditos complementarios | `créditos` | 25 | 2026-11-21 11:49 – 14:57 |
| Trayectoria académica | `trayectoria` | 6 | 2026-11-20 18:59 – 2026-11-21 15:11 |
| Infraestructura | `infraestructura` | 11 | 2026-11-20 18:32 – 2026-11-21 13:18 |
| Tutorías | — | 0 | Sin entradas registradas |

## Trazabilidad con Git

Las entradas históricas no citan hash de commit; esta tabla permite cruzarlas por fecha. Comprende desde el inicio del proyecto de migración.

| Commit | Fecha | Asunto |
|---|---|---|
| `cc5f3ed` | 2026-11-21 12:55 | Modernización UX de avance alumnos |
| `abdffe5` | 2026-11-21 12:43 | Actualización UX de créditos |
| `57cdaac` | 2026-11-21 11:55 | Corrige actividades y participantes contra SIT |
| `393701a` | 2026-11-21 11:32 | Actualización de la recuperación de contraseñas |
| `adebb03` | 2026-11-21 11:26 | Mejoras al inicio de sesión |
| `3b95a28` | 2026-11-20 19:42 | Actualización de la UX de mensajes |
| `6aea3e9` | 2026-11-20 19:38 | Actualización de footer |
| `73d549d` | 2026-11-20 19:33 | Actualización del menú a MDB y Font Awesome |
| `c9204de` | 2026-11-20 19:29 | Instalación de Font Awesome |
| `f22a82a` | 2026-11-20 19:16 | Reingeniería de las vistas del alumno y citas |
| `5d44fd5` | 2026-11-20 19:08 | Corrige carga SIT de la ficha académica |
| `4db0107` | 2026-11-20 19:03 | Unifica autenticación SIT y moderniza el login |
| `a2a0c10` | 2026-11-20 18:44 | Añade capa Eloquent de solo lectura para SIT |
| `a02fb92` | 2026-11-20 18:17 | Añade inventario inicial y bitácora de cambios |

## Bitácora cronológica

<!-- Las entradas van aquí, más recientes arriba -->

### [2026-11-21 15:11] — Jefes de carrera migrado de contEsc a SIT

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Migrar el módulo STA de la conexión `contEsc` (control escolar anterior) a la base nueva `sit`, empezando por el menú Jefes de carrera.

**Archivos modificados:**
- `app/Http/Controllers/JefesController.php` (reescrito sobre SIT; ya no usa `contEsc`)
- `app/Http/Controllers/VerificaEvidenciaController.php` (usa el servicio de carreras y elimina los helpers duplicados)
- `app/Services/Sit/CarrerasSitService.php` (nuevo: equivalencia área de créditos ↔ carrera SIT)

**Archivos eliminados:**
- Ninguno.

**Mapeo aplicado (contEsc → SIT):**

| contEsc | SIT |
|---|---|
| `carreras` (`car_Clave`, `car_Status`, `car_Nombre`) | `cat_carreras` (`id`, `activo`, `nombre`) |
| `alumnos` (`alu_NumControl`, `alu_Nombre`, `alu_Ape*`, `alu_SemestreAct`, `alu_StatusAct`, `alu_Sexo`, `Alu_AnioIngreso`) | `alumnos` (`no_control`, `semestre_actual`, `estatus`, `genero`, `anio_ingreso`) + `users` |
| `planesestudios` (`pes_CredTot`) | `cat_plan_estudios` (`creditos_totales`) |
| `cardex` (`cdx_Calif`, `cdx_SemXPrime`, `cdx_AnioXPrime`, `cdx_UltOpcAcred`) | `kardex` (`calificacion_final`, `semestre`, `periodo_id`, `opcion_acreditacion_numerico`) + `cat_materias` + `cat_periodos_escolares` |
| `listassemestre` / `listassemestrecom` | `listas` / `lista_unidades` |
| `grupossemestre` | `grupos` (`clave_grupo`, `materia_id`, `catedratico_id`) |
| `reticula` (`ret_NomCompleto`, `ret_NumUnidades`) | `cat_materias` (`nombre`, `num_temas`) |
| `catedraticos` (`cat_Nombre`, `cat_Ape*`) | `catedraticos` + `users` |

**Decisiones tomadas:**
- Las carreras del filtro salen de `cat_carreras`; para Jefes se consideran solo las activas (equivalente a `car_Status = 'VIGENTE'`) y para el reporte se mantienen todas.
- El estatus académico se traduce a las claves de la vista: Baja definitiva → `BD`, Baja temporal → `BT`, Egresado/Titulado → `EG`, resto → `VI`.
- El semáforo académico cuenta `opcion_acreditacion_numerico` (2 a 6), conservando los mismos números que usaba `cdx_UltOpcAcred`.
- El servicio social se detecta por `cat_materias.concepto = 'servicio_social'` en el kardex, en lugar de la lista de claves fija (720, 790…), que en SIT apunta a otras materias.
- Los créditos acumulados se suman desde `kardex.creditos_materia` con `acreditada = 1`, comparados contra `cat_plan_estudios.creditos_totales`.
- Las calificaciones parciales se deduplican por unidad tomando la última oportunidad, para que la vista siga mostrando una celda por unidad.
- Las observaciones del alumno se leen y escriben en `sit.alumnos.observaciones` (excepción deliberada a la política de solo lectura de SIT, a registrar en su ADR).
- La ficha toma la identidad de SIT y conserva las tablas socioeconómicas de `creditos` enlazadas por `no_control`.

**Pendientes / Deuda técnica:**
- `STAController` sigue con 18 consultas a `contEsc` (Profesor, Tutor y Departamento de tutorías); es el siguiente bloque a migrar.
- Los semáforos médico y psicológico no tienen fuente en SIT: se muestran en negro.
- `creditos.motivosreprobacion` está vacía; los comentarios se emparejan por materia y número de tema porque `lse_clave` ya no coincide.
- La ficha socioeconómica seguirá vacía mientras `creditos.alumnos` no tenga registros.

**Tests ejecutados:**
- ✅ 28 comprobaciones con datos reales de SIT (catálogo, generaciones, listado de 102 alumnos, diagnóstico con kardex y parciales, semáforos y observaciones con rollback).
- ✅ 12 comprobaciones de render en las dos vistas del módulo.
- ✅ 8 comprobaciones de regresión del reporte y del buscador, que comparten el servicio de carreras.
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).
- ✅ `grep contEsc` en `JefesController`: 0 ocurrencias.

**Referencias:**
- `docs/img/sta-jefes-desktop.png`

### [2026-11-21 15:03] — Diagnóstico de conexión del módulo STA

- **Estatus:** ✅ completado (diagnóstico; sin cambios de código)
- **Agente:** lead
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Probar el módulo STA empezando por el menú «Jefes de carrera» y reportar los problemas de conexión encontrados.

**Hallazgos:**
- La conexión `contEsc` (SQL Server) no puede abrirse: **PHP solo tiene los drivers `mysql` y `sqlite`**; no están instalados `pdo_sqlsrv`, `sqlsrv` ni ODBC.
- El PHP del entorno es **8.5.3 ZTS (thread-safe)**. Los drivers de Microsoft se publican para builds **NTS**, así que no basta con copiar el DLL: se requiere otro build de PHP (y probablemente una versión soportada por el driver).
- Faltan las variables `DB_HOST_SECOND`, `DB_PORT_SECOND`, `DB_DATABASE_SECOND`, `DB_USERNAME_SECOND` y `DB_PASSWORD_SECOND`. La configuración cae en los valores por defecto `forge`, y `.env` solo define `DB_SECOND_*` (que usa la conexión `sit`).
- No hay un SQL Server local: el puerto 1433 está cerrado y no existen servicios de SQL Server en la máquina.
- La conexión de respaldo `contEscMy` (MySQL) tampoco está configurada y no existe una base equivalente en MySQL (solo `creditos` y `sit`).

**Impacto:**
- Los cuatro ítems del menú STA fallan con `QueryException: could not find driver`: Jefes de carrera (`analisis.index`), Profesor, Tutor y Departamento de tutorías.
- `JefesController::index()`, `generacion()`, `diagnostico()`, `calSemaforos()` y los índices de `STAController` lanzan la excepción sin capturarla (HTTP 500).
- `JefesController::ficha()` la oculta con un `catch` genérico y muestra «A ocurrido un error», sin indicar la causa.
- `storeAlumnoObs()` responde 404 porque escribe observaciones en `creditos.alumnos`, que está vacía.

**Recomendaciones:**
- Opción A: instalar `pdo_sqlsrv` en un build de PHP NTS compatible y definir las variables `DB_*_SECOND` con el servidor real de control escolar.
- Opción B: migrar el módulo STA a `sit` (como ya se hizo en reportes) o a una réplica MySQL, y apuntar `contEsc`/`contEscMy` a esa base.
- Mientras no haya conexión, mejorar el manejo del error en `ficha()` y mostrar un mensaje que distinga «sin conexión» de «sin ficha».

**Pendientes / Deuda técnica:**
- El módulo STA depende de 35 consultas a `contEsc` (`JefesController` 17 y `STAController` 18) y no usa `sit` en ninguna.
- Decidir si `contEsc` seguirá siendo SQL Server o si el módulo migra a SIT.

**Tests ejecutados:**
- ✅ 4 comprobaciones de conexión (MySQL por defecto y `sit` funcionan; `contEsc` y `contEscMy` fallan).
- ✅ 7 acciones probadas: `index`, `generacion`, `diagnostico`, `ficha`, `calSemaforos`, `storeAlumnoObs` y los tres índices de `STAController`.

### [2026-11-21 14:57] — Encabezado de página en avance del alumno

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Agregar la descripción de la página en la vista de avance del alumno.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/avance_alumno.blade.php` (encabezado superior; el botón «Reportes» pasa a la cabecera de avance por créditos)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se agrega el encabezado con icono y «Avance del alumno» en `@section('ruta')`, igual que el resto del módulo.
- Se retira la tarjeta `advance-breadcrumb` porque duplicaba el título, junto con su CSS.
- El botón **«Reportes»** (que dependía de `ruta_data` con carrera y generación) se mueve a la cabecera de «Avance por créditos», junto a «Imprimir constancia», para no perder la vuelta al reporte con su contexto.
- No se tocaron el buscador de alumno, la tarjeta del alumno ni la tabla de avance.

**Pendientes / Deuda técnica:**
- Validar el encabezado y el botón en la app autenticada; la captura es de una vista previa estática.
- El enlace a reportes solo aparece cuando la vista llega con `ruta_data` (carrera y generación).

**Tests ejecutados:**
- ✅ 10 comprobaciones de render (encabezado, sin breadcrumb duplicado, buscador y tarjeta intactos, reportes con contexto, constancia y casos sin contexto).
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/avance-alumno-desktop.png`

### [2026-11-21 14:54] — Encabezado de página en verifica_evidencia

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Agregar la descripción de la página en el módulo `verifica_evidencia`, como en Evidencias y Participantes.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/index.blade.php` (encabezado con icono y breadcrumb; se retira la tarjeta de breadcrumb interna)
- `resources/views/admin/verifica_evidencia/ver_evidencia.blade.php` (encabezado con icono y enlace de regreso; se retira la tarjeta interna)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se aplica la misma estructura de Evidencias y Participantes: icono, enlace a la sección anterior y nombre de la página en `@section('ruta')`.
- El encabezado de `index` enlaza a Actividades solo cuando llega con `actividades_link = true`, igual que antes.
- Se eliminan las tarjetas `verification-breadcrumb` y `evidence-view-breadcrumb` porque duplicaban el encabezado, junto con su CSS.
- No se tocaron la tarjeta de control, el resumen, la tabla ni las acciones de validación.

**Pendientes / Deuda técnica:**
- `avance_alumno` conserva su tarjeta de breadcrumb porque incluye el botón contextual «Reportes» con carrera y generación.
- `reportes` ya tenía encabezado propio desde su rediseño.
- Validar los encabezados en la app autenticada; la captura es de una vista previa estática.

**Tests ejecutados:**
- ✅ 8 comprobaciones de render en ambas vistas (encabezado con icono, breadcrumb, sin tarjetas duplicadas y control/validación intactos).
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/verifica_evidencia-desktop.png`

### [2026-11-21 14:52] — Encabezado de página en participantes

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Agregar la descripción de la página (icono y nombre) en la vista de agregar participantes, como ya la tiene Evidencias.

**Archivos modificados:**
- `resources/views/admin/participantes/index.blade.php` (encabezado superior con icono y breadcrumb; se retira la tarjeta de breadcrumb interna)
- `resources/views/admin/participantes/evidencia.blade.php` (encabezado con icono y Font Awesome en lugar de la etiqueta legacy)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- `@section('ruta')` se llena con la misma estructura de Evidencias, reportes y avance: icono, enlace a la sección anterior y nombre de la página.
- Se elimina la tarjeta `participant-breadcrumb` porque repetía la misma información y su CSS quedó sin uso.
- La vista de evidencia de participantes cambia `label label-success` por el encabezado con icono, para dejar de usar estilos legacy.
- No se tocó el contenido ni el comportamiento de las tarjetas de asignación y de la tabla.

**Pendientes / Deuda técnica:**
- Quedan seis vistas con `@section('ruta')` vacía y, por tanto, sin encabezado superior: `admin/actividades/index` y las cinco de `admin/mensajes` (bandeja, crear, enviados, receptores, vistos).
- Validar el encabezado en la app autenticada; la captura es de una vista previa estática.

**Tests ejecutados:**
- ✅ 8 comprobaciones de render (encabezado con icono y enlace, sin breadcrumb duplicado, tarjetas y tabla intactas, vista de evidencia sin estilos legacy).
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/participantes-desktop.png`

### [2026-11-21 14:48] — Filtros de evidencias con el buscador reutilizable

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Reemplazar los selects de actividad y responsable por el buscador creado para búsquedas, sin cambiar la lógica del sistema.

**Archivos modificados:**
- `resources/views/admin/evidencias/index.blade.php` (buscadores en lugar de selects, con los selects originales ocultos)
- `app/Http/Controllers/EvidenciasController.php` (`buscarActividades()`, `buscarResponsables()` y extracción de `responsablesDeActividad()`)
- `routes/web.php` (rutas `evidencias.actividades_busqueda` y `evidencias.responsables_busqueda`)
- `resources/views/template/partes/buscador_combobox.blade.php` (evento `change`, `cbxSetSelection`, `cbxReset` y opción `show_value`)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna nueva: `buscarActividades()` reutiliza la consulta de `index()` y `buscarResponsables()` la de `peticionAjax()`, ahora extraída a `responsablesDeActividad()`.

**Decisiones tomadas:**
- Los dos `select` originales se conservan **ocultos** como fuente de verdad; los buscadores escriben en ellos y disparan los mismos eventos, por lo que la galería, las cookies y los permisos no cambian.
- Puente bidireccional: del buscador al select con el evento `change`, y del select al buscador con un `MutationObserver` que reacciona cuando se recargan los responsables y cuando se aplican las cookies.
- Cambiar de actividad actualiza los parámetros del buscador de responsables y limpia su selección.
- «Todos los responsables» se representa dejando el buscador vacío, que el puente traduce a `nulo` en el select oculto.
- El componente ahora emite `change` en su input oculto y expone `cbxSetSelection()` y `cbxReset()`, útiles para cualquier vista anfitriona.
- Se añadió `show_value => false` para que el chip no muestre el id interno (actividad/responsable), solo la etiqueta.
- La vista oculta el hint del componente porque se duplicaba; los errores de búsqueda siguen visibles en el panel.
- Hubo que regenerar la caché de rutas (`route:clear` y `route:cache`) para que las rutas nuevas existieran.

**Pendientes / Deuda técnica:**
- Validar en navegador con datos reales; la prueba de integración usa jQuery real y AJAX simulado.
- El buscador de responsables no devuelve resultados hasta elegir una actividad.
- Para usuarios sin privilegios, el endpoint de responsables sigue devolviendo solo su propio usuario, igual que antes.

**Tests ejecutados:**
- ✅ 10 comprobaciones de los endpoints de búsqueda (actividades, responsables, filtros, vacíos y contrato de `peticionAjax`).
- ✅ 11 comprobaciones de render (selects ocultos, buscadores, endpoints, puente y Observador).
- ✅ 14 comprobaciones de integración con jQuery real (selección, AJAX de la lógica original, galería, cookies y flujo inverso).
- ✅ `php artisan view:cache`, `route:cache` y `php artisan test` (17 passed, 62 assertions).
- ✅ Capturas a 1280 px y 500 px.

**Referencias:**
- `docs/img/evidencias-desktop.png`
- `docs/img/evidencias-movil.png`

### [2026-11-21 14:27] — UX de la galería de evidencias

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Mejorar la UX de la vista `/admin/evidencias` con MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/evidencias/index.blade.php` (reescritura: cards de filtros y galería, contadores, estados y tarjetas)
- `app/Http/Controllers/EvidenciasController.php` (`peticionGaleria()` toma el nombre del alumno de SIT)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Las dos consultas de `peticionGaleria()` dejan de hacer `leftjoin` a `creditos.alumnos` y lo hacen a `sit.alumnos` + `sit.users`, con el nombre completo concatenado.

**Decisiones tomadas:**
- La vista se organiza en dos cards: filtros y galería, con contadores de evidencias, PDF, imágenes y validadas.
- Las tarjetas de evidencia usan miniatura 4:3, badge de tipo (PDF/Imagen), badge de estado (Validada/Pendiente), metadatos con iconos y título sin extensión.
- El borrado pasa de una imagen a un botón accesible: aparece con hover, con foco de teclado y siempre en dispositivos sin hover.
- Se añaden estados de carga y de vacío con mensajes según la selección.
- El botón «Subir evidencia» se habilita solo con actividad y responsable elegidos, porque `create` exige ambos parámetros.
- `initProcesoEliminar()` usa `currentTarget` para que el clic funcione aunque se pulse el icono dentro del botón.
- La galería se vacía antes de cada recarga para no duplicar tarjetas.
- Se conservan todos los ids y contratos que usan el visor (`Viewer`), el lector PDF y el modal de eliminación.

**Corrección durante la validación con datos reales:**
- La tarjeta mostraba «Sin alumno asignado» en la evidencia de Congreso NEXUS aunque la actividad sí tiene alumnos. La causa: `EvidenciasController::store()` nunca llena `evidencia.alumno_no_control`, así que la evidencia pertenece a la **actividad**, y los alumnos viven en `participantes`.
- `peticionGaleria()` ahora devuelve `participantes_total` con el número de alumnos de la actividad, y la tarjeta muestra solo el conteo («Participante: 1», «Participantes: 500») porque listar cientos de nombres no es viable; conserva el alumno individual si la evidencia lo tuviera.
- El título de la tarjeta mostraba el nombre original del archivo (`1795059676`), que no dice nada al usuario. Ahora se usa una etiqueta legible: si el nombre trae texto se muestra humanizado («Constancia asistencia»); si es numérico o generado por la app se usa «Evidencia N»; el archivo real queda en el tooltip («Archivo: …»).

**Pendientes / Deuda técnica:**
- Validar en la app autenticada; la galería se verificó con datos simulados en vista previa porque solo existe una evidencia real en el entorno.
- El lector PDF depende de los archivos locales de `pdf.js` y `viewer.min.js`.
- `evidencia.alumno_no_control` existe en el esquema pero ningún flujo lo llena; conviene decidir si se elimina o si se usará para evidencias individuales.

**Tests ejecutados:**
- ✅ 7 comprobaciones del endpoint de galería con datos reales (claves, filtro por responsable, actividad sin evidencias y caso sin parámetros).
- ✅ 7 comprobaciones de participantes (total desde `participantes`, coincidencia con la base, sin nombres en el JSON y alumno individual nulo).
- ✅ 13 comprobaciones de render (ids del visor, contadores, estados, modales y botón de subida).
- ✅ 19 + 10 comprobaciones en jsdom (tarjetas, contadores, badges, metadatos, borrado, visor, vaciado y conteo de participantes, incluido el caso de 500).
- ✅ 10 comprobaciones del título de la tarjeta (nombres numéricos, generados, con guiones, sin nombre y tooltip con el archivo real).
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).
- ✅ Capturas a 1280 px y 500 px.

**Referencias:**
- `docs/img/evidencias-desktop.png`
- `docs/img/evidencias-movil.png`

### [2026-11-21 14:15] — Filtros de reportes en cascada y sin campos obligatorios

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Al dejar los filtros vacíos y elegir solo un alumno, el formulario obligaba a seleccionar una carrera. Los filtros deben respetar una jerarquía y ninguno debe ser obligatorio si se elige el último.

**Archivos modificados:**
- `app/Http/Controllers/VerificaEvidenciaController.php` (`reportes()` sin exigir carrera; listas dependientes de generación y carrera; `alumnosBusqueda()` acepta `anio`)
- `resources/views/admin/verifica_evidencia/reportes.blade.php` (selects sin `required`, opción «Todas las carreras», años desde SIT y sincronización de ambos filtros)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- `sit.alumnos` ahora se consulta con cualquier combinación de `carrera_id`, `anio_ingreso` y búsqueda; ninguna es obligatoria.
- Los años y carreras disponibles se obtienen con `distinct` sobre `sit.alumnos`, acotados por el otro filtro.

**Decisiones tomadas:**
- Generación y carrera dejan de ser obligatorias; se puede filtrar solo por alumno.
- Cascada al enviar el formulario: las carreras se acotan a las que tienen alumnos en la generación elegida y los años a los que existen en la carrera elegida.
- La cascada hacia el buscador es en vivo: al cambiar generación o carrera se actualizan los parámetros del endpoint (`anio` y `carrera`), sin recargar.
- Sin ningún filtro no se consulta la base; se muestra un estado vacío que invita a elegir al menos uno.
- El status sigue siendo un modificador: por sí solo no dispara la consulta, porque obligaría a recorrer los once mil alumnos del SIT.
- Los usuarios sin privilegios quedan acotados a sus carreras incluso cuando no eligen carrera, para que un `no_control` ajeno no exponga datos.

**Pendientes / Deuda técnica:**
- Las listas de generación y carrera se recalculan al pulsar «Filtrar»; no se refrescan en vivo como el buscador.
- El status no acota las opciones del buscador porque se deriva del avance en créditos, no de SIT.

**Tests ejecutados:**
- ✅ 12 comprobaciones con datos reales: solo alumno, solo generación, solo carrera, generación+carrera, cascada de carreras y de años, alumno dentro/fuera de la combinación, sin filtros y carrera inexistente.
- ✅ 10 comprobaciones de render (sin `required`, opción «Todas las carreras», años del SIT, parámetros y script de sincronización).
- ✅ 8 comprobaciones en jsdom de la sincronización en vivo al cambiar generación y carrera.
- ✅ `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/reportes-filtro-alumno.png` (solo alumno, sin generación ni carrera)
- `docs/img/reportes-desktop.png` (solo generación 2025)

### [2026-11-21 13:45] — Reporte de avance con fuente única sit.alumnos

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Corregir la consulta del reporte una vez aplicados los filtros para que dependa exclusivamente de `sit.alumnos`.

**Archivos modificados:**
- `app/Http/Controllers/VerificaEvidenciaController.php` (`reportes()` reescrito sobre SIT y nuevos helpers `alumnosReporte()`, `estadoReporte()` y `paginarReporte()`)
- `resources/views/admin/verifica_evidencia/reportes.blade.php` (paginador, resumen desde el controlador, sin la marca «sin datos»)

**Archivos eliminados:**
- Las ocho consultas SQL crudas que leían `creditos.alumnos`, `creditos.areas` y concatenaban los filtros.

**Consultas SQL nuevas o modificadas:**
- Alumnos: `SitAlumno::with(['user','carrera'])->where('carrera_id', …)->where('anio_ingreso', …)` sobre `sit.alumnos`.
- Progreso: lectura de `creditos.avance` por `no_control` (sin identidad de alumno).
- Catálogo: `creditos.creditos` para los nombres y el total de créditos.

**Decisiones tomadas:**
- La identidad del alumno sale solo de SIT: `sit.alumnos` + nombres de `sit.users` + carrera de `sit.cat_carreras`. `creditos.avance` se usa únicamente como progreso.
- La generación ahora se filtra por `anio_ingreso` y ya no por el prefijo de `no_control`, porque en SIT convive más de un formato (`00030001`, `A25030002`, `G23030330`).
- La búsqueda aplica a `no_control` y a nombre/apellidos de `sit.users`.
- El estado se deriva: **Baja** si el estatus académico de SIT contiene «Baja»; **Liberado** si la suma de créditos alcanza el total; **Pendiente** en el resto.
- El resumen se calcula en el controlador y se muestra junto a la etiqueta «fuente: sit.alumnos».
- Se pagina a **10 alumnos por página** (valor por defecto) y el detalle por crédito se arma solo para la página visible, para no generar miles de filas.
- El paginador es un control propio en español (Anterior / Página X de Y / Siguiente) porque el proyecto no tiene archivos de idioma y el del framework salía en inglés.
- Desaparece la marca «(sin datos)»: cualquier carrera del SIT puede listar alumnos aunque no tenga área equivalente en créditos.

**Rendimiento medido (carrera con más alumnos, sin filtro de año):**

| Carrera | Alumnos | Filas de detalle | Tiempo |
|---|---|---|---|
| 2 (Industrial) | 2,763 | 50 (solo página) | 1.11 s |
| 3 (Sistemas), 2025 | 102 | 50 | 0.04 s |

**Pendientes / Deuda técnica:**
- `creditos.avance` sigue siendo la única fuente de progreso; solo tiene 1 fila en este entorno, por lo que casi todos los alumnos aparecen en 0%.
- El promedio del resumen incluye a los alumnos dados de baja; conviene decidir si debe excluirlos.
- La búsqueda de `alumnosBusqueda` para usuarios sin privilegios todavía usa la equivalencia por nombre entre `creditos.areas` y `sit.cat_carreras`.
- El reporte ya no usa `creditos.alumnos`, pero otros flujos del módulo (avance, constancias, altas) siguen dependiendo de esa tabla.

**Tests ejecutados:**
- ✅ 21 comprobaciones con datos reales del SIT (total por carrera, paginación de 10, suma de avance real, búsqueda por nombre y control, estado derivado, carrera inexistente y caso sin filtros).
- ✅ 10 comprobaciones de render con datos reales (50 tarjetas, paginador, KPIs, fuente).
- ✅ `php artisan test` (17 passed, 62 assertions).
- ✅ Capturas a 1280 px y 500 px.

**Referencias:**
- `docs/img/reportes-desktop.png`
- `docs/img/reportes-movil.png`

### [2026-11-21 13:38] — Filtro de carreras unificado con el catálogo del SIT

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Conectar el filtro de carreras de reportes con el catálogo de carreras del SIT y omitir las carreras del sistema de créditos.

**Archivos modificados:**
- `app/Http/Controllers/VerificaEvidenciaController.php` (catálogo SIT en `reportes()`, mapeo bidireccional área↔carrera, homologación del nombre mostrado, endpoint con id SIT y alcance por área traducido)
- `resources/views/admin/verifica_evidencia/reportes.blade.php` (select con carreras del SIT, etiqueta corta, `title` con el nombre completo y marca de carreras sin datos)
- `resources/views/template/partes/buscador_combobox.blade.php` (`title` en el chip para texto truncado)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- El filtro de carrera ya no usa `Area::Carreras()`: se alimenta de `sit.cat_carreras`.
- Las consultas del reporte se conservan; el id SIT se traduce al área de créditos equivalente antes de interpolar.

**Decisiones tomadas:**
- Un solo catálogo visible: `sit.cat_carreras` (12 carreras, incluidas las que no tienen área en créditos).
- Como el reporte sigue leyendo `creditos.alumnos.carrera`, la equivalencia se resuelve por nombre normalizado (minúsculas, sin acentos) y no por id.
- Una carrera del SIT sin área equivalente devuelve un reporte vacío y se marca «(sin datos)» en el select, para no aparentar resultados que no existen.
- El nombre de carrera de cada tarjeta se homologa al del SIT.
- El endpoint de búsqueda recibe ahora el id del catálogo SIT directamente.
- Se amplió el permiso de `alumnosBusqueda` con `VIP_REPORTES|VER_REPORTES_CARRERA`, porque los usuarios de solo reportes no podían consultar el buscador (403).
- El alcance por área de los usuarios sin privilegios se traduce a carreras SIT; antes comparaba `areas.id` contra `carrera_id` de SIT, que son catálogos distintos.

**Pendientes / Deuda técnica:**
- `creditos.alumnos` está **vacía** (0 filas) en este entorno: el reporte no puede mostrar datos reales hasta migrar o poblar esa tabla.
- Las consultas de `reportes()` siguen concatenando `$busqueda` en SQL crudo (riesgo 2 del [Estado actual](#estado-actual)).
- La equivalencia depende del nombre: si SIT renombra un programa, hay que ajustar la comparación.
- La marca «(sin datos)» es estática al cargar la página; no se recalcula al cambiar de filtros.

**Tests ejecutados:**
- ✅ 10 comprobaciones de extremo a extremo con filas temporales en `creditos.alumnos` (filtro por carrera SIT, exclusión de otras carreras, homologación de nombre, carrera sin área, endpoint acotado y limpieza posterior).
- ✅ 12 comprobaciones de render del catálogo SIT (12 opciones, etiquetas cortas, `title`, marca «(sin datos)», parámetros del buscador).
- ✅ `php artisan view:cache` y `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/reportes-desktop.png`
- `docs/img/reportes-movil.png`

### [2026-11-21 13:31] — Buscador de alumnos del SIT en reportes

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Sustituir el filtro de número de control por el buscador reutilizable y conectarlo con la base de alumnos del SIT.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/reportes.blade.php` (el campo de control pasa a ser el buscador)
- `app/Http/Controllers/VerificaEvidenciaController.php` (alumno preseleccionado en `reportes()`; carrera opcional y equivalencia de catálogos en `alumnosBusqueda()`)
- `resources/views/template/partes/buscador_combobox.blade.php` (opciones `bare` y `required`, método `cbxSetParams`, ids con mayúsculas preservadas)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna consulta nueva: la búsqueda usa `SitAlumno` (`sit.alumnos`) a través del endpoint existente `verifica_evidencia.alumnos_busqueda`.
- Las consultas del reporte no se tocaron.

**Decisiones tomadas:**
- El buscador reutiliza el endpoint SIT ya existente; no se creó un endpoint paralelo.
- El valor enviado sigue siendo `busqueda`, así el controlador y sus filtros no cambian de contrato.
- La selección es opcional (`required => false`): sin alumno, el reporte filtra solo por generación/carrera.
- Se usa el modo `bare` para no anidar formularios; el botón «Filtrar» del reporte sigue siendo el único submit.
- El componente expone `cbxSetParams` y la vista sincroniza la carrera elegida con la búsqueda, para no listar alumnos de otra carrera.
- `creditos.areas` y `sit.cat_carreras` no comparten id (Sistemas es 1 en créditos y 3 en SIT): la equivalencia se resuelve por nombre normalizado; si no hay equivalente se devuelve vacío en lugar de mezclar carreras.

**Pendientes / Deuda técnica:**
- El reporte sigue leyendo `creditos.alumnos`: un alumno presente en SIT pero ausente en créditos no aparecerá en los resultados.
- Las consultas de `reportes()` siguen concatenando `$busqueda` en SQL crudo (riesgo 2 del [Estado actual](#estado-actual)).
- La equivalencia de carreras depende del nombre: si SIT renombra un programa, hay que ajustar la comparación.
- El alcance por área para usuarios sin privilegios en `alumnosBusqueda()` sigue usando `areas.id` como si fuera `carrera_id` de SIT.

**Tests ejecutados:**
- ✅ 38 comprobaciones de render en cuatro escenarios (con datos, sin filtros, sin resultados y con alumno preseleccionado).
- ✅ 17 comprobaciones de interacción en jsdom (búsqueda, parámetros, selección, envío opcional, limpieza y `cbxSetParams`).
- ✅ Endpoint contra SIT real: 11,300 alumnos, máximo 5 resultados y carrera 1 devolviendo solo Sistemas.
- ✅ Mapeo verificado de las 7 carreras de créditos contra `sit.cat_carreras`.
- ✅ `php artisan test` (17 passed, 62 assertions).

**Referencias:**
- `docs/img/reportes-filtro-alumno.png`
- `docs/img/reportes-desktop.png`

### [2026-11-21 13:26] — UX de reportes con cards

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Mejorar la UX de `admin/verifica_evidencia/reportes` con MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/reportes.blade.php` (reescritura completa: filtros, resumen, tarjetas por alumno y modales)

**Archivos eliminados:**
- Modal jQuery `#alerta` y el espaciador de `200px` por alumno del diseño anterior.

**Consultas SQL nuevas o modificadas:**
- Ninguna; la vista consume los mismos datos del controlador.

**Decisiones tomadas:**
- Tres bloques: card de filtros, card de resumen con KPIs y tarjetas por alumno.
- El resumen calcula alumnos, liberados, en proceso, sin avance y promedio a partir de los datos ya cargados.
- El avance se calcula como créditos × 100 en lugar del `500` fijo anterior, así no se rompe si cambia el número de créditos.
- La constancia aparece con `puntos >= puntosTotales`, no con la comparación contra la cadena `'500'`.
- El detalle del modal se agrupa por `no_control` en una sola pasada, en lugar del índice compartido entre tarjetas.
- Los estados vacíos distinguen «sin filtros» de «sin resultados».
- Se eliminan los ids duplicados de los formularios por alumno.

**Pendientes / Deuda técnica:**
- Validar en la app autenticada con datos reales.
- Los colores de status dependen de los valores `liberado`, `pendiente` y `baja`; otros valores caen en un badge neutro.

**Tests ejecutados:**
- ✅ `php artisan view:cache`.
- ✅ Comprobaciones de render con datos simulados (progresos, KPIs, badges, modales y permisos).
- ✅ Capturas a 1280 px y 500 px.

**Referencias:**
- `docs/img/reportes-desktop.png`
- `docs/img/reportes-movil.png`

### [2026-11-21 13:20] — Buscador reutilizable en template/partes

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Extraer el buscador integrado a un parcial reutilizable en `template/partes` y consumirlo desde la vista con `@include`.

**Archivos modificados:**
- `resources/views/template/partes/buscador_combobox.blade.php` (creado: componente con estilos, marcado y comportamiento)
- `resources/views/admin/verifica_evidencia/avance_alumno.blade.php` (de 480 a ~150 líneas; el buscador se reemplaza por un `@include`)
- `resources/views/template/molde.blade.php` (nuevo `@stack('styles')` en el `head`)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna; el endpoint se recibe por configuración.

**Decisiones tomadas:**
- El parcial es autónomo: recibe un arreglo `config` con valores por defecto y no depende de variables de la vista.
- Los `id` se generan con prefijo configurable, así que varias instancias pueden convivir en la misma página.
- El CSS se emite con `@push('styles')` + `@once` y el molde lo coloca en el `head`; se renderiza una sola vez aunque haya varias instancias.
- El JS de cada instancia se autoinicializa con guard `cbxReady` y no filtra variables globales.
- Las claves del JSON (`value`, `label`, `meta`) y los parámetros del endpoint son configurables, para reutilizarlo con alumnos, responsables, actividades u otros catálogos.
- El botón de acción es opcional (`show_submit`), pensado para usos donde la acción se dispara de otra forma.

**Pendientes / Deuda técnica:**
- Validar el componente en la app autenticada; sigue verificado con vista previa estática y datos simulados.
- Documentar en el `Estado actual` nuevos usos cuando se adopte en otras vistas.

**Tests ejecutados:**
- ✅ `php artisan view:cache`.
- ✅ 12 comprobaciones de render, incluida la doble instancia con ids únicos y CSS emitido una sola vez.
- ✅ 43 comprobaciones de interacción en jsdom sobre el componente extraído.
- ✅ `php artisan test` (17 passed, 62 assertions).
- ✅ Capturas a 1280 px, 720 px y 500 px del componente renderizado.

**Referencias:**
- `docs/img/buscador-alumnos-desktop.png`
- `docs/img/buscador-alumnos-seleccion.png`
- `docs/img/buscador-alumnos-movil.png`
- Convenciones → Componentes reutilizables

### [2026-11-21 13:18] — Suite completa de pruebas desbloqueada

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Detectado al verificar el componente: `php artisan test` abortaba antes de ejecutar cualquier prueba.

**Diagnóstico:**
- `tests/Pest.php` aplica `Tests\TestCase` a `Feature` y `Unit`.
- `tests/Unit/Sit/ReadOnlyModelsTest.php` volvía a declarar `uses(TestCase::class)`, y Pest aborta con «Test case [Tests\TestCase] can not be used… already uses the test case».
- El fallo afectaba también a la ejecución individual de ese archivo, aunque la entrada 2026-11-20 18:32 registró «5 passed, 26 assertions».

**Acción realizada:**
- Se eliminó el `uses(TestCase::class)` duplicado y su `import` del archivo de pruebas.

**Resultado:**
- `php artisan test` → 17 passed, 62 assertions.

**Pendientes / Deuda técnica:**
- Confirmar por qué la entrada del 18:32 reportó esa ejecución; probablemente el archivo se ejecutó con otra configuración de Pest o antes de agregar `tests/Pest.php`.

**Tests ejecutados:**
- ✅ `php artisan test` (17 passed, 62 assertions).

### [2026-11-21 13:13] — Buscador de alumnos en un solo control

- **Estatus:** ✅ completado
- **Agente:** lead
- **Módulo:** créditos
- **Prompt/Tarea original:** Integrar el buscador y el botón «Consultar avance» en un único control, manteniendo MDB, Font Awesome 7 y la estructura de cards.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/avance_alumno.blade.php` (combobox único con búsqueda, selección y acción; sin campo ni select separados)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna; se reutiliza `verifica_evidencia.alumnos_busqueda` (`SitAlumno`, límite 5 y filtro por carrera según permisos).

**Decisiones tomadas:**
- El campo de búsqueda, el selector de coincidencias y el botón de consulta viven dentro de un mismo contenedor con borde y foco compartidos.
- No se usa el componente `Select` de MDB: el bundle local 9.3.0 no lo incluye; el combobox se resuelve con MDB/Bootstrap y JavaScript propio.
- Al elegir un alumno, el control muestra un chip con nombre, número de control y carrera; la acción se habilita y el foco pasa al botón.
- La selección no envía el formulario por sí sola: el envío lo decide el usuario.
- Lista vacía, error de red y respuesta obsoleta tienen estados explícitos; el envío sin selección se cancela con aviso.
- Breakpoints: el botón comparte línea hasta 576 px y se apila a ancho completo por debajo.

**Pendientes / Deuda técnica:**
- Validar en la app autenticada contra `sit.alumnos` real; la verificación actual es con vista previa estática y datos simulados.
- `VerificaEvidenciaController::avanceAlumno()` sigue con SQL crudo concatenado (riesgo 2 del [Estado actual](#estado-actual)).

**Tests ejecutados:**
- ✅ `php artisan view:cache` (todas las vistas compilan).
- ✅ Render real de la vista con datos de prueba: 12 comprobaciones de estructura.
- ✅ 47 comprobaciones de interacción en jsdom (debounce, teclado, chip, guard de envío, errores y descarte de respuestas obsoletas).
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (10 passed, 34 assertions).
- ✅ Capturas a 1280 px, 720 px y 500 px de ancho.

**Referencias:**
- `docs/img/buscador-alumnos-desktop.png`
- `docs/img/buscador-alumnos-seleccion.png`
- `docs/img/buscador-alumnos-movil.png`

### [2026-11-21 12:45] — UX de avance con buscador integrado

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Modernizar el avance de alumno y agregar un buscador con coincidencias por nombre o número de control.

**Archivos modificados:**
- `app/Http/Controllers/VerificaEvidenciaController.php` (búsqueda desde `sit.alumnos`)
- `resources/views/admin/verifica_evidencia/avance_alumno.blade.php`

**Decisiones tomadas:**
- Se muestran máximo cinco coincidencias.
- El buscador consulta nombre, apellido y número de control.
- La selección llena el número de control oculto para consultar el avance.
- Los datos se presentan mediante cards MDB/Font Awesome.

### [2026-11-21 12:39] — Validación inline desde la evidencia

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Agregar un botón para validar la evidencia desde su vista de visualización.

**Archivos modificados:**
- `app/Http/Controllers/VerificaEvidenciaController.php`
- `resources/views/admin/verifica_evidencia/ver_evidencia.blade.php`

**Decisiones tomadas:**
- El botón aparece solo para usuarios con permiso o para el validador asignado.
- Una evidencia ya validada muestra estado deshabilitado.
- La acción reutiliza `verifica_evidencia.store` con `id_evidencias[]`.

### [2026-11-21 12:33] — Evidencia PDF accesible mediante storage

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** créditos
- **Prompt/Tarea original:** Investigar el enlace roto de `credITSCH_1795285595_0.pdf`.

**Diagnóstico:**
- El archivo sí existe físicamente en `storage/app/public/evidencias/Congreso NEXUS/credITSCH_1795285595_0.pdf`.
- El enlace público fallaba porque no existía `public/storage`.

**Acción realizada:**
- Ejecutado `php artisan storage:link`.
- Verificada la URL `/storage/evidencias/Congreso%20NEXUS/credITSCH_1795285595_0.pdf`.

**Resultado:**
- HTTP 200, Content-Type `application/pdf`, tamaño 41455 bytes.

### [2026-11-21 12:30] — UX inline de evidencias verificadas

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Modernizar `admin/verifica_evidencia/{id}/ver_evidencia` con MDB, Font Awesome, cards y visualizador PDF inline.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/ver_evidencia.blade.php`
- `docs/BITACORA.md`

**Decisiones tomadas:**
- Se usan cards para información, imagen/PDF y acciones.
- Los PDF se renderizan con PDF.js local y controles de página.
- Las imágenes se muestran inline y mantienen abrir/descargar.

### [2026-11-21 12:27] — UX moderna de verificación de evidencias

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Modernizar `admin/verifica_evidencia` con MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/verifica_evidencia/index.blade.php`

**Decisiones tomadas:**
- Se añadieron cards de filtros, resumen y tabla.
- Se reemplazó la selección antigua por switches MDB/Bootstrap.
- Se conservaron el formulario de validación, búsqueda y permisos existentes.

### [2026-11-21 12:24] — UX moderna de carga de evidencias

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Modernizar la vista de creación de evidencias con MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/evidencias/create.blade.php`

**Decisiones tomadas:**
- Se conservaron los nombres de campos usados por `EvidenciasController::store()`.
- Se creó una card de contexto y una card de carga de archivos.
- Se mantiene soporte para PDF, JPG, JPEG y PNG.
- Se eliminó la dependencia visual del plugin antiguo para el contenedor principal.

### [2026-11-21 12:21] — UX moderna de participantes

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Mejorar la vista de participantes con MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/participantes/index.blade.php`

**Decisiones tomadas:**
- Se organizaron actividad, responsable y alumno en una card de controles.
- Se añadió resumen visual de evidencias y validación.
- Se creó una card separada para la tabla de participantes.
- Se conservaron IDs, formularios y callbacks AJAX existentes.

### [2026-11-21 12:10] — Datos de prueba para responsables y actividades

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** créditos
- **Prompt/Tarea original:** Crear y ejecutar un seeder con 10 usuarios administrativos/docentes y 10 actividades de prueba.

**Archivos modificados:**
- `database/seeders/PruebaActividadesSeeder.php`
- `composer.json` (namespace `Database\Seeders`)
- `docs/BITACORA.md`

**Datos creados:**
- 10 usuarios activos con correos `responsable1@prueba.itsch.mx` a `responsable10@prueba.itsch.mx`.
- Contraseña compartida de prueba: `Prueba123!`.
- Rol `Responsable de Prueba` con permisos de responsables, participantes y evidencias.
- 10 actividades vigentes con 10% de liberación y fechas de cierre futuras.

**Verificaciones:**
- ✅ 10 usuarios activos fuera del administrador principal.
- ✅ 10 asignaciones al rol responsable.
- ✅ 10 actividades vigentes creadas.

### [2026-11-21 12:07] — Fuente de datos para responsables

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** créditos
- **Prompt/Tarea original:** Restaurar la lista de administrativos/docentes para asignar responsables.

**Archivos modificados:**
- `app/Http/Controllers/ResponsablesController.php` (listado desde `creditos.users`)
- `resources/views/admin/actividades/responsablesindex.blade.php` (combobox restaurado)

**Decisiones tomadas:**
- Fuente correcta: usuarios activos de `creditos.users`.
- La asignación se almacena en `actividad_evidencia.user_id`, por lo que cada responsable debe existir en `creditos.users`.
- Se excluye al usuario administrador principal `id = 1`.
- No se usan permisos para filtrar la lista; se muestran todos los usuarios activos disponibles.

**Pendientes / Deuda técnica:**
- La base actual solo contiene el usuario administrador activo, por lo que no aparecerán otros responsables hasta registrar/crear usuarios administrativos o docentes en `creditos.users`.

### [2026-11-21 12:05] — Restauración del selector de responsables

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Recuperar el selector para buscar administrativos o docentes al asignar responsables.

**Archivos modificados:**
- `resources/views/admin/actividades/responsablesindex.blade.php`

**Decisiones tomadas:**
- Se añadió un `<select>` MDB con los mismos usuarios elegibles mostrados en la tarjeta.
- La selección del combobox sincroniza el switch correspondiente.
- Los usuarios inactivos o bloqueados aparecen deshabilitados.

### [2026-11-21 12:00] — UX de asignación de responsables

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Mejorar la UX de agregar responsables usando MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/actividades/responsablesindex.blade.php`
- `resources/views/admin/actividades/responsableshow.blade.php`

**Archivos eliminados:**
- Ninguno.

**Decisiones tomadas:**
- Se separaron breadcrumb, cabecera de control y listado con cards.
- Se reemplazaron checkboxes antiguos por switches MDB/Bootstrap.
- Se añadieron iconos Font Awesome y estados visuales activos/bloqueados.
- Elimina responsable ahora usa el método DELETE de Laravel.

### [2026-11-21 11:56] — UX moderna de actividades

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** créditos
- **Prompt/Tarea original:** Mejorar la UX de las vistas de actividades usando MDB, Font Awesome y cards.

**Archivos modificados:**
- `resources/views/admin/actividades/index.blade.php`
- `resources/views/admin/actividades/create.blade.php`
- `resources/views/admin/actividades/edit.blade.php`

**Archivos eliminados:**
- Ninguno.

**Decisiones tomadas:**
- Se añadieron cards para filtros, formularios y tablas.
- El filtro de actividades cerradas usa un switch MDB/Bootstrap.
- Se conservaron rutas, campos y permisos existentes.

### [2026-11-21 11:49] — Corrección de actividades y participantes con alumnos SIT

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** créditos
- **Prompt/Tarea original:** Aplicar las correcciones detectadas en la prueba de creación de actividades y alta de alumnos, usando `sit.alumnos` como única fuente.

**Archivos modificados:**
- `app/Http/Controllers/ParticipantesController.php` (búsqueda, validación y lectura de alumnos desde SIT)
- `app/Http/Controllers/ActividadesController.php` (validación de creación/edición y corrección de nombre duplicado)
- `routes/web.php` (eliminación de rutas destructivas GET y nombres duplicados)
- `resources/views/admin/actividades/index.blade.php` (eliminación de actividad mediante DELETE)
- `resources/views/admin/participantes/index.blade.php` (eliminación de participantes mediante DELETE)
- `database/migrations/2026_11_21_120000_remove_legacy_alumno_foreign_keys_from_creditos.php`
- `docs/BITACORA.md`

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Participantes se valida contra `sit.alumnos.no_control`.
- Datos de nombre y carrera se obtienen desde `sit.users` y `sit.cat_carreras`.
- `creditos.avance` y `creditos.participantes` dejaron de depender de FKs hacia `creditos.alumnos`.

**Decisiones tomadas:**
- `sit.alumnos` es la única fuente de identidad académica.
- No se modifican ni recalculan datos de alumno en SIT.
- Las eliminaciones de actividades y participantes usan métodos HTTP DELETE.
- Se eliminaron rutas con nombres duplicados que impedían `route:cache`.

**Pendientes / Deuda técnica:**
- Validar visualmente la asignación masiva de alumnos en un navegador autenticado.
- Completar migración de los demás controladores que todavía consultan `creditos.alumnos`.

**Tests ejecutados:**
- ✅ Prueba controlada de creación y alta SIT (actividad creada, participante agregado y datos temporales eliminados).
- ✅ `php artisan route:cache`.
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (10 passed, 34 assertions).

### [2026-11-21 11:27] — Recuperación de contraseña unificada

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Actualizar el módulo de recuperación de contraseña para reconocer alumnos de `sit` y administrativos de `creditos`.

**Archivos modificados:**
- `app/Http/Controllers/PerfilController.php` (detección administrativa/SIT, enlace institucional y bloqueo de escritura a SIT)
- `resources/views/auth/passwords/email.blade.php` (interfaz MDB/Font Awesome moderna)
- `resources/views/auth/passwords/reset.blade.php` (interfaz moderna y controles de contraseña)
- `tests/Feature/Auth/UnifiedLoginTest.php` (casos administrativos y alumnos)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Búsqueda administrativa en `creditos.users`.
- Búsqueda de alumno activo y perfil en `sit.users` y `sit.alumnos`.
- Generación de token únicamente para usuarios administrativos en `creditos.password_resets`.

**Decisiones tomadas:**
- Los alumnos activos se redirigen a `https://sit.cdhidalgo.tecnm.mx/auth/recuperar-password`.
- No se genera ni ejecuta actualización de contraseña contra `sit.users`.
- El restablecimiento local requiere mayúscula, dígito y carácter especial.

**Pendientes / Deuda técnica:**
- Validar el correo institucional del portal SIT desde el entorno real.
- Revisar expiración y limpieza automática de tokens locales.

**Tests ejecutados:**
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (10 passed, 34 assertions)

### [2026-11-20 19:40] — UX moderna del módulo de mensajes

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Modernizar las vistas de mensajes con MDB y Font Awesome y corregir el error DataTables por cantidad incorrecta de columnas.

**Archivos modificados:**
- `resources/views/admin/mensajes/bandeja.blade.php`
- `resources/views/admin/mensajes/crear.blade.php`
- `resources/views/admin/mensajes/ver.blade.php`
- `resources/views/admin/mensajes/enviados.blade.php`
- `resources/views/admin/mensajes/vistos.blade.php`
- `resources/views/admin/mensajes/receptores.blade.php`
- `resources/views/template/molde.blade.php` (estilos compartidos de mensajes)
- `docs/BITACORA.md`

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se eliminó la inicialización DataTables conflictiva de bandeja y vistos.
- Las tablas usan estructura HTML responsive estable con 5 y 4 columnas alineadas.
- Se conserva SweetAlert y las rutas existentes de mensajes.
- Se reutilizan MDB/Bootstrap y Font Awesome 7.3.1 locales.

**Pendientes / Deuda técnica:**
- Evaluar volver a activar DataTables con una configuración global solo después de estabilizar columnas y datos.
- Validar el envío masivo de destinatarios en navegador.

### [2026-11-20 19:38] — Footer ampliado y redes del creador

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Aumentar visualmente el footer del sistema y agregar enlaces a las redes sociales del creador.

**Archivos modificados:**
- `resources/views/template/molde.blade.php` (footer de mayor altura, identidad institucional, redes sociales y monitor Git)
- `docs/BITACORA.md` (registro del cambio)

**Archivos eliminados:**
- Ninguno.

**Decisiones tomadas:**
- Se conservaron los perfiles conocidos de Facebook, LinkedIn, GitHub y sitio web del creador.
- Todos los enlaces externos usan `target="_blank"` y `rel="noopener noreferrer"`.
- El footer mantiene una distribución responsive en escritorio y móvil.

**Pendientes / Deuda técnica:**
- Confirmar enlaces actuales de Facebook y GitHub si cambian las cuentas del creador.
- Sustituir enlaces sociales por perfiles configurables desde administración si se requiere.

### [2026-11-20 19:34] — Footer moderno y monitor de actualizaciones Git

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Modernizar el footer del sistema y agregar un indicador de última actualización conectado a los commits Git locales.

**Archivos modificados:**
- `app/Providers/AppServiceProvider.php` (comparte datos seguros del último commit con el molde)
- `routes/web.php` (endpoint JSON `/system/update-status`)
- `resources/views/template/molde.blade.php` (footer responsive, monitor y refresco cada 60 segundos)
- `docs/BITACORA.md` (registro del cambio)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna; el monitor usa `git log -1` local y cachea la información durante cinco minutos.

**Decisiones tomadas:**
- Se muestran únicamente hash corto, fecha y mensaje del último commit.
- El navegador refresca el monitor cada minuto sin recargar la página.
- Se mantiene MDB/Bootstrap 5 y Font Awesome 7.3.1.

**Pendientes / Deuda técnica:**
- Si el repositorio se despliega sin `.git`, el monitor debe mostrar “Información no disponible”.
- Considerar consultar el último commit remoto únicamente si se configura una integración autorizada.

**Tests ejecutados:**
- ✅ Sintaxis PHP/Blade.
- ✅ Ruta `system.update-status` registrada.
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

### [2026-11-20 19:30] — Actualización del menú principal con MDB y Font Awesome

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Modernizar el menú del sistema usando MDB/Bootstrap y los iconos Font Awesome 7 instalados.

**Archivos modificados:**
- `resources/views/template/partes/menu.blade.php` (navegación responsive, dropdowns con IDs únicos y iconografía Awesome)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se conservaron todos los permisos, rutas y grupos de menú existentes.
- Se reutilizaron MDB/Bootstrap 5 y Font Awesome 7.3.1 local.
- Se separaron los menús de cuenta para alumno y usuario administrativo.
- Se añadió navegación responsive y estados visuales de hover/focus.

**Pendientes / Deuda técnica:**
- Validar visualmente los dropdowns en navegador para los permisos reales.
- Revisar si la navegación móvil requiere colapsar dropdowns automáticamente al seleccionar.

**Tests ejecutados:**
- ✅ Sintaxis Blade/PHP del menú.
- ✅ Rutas `alumnos.home_avance` y `paciente.alumno.index.citas` verificadas.

### [2026-11-20 19:15] — Corrección definitiva de la vista Mis citas

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Confirmar que la URL `alumnos/sta/paciente/alumno/mis_citas` renderice la vista moderna de Mis citas.

**Archivos modificados:**
- `app/Http/Controllers/PacienteController.php` (renderiza siempre la vista moderna de citas, con estado vacío si no existe perfil)
- `routes/web.php` (eliminado el nombre duplicado `alumnos.login`)
- `resources/views/sistema_medico/paciente/mis_citas.blade.php` (estado vacío diferenciado entre perfil incompleto y ausencia de citas)
- `docs/BITACORA.md` (registro del incidente)

**Archivos eliminados:**
- Ninguno.

**Decisiones tomadas:**
- La URL específica del alumno ya no puede sustituir la vista de citas por el formulario antiguo.
- Si falta el perfil médico se muestra un estado vacío con acceso directo a completar perfil.
- Las rutas se mantienen compatibles para alumno y administrativo.

**Pendientes / Deuda técnica:**
- Completar el mapeo entre `sit.users` y `creditos.pacientes`.
- Validar visualmente la vista moderna con datos reales de citas.

### [2026-11-20 19:12] — Corrección de la vista Mis citas del alumno

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Investigar por qué la vista moderna de citas no aparecía al alumno y corregir la selección de perfil/paciente.

**Archivos modificados:**
- `app/Http/Controllers/PacienteController.php` (usa el guard activo y separa `user_id` de `paciente.id`)
- `resources/views/sistema_medico/paciente/create_cita.blade.php` (envía el ID real del paciente)
- `resources/views/sistema_medico/paciente/completar_perfil.blade.php` (nombre compatible con usuarios SIT y creditos)
- `docs/BITACORA.md` (registro del incidente)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- `Pacientes` se consulta por `user_id` del guard activo.
- Las citas se consultan por `paciente_id` real.

**Decisiones tomadas:**
- Ambos guards pueden usar el sistema médico, pero cada uno comparte el mismo modelo `pacientes`.
- Si el alumno no tiene perfil médico, se muestra completar perfil y luego se vuelve a citas.
- No se vuelve a usar el ID de usuario como `paciente_id`.

**Pendientes / Deuda técnica:**
- Revisar integración de perfiles SIT con la tabla `creditos.pacientes`.
- Validar visualmente el flujo completo con datos reales.

**Tests ejecutados:**
- ✅ Sintaxis PHP/Blade de las vistas de citas.
- ✅ Rutas de citas verificadas.

### [2026-11-20 19:09] — Reingeniería frontend del área de alumno

- **Estatus:** ✅ completado
- **Agente:** creditos-frontend
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Modernizar las vistas de inicio/avance del alumno, ficha académica y mis citas médicas sin cambiar rutas ni controladores.

**Archivos modificados:**
- `resources/views/alumnos/avance.blade.php` (dashboard moderno con identidad, resumen y progreso por crédito)
- `resources/views/alumnos/sta/ficha.blade.php` (ficha reorganizada en secciones responsive con formulario compatible)
- `resources/views/sistema_medico/paciente/mis_citas.blade.php` (listado moderno de citas con estados vacíos y acciones accesibles)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se conservaron las rutas, nombres de variables y nombres de campos enviados por los formularios existentes.
- Se utilizó Bootstrap/MDB ya cargado por el molde institucional.
- Se añadieron estados vacíos, tarjetas, barras de progreso, jerarquía visual y mejoras responsive.
- No se modificaron controladores ni rutas.

**Pendientes / Deuda técnica:**
- Validar visualmente en navegador las vistas con datos reales de Home, Ficha y citas.
- Revisar alinear el flujo de citas con el usuario autenticado mediante guard `sit/alumno`.
- Sustituir estilos CDN o locales dispersos por una capa común de diseño si se amplia el área de alumno.

**Tests ejecutados:**
- ✅ Sintaxis Blade/PHP de las tres vistas.
- ✅ Rutas `alumnos/home` y `paciente.index.citas` verificadas.
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

**Referencias:**
- Prompt reingeniería de vistas del alumno
- `resources/views/template/molde.blade.php`
- `resources/views/template/partes/menu.blade.php`

### [2026-11-20 19:06] — Prevención de FK cruzada en la ficha académica

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Resolver `SQLSTATE[23000]` al crear registros auxiliares con el ID de `sit.alumnos` en tablas FK de `creditos`.

**Archivos modificados:**
- `app/Http/Controllers/AlumnosStaController.php` (la carga inicial ya no inserta objetos auxiliares con IDs de SIT)
- `docs/BITACORA.md` (registro del incidente)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna inserción nueva: la carga de ficha usa únicamente consultas de lectura a tablas auxiliares y objetos vacíos en memoria cuando no existen.

**Decisiones tomadas:**
- No se reutiliza el ID de `sit.alumnos` como llave de `creditos.personales`, `padres`, `direcciones` o `historiales_clinicos`.
- Se evita escribir datos de crédito hasta definir el mapeo estable entre ambos esquemas.

**Pendientes / Deuda técnica:**
- Diseñar la clave puente alumno SIT ↔ registros auxiliares de `creditos`.
- Migrar `guardarDatFam()` para persistencia compatible con ese mapeo.

**Tests ejecutados:**
- ✅ Sintaxis PHP validada tras la corrección.
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

**Referencias:**
- Incidente FK `creditos.personales.id_alu -> creditos.alumnos.id`
- SQL insertado con `id_alu = 52`

### [2026-11-20 19:04] — Ficha académica migrada del SQL Server legado

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Corregir el error `could not find driver` al consultar la ficha del alumno `00030068@cdhidalgo.tecnm.mx`.

**Archivos modificados:**
- `app/Http/Controllers/AlumnosStaController.php` (`ficha()` ahora obtiene identidad, carrera y datos complementarios desde SIT)
- `resources/views/alumnos/sta/ficha.blade.php` (fecha y sexo calculados de forma segura desde datos SIT)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- `AlumnosStaController::ficha()` ya no consulta `contEsc.alumnos`, `contEsc.alumcom` ni `contEsc.carreras`.
- Los datos editables auxiliares continúan almacenándose en las tablas propias de `creditos`.

**Decisiones tomadas:**
- Se proyectaron los campos institucionales requeridos por la vista desde `Sit\Alumno`, `Sit\User`, `AlumnoComplemento` y `AlumnoDatoMedico`.
- Los registros auxiliares legacy de la ficha se crean si no existen, sin depender de SQL Server.

**Pendientes / Deuda técnica:**
- Migrar gradualmente los demás métodos de `AlumnosStaController` que todavía usan `contEsc`.
- Migrar los métodos de edición de ficha para que no vuelvan a leer o escribir `App\Models\Alumno`.

**Tests ejecutados:**
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

**Referencias:**
- Incidente ficha alumno `00030068`
- `storage/logs/laravel.log`

### [2026-11-20 18:59] — Corrección de acceso al dashboard de alumno

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** trayectoria
- **Prompt/Tarea original:** Corregir el error `Undefined array key 0` después de autenticar con `sit.users` y redirigir a `/alumnos/home`.

**Archivos modificados:**
- `app/Http/Controllers/AlumnosRutasController.php` (resuelve el alumno desde SIT y separa perfil académico de avance)
- `app/Models/Sit/User.php` (accessors de compatibilidad `noControl`, `foto`, `status` y `carrera`)
- `resources/views/alumnos/avance.blade.php` (usa perfil preparado por el controlador y evita índices vacíos)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- `AlumnosRutasController::avance()` consulta `sit.alumnos` por `user_id` y obtiene carrera.
- El avance complementario continúa consultando las tablas propias de `creditos`.

**Decisiones tomadas:**
- No se consulta `creditos.alumnos` ni `App\Models\Alumno` en el flujo inicial del dashboard.
- Se conserva un perfil mínimo aunque el alumno no tenga registros de avance.
- `verificarProgreso()` deriva el número de control desde SIT.

**Pendientes / Deuda técnica:**
- Migrar el resto de métodos de `AlumnosRutasController` a datos SIT donde todavía usan `Auth::User()->no_control`.

**Tests ejecutados:**
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

**Referencias:**
- Incidente alumno `00030068@cdhidalgo.tecnm.mx`
- Log `storage/logs/laravel.log`

### [2026-11-20 18:53] — Modernización UX de la entrada al sistema

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Actualizar la interfaz de inicio de sesión con una presentación moderna basada en MDB, manteniendo el acceso unificado sin selector de rol.

**Archivos modificados:**
- `resources/views/auth/login.blade.php` (rediseño responsive con MDB 9.3.0, marca institucional y alternador de contraseña)
- `tests/Feature/Auth/UnifiedLoginTest.php` (agregada prueba de ausencia del selector y presencia del formulario moderno)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna.

**Decisiones tomadas:**
- Se mantuvo el endpoint POST unificado `/login`.
- Se eliminaron scripts legacy de cambio dinámico de tipo de usuario.
- Se conservaron mensajes de SweetAlert y enlaces de recuperación existentes.
- Se añadió diseño responsive para móvil y escritorio sin incorporar assets locales adicionales.

**Pendientes / Deuda técnica:**
- Validar visualmente en navegador el comportamiento del input flotante MDB 9.3.0.
- Sustituir en el futuro la imagen externa usada por otros módulos si se requiere control offline.

**Tests ejecutados:**
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (7 passed, 25 assertions)

**Referencias:**
- Prompt UX login moderno
- `docs/BITACORA.md` Tarea 2 Fase 1B

### [2026-11-20 18:47] — Autenticación unificada contra SIT

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Unificar el inicio de sesión administrativo/alumno sin selector de tipo, autenticando alumnos contra `sit.users` con perfil en `sit.alumnos`.

**Archivos modificados:**
- `app/Models/Sit/User.php` (modelo autenticable, `hidden`, remember token no-op e `isAlumnoActivo`)
- `config/auth.php` (provider `alumnos` apunta a `App\Models\Sit\User`)
- `app/Http/Controllers/Auth/LoginController.php` (detección unificada y logout dual)
- `routes/web.php` (rutas `/`, `/login` y compatibilidad de login alumno)
- `resources/views/auth/login.blade.php` (eliminado selector de tipo)
- `app/Services/Sit/AlumnoContextService.php` (creado)
- `tests/Feature/Auth/UnifiedLoginTest.php` (creado)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Login administrativo: consulta `creditos.users` por email y autenticación por `web`.
- Login alumno: consulta `sit.users` y valida existencia de `sit.alumnos`.

**Decisiones tomadas:**
- Los alumnos se autentican exclusivamente mediante `Sit\User` y el guard `alumno`.
- `setRememberToken()` es no-op para evitar escrituras en `sit.users`.
- Las respuestas de error no revelan si existe una cuenta inactiva o sin perfil.
- Se conserva `alumnoLogin()` como delegación compatible.

**Pendientes / Deuda técnica:**
- Completar seeds o datos reales para pruebas de integración SIT.
- Revisar lockout/throttling con ambos proveedores.
- Validar rutas protegidas que esperan únicamente el guard `web`.

**Tests ejecutados:**
- ✅ `php artisan test tests/Feature/Auth/UnifiedLoginTest.php` (6 passed, 20 assertions)

**Referencias:**
- Prompt Fase 1B
- `docs/db/sit.sql`
- ADR pendiente: identidad y autenticación de alumnos

### [2026-11-20 18:32] — Capa de modelos de solo lectura para SIT

- **Estatus:** ✅ completado
- **Agente:** creditos-backend
- **Módulo:** infraestructura
- **Prompt/Tarea original:** Crear la capa Eloquent read-only en `app/Models/Sit/`, proteger escrituras, configurar la conexión `sit` y agregar pruebas unitarias sin modificar controladores ni rutas.

**Archivos modificados:**
- `config/database.php` (agregada conexión `sit` con variables `DB_SIT_*`)
- `app/Traits/SitReadOnlyModel.php` (creado)
- `app/Models/Sit/*.php` (creados 20 modelos de lectura)
- `tests/Pest.php` (creado)
- `tests/Unit/Sit/ReadOnlyModelsTest.php` (creado)
- `composer.json` y `composer.lock` (Pest y plugin Laravel instalados)

**Archivos eliminados:**
- Ninguno.

**Consultas SQL nuevas o modificadas:**
- Ninguna; todos los modelos apuntan a la conexión `sit` y están protegidos contra escritura.

**Decisiones tomadas:**
- Se mantuvo intacta la conexión principal `creditos`.
- Cada modelo `Sit\*` usa `protected $connection = 'sit'`, tabla explícita y casts con sintaxis `casts(): array`.
- La protección bloquea métodos de instancia, métodos estáticos de creación/inserción y eventos Eloquent de escritura.
- Los tests de relaciones no ejecutan consultas a la base `sit`.

**Pendientes / Deuda técnica:**
- Falta verificar la conexión real `sit` en el entorno de staging o producción.
- Falta seed de datos institucionales para pruebas de integración.
- Se debe evaluar en una tarea posterior si otros modelos requieren relaciones adicionales.

**Tests ejecutados:**
- ✅ `php artisan test tests/Unit/Sit/ReadOnlyModelsTest.php` (5 passed, 26 assertions)

**Referencias:**
- Prompt Fase 1
- `docs/db/sit.sql`
- ADR pendiente: identidad y autenticación de alumnos

## Inventario inicial del sistema

**Fecha:** 2026-11-20 · **Agente:** no registrado · **Estatus:** ✅ completado

### Contexto

Se inició el inventario sin modificaciones de código. Se tomaron como fuente `docs/db/sit.sql`, `docs/db/creditos.sql` y el estado actual de las rutas, modelos y controladores.

### Archivos creados

- `docs/INVENTARIO_CODIGO.md`: inventario de rutas, modelos, consultas a alumnos, campos incompatibles y tablas sin equivalente.

### Decisiones tomadas durante el inventario

- Usar `sit.alumnos` como esquema destino y `creditos.alumnos` como esquema legado.
- Marcar el modelo `Alumno` con `⚠️` por operar directamente sobre `creditos.alumnos` mientras no tenga una conexión explícita a otra base.
- Mantener separados los campos presentes solo en el legado; no se asumió una equivalencia automática por nombres parecidos.
- Clasificar las tablas únicamente por evidencia estructural del dump y uso funcional en el código.
- Distinguir información de volumen real de datos: el SQL proporciona `AUTO_INCREMENT`, pero no garantiza conteos actuales de registros.

### Pendientes encontrados

- Existen 28 tablas de `creditos.sql` sin nombre equivalente en `sit.sql`; varias requieren mapeo funcional o decisión de migrar/deprecar.
- Existen campos de `creditos.alumnos` sin columna directa en `sit.alumnos`, incluidos identidad (`nombre`, apellidos), autenticación (`password`, `remember_token`), carrera y grupo académicos, correo, estatus visual y datos clínicos/observaciones.
- La autenticación actual está acoplada al modelo legado `Alumno`; debe decidirse si los alumnos compartirán `sit.users` o conservarán credenciales separadas.
- Las relaciones por `no_control` y por `id` son mixtas en las tablas legado; el destino debe definir claves de mapeo y migración de datos.
- Las rutas, modelos y controladores muestran dependencia extensa de ambos esquemas, pero el inventario requiere validar en ejecución cuáles conexiones usan cada consulta.

### ADR pendientes

- ADR: identidad y autenticación de alumnos (`sit.users` contra identidad específica).
- ADR: estrategia de claves para alumno (`id`, `no_control`, `user_id` y mapeo histórico).
- ADR: mapeo de `creditos.alumnos` a `sit.alumnos`.
- ADR: destino funcional de tablas legado sin equivalente directo.
- ADR: conservación o migración de datos personales sensibles y credenciales.