# Estructura inicial — Semana 11

**Proyecto:**💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Alumna:** Patricia Segura Resendiz

Este documento registra cómo está organizado el proyecto **antes** de reorganizarlo con una arquitectura inspirada en MVC. Parte de la copia de la Semana 10 (`semana11`), con el login, los roles y el Fetch funcionando.

## 1. Archivos y responsabilidades 
💗🌸🌸🌸🌷🌸🌸💐🌸🌸

| Archivo | Qué hace hoy | Responsabilidades que mezcla |
|---|---|---|
| `conexion.php` | Lee `config.php` y crea la conexión a MySQL | Conexión (una sola, correcto) |
| `config.php` / `config.ejemplo.php` | Datos de conexión / plantilla sin secretos | Configuración |
| `proteger.php` | Exige sesión; si no hay, redirige al login | Sesión |
| `autorizacion.php` | `exigirRol()`, `tieneRol()`, `rolActual()` para páginas | Sesión y roles (HTML en el 403) |
| `autorizacion_json.php` | Sesión y rol para endpoints JSON (401 y 403 en JSON) | Sesión y roles, **duplicada** con `autorizacion.php` |
| `login_form.php` | Formulario de acceso | Vista |
| `login.php` | Verifica credenciales, abre sesión | SQL + sesión + redirecciones |
| `logout.php` | Cierra la sesión | Sesión |
| `panel.php` | Panel interno con menú según el rol | Sesión + HTML |
| `index.php` | Inicio y formularios públicos | HTML |
| `procesar.php` | Recibe el formulario público, valida y guarda | Validación + SQL + HTML |
| `crear.php` | Alta de reseñas (solo administrador) | Autorización + validación + SQL + HTML |
| `editar.php` | Edición de reseñas (solo administrador) | Autorización + validación + SQL + HTML |
| `eliminar.php` | Eliminación por POST (solo administrador) | Autorización + validación + SQL |
| `listar.php` | Estructura de la lista (botón, zonas) | Autorización + HTML (ya no consulta la base de datos) |
| `listar.js` | Pide los datos con Fetch y dibuja la tabla | Presentación en el navegador |
| `api/resenas.php` | Endpoint JSON de consulta de reseñas | Comprobaciones + **SQL** + armado del JSON |
| `resenas.php` | Página pública de reseñas | **SQL + HTML** |
| `script.js` | Interacciones del inicio | Navegador |
| `estilos.css` | Presentación | Estilos |

## 2. Dónde se ejecutan las consultas SQL
💗🌸🌸🌸🌷🌸🌸💐🌸🌸

Hay SQL repartido en varios archivos: `login.php`, `procesar.php`, `crear.php`, `editar.php`, `eliminar.php`, `resenas.php` y `api/resenas.php`. Todas las que reciben datos del usuario usan consultas preparadas; las de `resenas.php` y `api/resenas.php` son consultas fijas.

## 3. Problemas de organización que encontré
💗🌸🌸🌸🌷🌸🌸💐🌸🌸

1. **La misma consulta de reseñas existe en dos lugares.** `api/resenas.php` y `resenas.php` consultan la tabla `resenas`, cada uno con su propio SQL.
2. **El endpoint mezcla tres responsabilidades**: comprobar sesión y rol, ejecutar el SQL y armar el JSON, todo en un solo archivo.
3. **Las comprobaciones de rol están duplicadas** en `autorizacion.php` y `autorizacion_json.php` (lo anoté como limitación en la Semana 10).
4. **Las páginas del CRUD mezclan** autorización, validación, SQL y HTML en el mismo archivo.

## 4. Decisión para esta práctica
💗🌸🌸🌸🌷🌸🌸💐🌸🌸

La guía pide reorganizar **al menos un módulo**, no todo el proyecto. Elegí el módulo de **consulta de reseñas**, porque tiene dos entradas (la lista del administrador con Fetch y el endpoint JSON) que usan los mismos datos, y porque resuelve el problema 1 y el 2.

El modelo, el controlador y la vista irán en `app/`. Para no romper las demás páginas, **no muevo** `conexion.php`, `config.php`, `proteger.php`, `login.php` ni el CRUD de crear, editar y eliminar; esos quedan como están y se documentan como pendientes de migrar.

## 5. Qué conservo sin cambios
💗🌸🌸🌸🌷🌸🌸💐🌸🌸

- El login, el cierre de sesión y las sesiones.
- Los roles: `administrador` y `consulta`.
- La dirección y el formato del endpoint (`api/resenas.php`), para que `listar.js` siga funcionando sin modificarse.
- Las consultas preparadas, el escape de salida y el manejo de errores sin detalles técnicos.
