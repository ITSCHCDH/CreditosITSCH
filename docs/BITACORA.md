# Bitácora de cambios — Sistema Creditos

Este archivo registra cronológicamente todos los cambios, decisiones y pendientes del proyecto de migración al esquema `sit`. Entradas más recientes arriba.

## Índice de módulos
- [Créditos complementarios](#créditos-complementarios)
- [Trayectoria académica](#trayectoria-académica)
- [Tutorías](#tutorías)
- [Infraestructura](#infraestructura)

---

<!-- Las entradas van aquí, más recientes arriba -->

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

## 2026-11-20 — Inventario inicial del sistema

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