# Estado inicial — Semana 14

**Proyecto:** El Árbol de Higos
**Versión que se prueba:** carpeta `semana14`, copia de `semana13`
**Alumna:** Patricia Segura Resendiz
**Fecha:** 4 de noviembre de 2026

## 1. Versión de partida

La versión de partida es la entrega de la Semana 13 (búsqueda y ordenamiento de la lista de reseñas). El commit exacto queda marcado con la etiqueta de Git `semana14-inicio` (ver sección 6), que permite recuperarlo en cualquier momento.

## 2. Revisión inicial

Se marca cada punto solo después de comprobarlo en la aplicación:

- [ ] La aplicación abre correctamente desde `semana14`.
- [ ] El servidor PHP funciona.
- [ ] La conexión con MySQL funciona.
- [x] La estructura de archivos está documentada (sección 3).
- [ ] El repositorio está actualizado (`git status` sin cambios pendientes).
- [x] Existe una forma de recuperar la versión estable (sección 6).
- [x] Hay cuentas de demostración preparadas (sección 5).
- [x] No se usan credenciales reales en las evidencias.

## 3. Estructura de archivos

| Carpeta o archivo | Contenido |
|---|---|
| `app/models/` | Modelo `Resena.php`: acceso a los datos |
| `app/controllers/` | `ResenaController.php`: coordina y valida |
| `app/views/layouts/` | Encabezado, menú, mensajes y pie |
| `app/views/componentes/` | Componente de campos de formulario |
| `app/views/resenas/` | Vista de reseñas públicas |
| `app/helpers/` | `entrada.php`: lectura segura de datos |
| `api/` | Endpoint JSON `resenas.php` |
| Raíz | Páginas (`index`, `panel`, `listar`, `crear`, `editar`, `eliminar`, `login_form`, `login`, `logout`, `procesar`, `resenas`), `conexion.php`, `autorizacion.php`, `autorizacion_json.php`, `proteger.php`, `listar.js`, `script.js`, `estilos.css` |
| `config.php` | Datos de conexión: **no está en el repositorio** (lo ignora `.gitignore`) |
| `config.ejemplo.php` | Plantilla sin datos reales |
| `esquema.sql` | Estructura de la base de datos, sin datos |

Para ver la estructura real de la carpeta en cualquier momento:

```bash
cd /c/wamp64/www/DESARROLLO-DE-APLICACION-WEB/semana14
find . -path ./img -prune -o -type f -print | sort
```

## 4. Problemas conocidos al empezar

Son los que ya estaban documentados antes de ejecutar las pruebas:

| Problema | Dónde está documentado |
|---|---|
| `index.php` y la página de "Acceso denegado" no usan la plantilla | `semana12/evidencia.md` |
| Solo el módulo de consulta de reseñas sigue MVC; crear, editar, eliminar y el login no | `semana11/estructura_mvc.md` |
| La comprobación de rol está duplicada en `autorizacion.php` y `autorizacion_json.php` | `semana10/evidencia.md` |
| Los formularios no tienen token CSRF | `semana08/auditoria.md` |
| El login no limita los intentos | `semana08/auditoria.md` |
| No hay módulo de gestión de usuarios: los roles se asignan en la base de datos | `semana09/diseno_roles.md` |
| La lista no tiene paginación | `semana13/evidencia.md` |
| La tienda aún no tiene catálogo de libros ni carrito: hoy gestiona las reseñas | `README.md` |

## 5. Cuentas y datos de demostración

| Usuario | Rol | Estado |
|---|---|---|
| `admin_prueba` | `administrador` | Activo |
| `consulta_prueba` | `consulta` | Activo |
| `inactivo_prueba` | `consulta` | Desactivado (para probar que no puede entrar) |

Las contraseñas no se escriben en el repositorio ni en este documento. Las pruebas que crean o borran registros se hacen únicamente con reseñas de demostración.

## 6. Cómo recuperar la versión estable

Se marca el commit de partida con una etiqueta de Git:

```bash
cd /c/wamp64/www/DESARROLLO-DE-APLICACION-WEB
git tag semana14-inicio
git push origin semana14-inicio
```

Si una corrección rompe algo y no se sabe cómo regresar, se puede ver qué cambió desde ese momento con:

```bash
git diff semana14-inicio -- semana14
```

## 7. Revisión de la documentación del repositorio

Antes de la entrega se revisa que ningún documento tenga imágenes rotas ni texto pendiente:

```bash
cd /c/wamp64/www/DESARROLLO-DE-APLICACION-WEB
for md in semana*/*.md; do
  dir=$(dirname "$md")
  grep -o 'img/[^")]*' "$md" | sort -u | while read ref; do
    [ -f "$dir/$ref" ] || echo "FALTA en $md: $ref"
  done
done
echo "--- Notas pendientes sin completar ---"
grep -rn "\[Patricia" --include="*.md" .
```

Si el comando no imprime nada entre las dos secciones, no hay imágenes rotas; si sale algo, se corrige el documento y se vuelve a ejecutar.

## 8. Estado general

Las funciones de la aplicación (formularios y validaciones, login y sesiones, CRUD de reseñas, roles y permisos, Fetch API, MVC en el módulo de consulta, plantilla y componentes, y búsqueda con ordenamiento) quedaron documentadas y probadas en la semana en que se construyeron. La revisión de esta semana, con `plan_pruebas.md`, comprueba que siguen funcionando **en conjunto**; sus resultados se registran en ese plan, y cualquier falla se registra en `registro_errores.md`.
