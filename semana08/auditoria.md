# Auditoría de seguridad — Semana 08

**Proyecto:** El Árbol de Higos 🌸🌸🌷🌸🌸💐
**Base de datos:** `arbol_de_higos` (tablas `resenas` y `usuarios`)
**Alumna:** Patricia Segura Resendiz

La auditoría se hizo sobre una copia de trabajo (`semana08`). Para no revisar de memoria, localicé las consultas y las salidas de HTML con `grep` y revisé cada archivo que recibe datos, consulta la base de datos o muestra información.

---

## 1. Estado del proyecto antes de empezar 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

La versión de la Semana 07 funcionaba: abre el inicio con su menú, el login valida desde PHP, el CRUD crea, lista, edita y elimina, las páginas internas exigen sesión y el cierre de sesión funciona. Esto se comprobó antes de modificar nada.

![Proyecto funcionando](img/01-proyecto-funcionando.png)

---

## 2. Inventario de seguridad 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

| Archivo o módulo | Datos que recibe | Riesgo que revisé | Corrección o estado |
|---|---|---|---|
| `index.php` (formularios públicos) | Nombre, correo, calificación, libro y comentario | Datos vacíos o inválidos; JavaScript se puede desactivar | La validación real está en PHP (`procesar.php`); JavaScript solo mejora la experiencia |
| `procesar.php` | Los mismos campos, por GET o POST | Inyección SQL (en la Semana 05 el SQL concatenaba variables); salida sin escapar | Consulta preparada, validaciones, `htmlspecialchars()` y regla del comentario |
| `crear.php` | Campos de la reseña | Datos inválidos, inyección SQL | Consulta preparada y validaciones del servidor |
| `editar.php` | Identificador y campos | Identificador inválido o inexistente, `UPDATE` sin `WHERE` | `FILTER_VALIDATE_INT`, comprobación de existencia, consulta preparada con `WHERE id = ?` |
| `eliminar.php` | Identificador | Borrar con un enlace GET, identificador inválido | Solo acepta POST, confirmación en el navegador, consulta preparada y `affected_rows` |
| `listar.php` | Datos de MySQL (interno) | Salida HTML sin escapar | `htmlspecialchars()`; la consulta es fija, sin datos del usuario |
| `resenas.php` (público) | Datos de MySQL | **Salida HTML sin escapar (hallazgo 1)** | Corregido con `htmlspecialchars()` |
| `login.php` | Usuario y contraseña | Verificación incorrecta, descubrir qué usuarios existen, fijación de sesión | `password_verify()`, mensaje genérico, consulta preparada, solo usuarios activos, `session_regenerate_id(true)` |
| `login_form.php` | Parámetro `m` de la URL | Mostrar texto arbitrario recibido por la URL | Los avisos salen de una lista cerrada |
| `proteger.php`, `panel.php` | Sesión | Acceso sin autenticación | Comprobación de sesión en el servidor, antes de enviar HTML |
| `logout.php` | Sesión | Sesión que sigue viva | Vacía `$_SESSION`, borra la cookie y destruye la sesión |
| `conexion.php` | Credenciales de MySQL | **Credenciales en el repositorio y errores técnicos en pantalla (hallazgo 2)** | Corregido: configuración aparte y errores al registro |
| Tabla `usuarios` | Contraseñas | Contraseñas en texto plano | Solo se guarda el hash (`password_hash()`) |

---

## 3. Hallazgos 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

### Hallazgo 1 — Salida sin escapar en la página pública de reseñas

**Dónde:** `resenas.php`, columnas nombre, libro y comentario.

**Cómo lo encontré:** con `grep -n "echo.*\$" *.php | grep -v htmlspecialchars` salieron líneas que imprimían texto escrito por visitantes sin escapar. Las demás líneas eran seguras: números forzados con `(int)`, mensajes escritos por mí en el código, o avisos de una lista cerrada.

**Prueba:** guardé una reseña con el comentario `<b>prueba</b>`. En `resenas.php` el texto salió en negritas, o sea que el navegador interpretó lo que escribió el visitante como código de mi página. Si en lugar de una etiqueta inofensiva alguien guardara un script, se ejecutaría en el navegador de cualquiera que abriera la página (XSS almacenado).

**Corrección:** todo texto de usuario se imprime con `htmlspecialchars($valor, ENT_QUOTES, "UTF-8")` y la calificación con `(int)`. Además quité el ID de la vista pública, agregué un mensaje cuando no hay reseñas y un `try / catch` para no mostrar errores técnicos.

**Resultado:** después de la corrección, el mismo comentario se ve como texto, con los símbolos `<b>` y `</b>` a la vista.

![Antes: el HTML se ejecuta](img/02-hallazgo-resenas-sin-escape.png)
![Después: se muestra como texto](img/03-resenas-escapada.png)

### Hallazgo 2 — Credenciales en el repositorio y errores técnicos en pantalla 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

**Dónde:** `conexion.php`.

**Problema A:** el usuario y la contraseña de MySQL estaban escritos en `conexion.php`, y ese archivo se sube a GitHub con cada commit.

**Problema B:** al provocar un error de conexión (nombre de base de datos incorrecto), la pantalla mostraba el error completo de PHP con la pila de llamadas, rutas del servidor y el usuario de la conexión. Mi `if ($conexion->connect_error)` nunca se ejecutaba, porque PHP 8.2 lanza una excepción antes de llegar ahí.

**Corrección:**
- Los datos reales pasaron a `config.php`, que está en `.gitignore` y no se sube. En el repositorio quedó `config.ejemplo.php`, una plantilla sin datos reales.
- `conexion.php` ahora lee `config.php` y atrapa la excepción con `try / catch`: el detalle va a `error_log()` y al usuario solo se le muestra "El sistema no está disponible en este momento".
- Comprobé con `git check-ignore -v` que Git ignora `config.php`.

**Resultado:** con la base incorrecta, el visitante solo ve el mensaje genérico, y el detalle técnico queda en el registro del servidor.

![Antes: error con pila de llamadas](img/04-error-conexion-antes.png)
![Después: mensaje genérico](img/05-error-conexion-despues.png)
![El detalle queda en el registro](img/06-error-en-registro.png)

### Hallazgo 3 — Consultas con datos concatenados (Semana 05, ya corregido) 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

En la Semana 05, `procesar.php` armaba el SQL pegando las variables dentro del texto. Se corrigió en la Semana 06 con consultas preparadas, y en esta auditoría lo verifiqué: `grep -n "query(\|prepare(" *.php` muestra que todo lo que recibe datos del usuario usa `prepare(`. Los dos `query(` que quedan (`listar.php` y `resenas.php`) son consultas fijas, sin ninguna variable.

### Hallazgo 4 — Reglas de negocio faltantes en el comentario 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

La validación aceptaba cualquier comentario no vacío. Agregué una regla: el comentario debe tener entre 10 y 1000 caracteres, en `crear.php`, `editar.php` y `procesar.php`. Junto con la calificación entera entre 1 y 5, que ya existía, son las dos reglas de negocio documentadas.

![Comentario demasiado corto](img/07-validacion-comentario-corto.png)
![Calificación fuera de rango](img/08-validacion-calificacion.png)
![Identificador inválido](img/09-validacion-id-invalido.png)

---

## 4. Limitaciones conocidas 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

Estos puntos no se corrigieron en esta práctica, y los dejo documentados:

| Limitación | Comentario |
|---|---|
| Los formularios no tienen token CSRF | Un sitio ajeno podría intentar enviar un formulario en nombre de un usuario con sesión. Queda como mejora futura |
| El login no limita intentos | Alguien podría probar muchas contraseñas seguidas |
| Las carpetas anteriores (`semana05` a `semana07`) conservan su `conexion.php` con el usuario de pruebas de WampServer (`root`, sin contraseña) | No es una credencial real, pero en un proyecto real cualquier credencial que haya llegado a un repositorio se consideraría expuesta y habría que cambiarla |
| El historial de Git conserva las versiones anteriores de los archivos | Las correcciones no borran el pasado |
| `procesar.php` sigue aceptando datos por GET para el experimento de la Semana 02 | Es intencional para la práctica; en una aplicación real solo usaría POST |

---

## 5. Revisión de sesiones y páginas protegidas 🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐

| Punto de la guía | Estado |
|---|---|
| `session_start()` se ejecuta antes de enviar contenido | Sí, al inicio de `proteger.php`, `login.php` y `logout.php` |
| El identificador de sesión se regenera al autenticar | Sí, `session_regenerate_id(true)` en `login.php` |
| Las páginas privadas comprueban la sesión en el servidor | Sí, `proteger.php` al inicio de cada una |
| El cierre de sesión destruye la sesión | Sí, `logout.php` |
| El panel no abre sin autenticación | Sí, comprobado en una ventana de incógnito |
| No se puede entrar a un módulo privado por otra ruta | Sí, cada archivo del CRUD incluye `proteger.php`, incluidos los que solo procesan (`eliminar.php`) |
