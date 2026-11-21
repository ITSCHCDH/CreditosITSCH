# Bitácora de cambios — Sistema Creditos

Este archivo registra cronológicamente todos los cambios, decisiones y pendientes del proyecto de migración al esquema `sit`. Entradas más recientes arriba.

## Índice de módulos
- [Créditos complementarios](#créditos-complementarios)
- [Trayectoria académica](#trayectoria-académica)
- [Tutorías](#tutorías)
- [Infraestructura](#infraestructura)

---

<!-- Las entradas van aquí, más recientes arriba -->

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