# Diseño de roles y permisos — Semana 09

**Proyecto:**💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Alumna:** Patricia Segura Resendiz

## Decisión de diseño 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

Elegí la **Opción A: una columna `rol` en la tabla `usuarios`**. Mi aplicación solo necesita dos tipos de usuario con permisos fijos, así que crear tablas separadas de roles y permisos habría complicado el proyecto sin aportar nada.

- La columna es `rol VARCHAR(30) NOT NULL DEFAULT 'consulta'`.
- Un `CHECK` en MySQL solo permite los valores `administrador` y `consulta`.
- El valor por defecto es `consulta`: toda cuenta nueva empieza con los permisos mínimos.
- El rol nunca se lee de un formulario, de la URL ni de JavaScript. Se consulta en la base de datos al iniciar sesión y se guarda en `$_SESSION`.
- No incluí un módulo de gestión de usuarios: los roles se asignan directamente en la base de datos, como permite la guía.
- Si el rol de una cuenta cambia, hay que cerrar sesión e iniciar de nuevo para que la sesión lo refleje.

## Roles 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

| Rol | Responsabilidad | Operaciones permitidas | Operaciones restringidas |
|---|---|---|---|
| `administrador` | Administrar las reseñas | Panel, listar, crear, editar y eliminar reseñas | Ninguna dentro de la aplicación |
| `consulta` | Consultar información | Panel y listado de reseñas | Crear, editar y eliminar |

## Matriz de acceso por archivo 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

| Archivo | Sin sesión | `consulta` | `administrador` |
|---|---|---|---|
| `index.php`, `resenas.php`, `procesar.php` | Permitido | Permitido | Permitido |
| `login_form.php`, `login.php` | Permitido | Redirige al panel | Redirige al panel |
| `panel.php` | Rechazado | Permitido | Permitido |
| `listar.php` | Rechazado | Permitido | Permitido |
| `crear.php` | Rechazado | **Rechazado (403)** | Permitido |
| `editar.php` | Rechazado | **Rechazado (403)** | Permitido |
| `eliminar.php` | Rechazado | **Rechazado (403)** | Permitido |

Nota: el formulario público del inicio (`procesar.php`) sigue abierto para cualquier lector, porque dejar una reseña es parte de la tienda. La restricción por rol se aplica al módulo de administración (`crear.php`, `editar.php`, `eliminar.php`).

## Cuentas de demostración 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Usuario | Rol |
|---|---|
| `admin_prueba` | `administrador` |
| `consulta_prueba` | `consulta` |