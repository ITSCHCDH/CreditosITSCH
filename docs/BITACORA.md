# Bitácora de cambios — Sistema Creditos

Este archivo registra cronológicamente todos los cambios, decisiones y pendientes del proyecto de migración al esquema `sit`. Entradas más recientes arriba.

## Índice de módulos
- [Créditos complementarios](#créditos-complementarios)
- [Trayectoria académica](#trayectoria-académica)
- [Tutorías](#tutorías)
- [Infraestructura](#infraestructura)

---

<!-- Las entradas van aquí, más recientes arriba -->

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