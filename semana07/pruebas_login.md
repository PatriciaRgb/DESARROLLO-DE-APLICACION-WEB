# Pruebas funcionales del login y las sesiones — Semana 07

**Proyecto:** El Árbol de Higos 🌸🌸🌷🌸🌸💐
**Tabla de usuarios:** `usuarios` (base de datos `arbol_de_higos`)
**Alumna:** Patricia Segura Resendiz

Todas las pruebas se hicieron sobre la aplicación real, con el servidor de PHP corriendo desde la carpeta `semana07` y MySQL en WampServer. Se usaron dos usuarios de demostración, creados con un script temporal que ya fue eliminado:

| Usuario | Estado | Para qué se usó |
|---|---|---|
| `admin_prueba` | Activo | Pruebas de acceso correcto |
| `inactivo_prueba` | Desactivado (`activo = 0`) | Prueba de usuario inactivo |

Las contraseñas de prueba no se guardan en ningún archivo del repositorio. Las pruebas de acceso sin sesión se hicieron en una ventana de incógnito, que no comparte la sesión de la ventana normal.

---

## Resumen 🌸🌸🌷🌸🌸💐

| N.º | Prueba | Resultado |
|---:|---|---|
| 1 | Iniciar sesión con credenciales correctas | Correcto |
| 2 | Iniciar sesión con contraseña incorrecta | Correcto |
| 3 | Iniciar sesión con un usuario inexistente | Correcto |
| 4 | Abrir `panel.php` directamente sin sesión | Correcto |
| 5 | Iniciar sesión y navegar a una página protegida | Correcto |
| 6 | Mostrar el nombre del usuario autenticado | Correcto |
| 7 | Cerrar sesión | Correcto |
| 8 | Intentar abrir el panel después de cerrar sesión | Correcto |
| 9 | Comprobar que el acceso se rechaza tras el cierre | Correcto |
| 10 | Usuario marcado como inactivo | Correcto |
| 11 | Contraseña almacenada como hash | Correcto |
| 12 | El CRUD sigue funcionando con el login integrado | Correcto |

---

## Prueba 1 — Credenciales correctas 🌸🌸🌷🌸🌸💐

**Qué hice:** en `login_form.php` escribí `admin_prueba` y su contraseña, y presioné "Iniciar sesión".

**Resultado esperado:** acceso al panel protegido.

**Resultado obtenido:** me llevó a `panel.php`.

![Formulario de login](img/04-login-formulario.png)
![Acceso correcto](img/08-login-exitoso.png)

---

## Prueba 2 — Contraseña incorrecta 🌸🌸🌷🌸🌸💐

**Qué hice:** usé `admin_prueba` con una contraseña equivocada.

**Resultado esperado:** acceso rechazado con un mensaje genérico.

**Resultado obtenido:** apareció "No fue posible iniciar sesión con esas credenciales", sin indicar si el error estaba en el usuario o en la contraseña.

![Contraseña incorrecta](img/05-login-password-incorrecta.png)

---

## Prueba 3 — Usuario inexistente 🌸🌸🌷🌸🌸💐

**Qué hice:** escribí un usuario que no existe, con cualquier contraseña.

**Resultado esperado:** el mismo mensaje genérico que en la prueba 2.

**Resultado obtenido:** salió exactamente el mismo mensaje. Así quien intenta entrar no puede descubrir qué usuarios existen.

![Usuario inexistente](img/06-login-usuario-inexistente.png)

---

## Prueba 4 — Acceso directo sin sesión 🌸🌸🌷🌸🌸💐

**Qué hice:** en una ventana de incógnito escribí directamente la dirección de `panel.php`.

**Resultado esperado:** redirección al formulario de acceso.

**Resultado obtenido:** me mandó al login con el aviso "Debes iniciar sesión para entrar a esa página".

También comprobé que `listar.php`, `crear.php`, `editar.php` y `eliminar.php` hacen lo mismo: la protección está en el servidor, con `proteger.php` al inicio de cada archivo, antes de enviar cualquier HTML.

![panel.php sin sesión](img/09-panel-sin-sesion.png)
![listar.php sin sesión](img/10-listar-sin-sesion.png)
![crear.php sin sesión](img/11-crear-sin-sesion.png)

---

## Prueba 5 — Navegar a una página protegida con sesión 🌸🌸🌷🌸🌸💐

**Qué hice:** inicié sesión y entré a "Administrar reseñas" desde el panel.

**Resultado esperado:** la página protegida abre con normalidad.

**Resultado obtenido:** se mostró la lista completa de reseñas.

![Lista con sesión](img/12-crud-con-sesion.png)

---

## Prueba 6 — Nombre del usuario autenticado 🌸🌸🌷🌸🌸💐
 
**Qué hice:** revisé el panel después de iniciar sesión.

**Resultado esperado:** se muestra el nombre del usuario.

**Resultado obtenido:** el panel mostró "Bienvenida" junto con el nombre guardado en la sesión (`$_SESSION["nombre"]`), impreso con `htmlspecialchars()`.

![Panel con el nombre](img/08-login-exitoso.png)

---

## Prueba 7 — Cerrar sesión 🌸🌸🌷🌸🌸💐

**Qué hice:** presioné "Cerrar sesión".

**Resultado esperado:** la sesión termina y regresa al formulario de acceso.

**Resultado obtenido:** me llevó al login con el aviso verde "Cerraste sesión correctamente". `logout.php` vacía `$_SESSION`, borra la cookie de sesión y destruye la sesión en el servidor.

![Cierre de sesión](img/13-logout.png)

---

## Pruebas 8 y 9 — Acceso al panel después de cerrar sesión 🌸🌸🌷🌸🌸💐

**Qué hice:** después de cerrar sesión, escribí otra vez la dirección de `panel.php`.

**Resultado esperado:** el acceso se rechaza.

**Resultado obtenido:** me mandó al login con el aviso de que debo iniciar sesión.

![Panel después del cierre](img/14-panel-despues-logout.png)

---

## Prueba 10 — Usuario inactivo 🌸🌸🌷🌸🌸💐

**Qué hice:** intenté entrar con `inactivo_prueba` y su contraseña correcta.

**Resultado esperado:** no puede entrar.

**Resultado obtenido:** salió el mismo mensaje genérico. Aunque la contraseña era correcta, el usuario tiene `activo = 0`, y `login.php` solo permite entrar si está activo. El mensaje no dice "usuario desactivado", para no darle información a quien intenta entrar.

![Usuario inactivo](img/07-login-usuario-inactivo.png)

---

## Prueba 11 — Contraseña almacenada como hash 🌸🌸🌷🌸🌸💐

**Qué hice:** consulté la tabla `usuarios` directamente en MySQL.

**Resultado esperado:** la base de datos contiene un hash, no la contraseña original.

**Resultado obtenido:** la columna `password_hash` muestra una cadena larga que empieza con `$2y$10$...`, y la contraseña original no aparece en ninguna parte.

![Tabla de usuarios](img/02-tabla-usuarios.png)
![Hash en MySQL](img/03-usuarios-con-hash.png)

---

## Prueba 12 — El CRUD continúa funcionando 🌸🌸🌷🌸🌸💐

**Qué hice:** con la sesión iniciada, creé una reseña de prueba, la edité y la eliminé.

**Resultado esperado:** las cuatro operaciones siguen funcionando después de integrar la autenticación.

**Resultado obtenido:** las operaciones funcionaron igual que en la Semana 06.

![CRUD con sesión](img/12-crud-con-sesion.png)

---

## Resumen de seguridad aplicada 🌸🌸🌷🌸🌸💐

| Medida | Dónde se aplicó |
|---|---|
| Contraseñas con `password_hash()` | Creación de usuarios (script temporal, ya eliminado) |
| Verificación con `password_verify()` | `login.php` |
| Consultas preparadas | `login.php` y todo el CRUD |
| Mensaje genérico ante credenciales inválidas | `login.php` |
| Solo usuarios activos pueden entrar | `login.php` (`activo = 1`) |
| `session_regenerate_id(true)` tras el acceso correcto | `login.php` |
| Protección de páginas en el servidor | `proteger.php`, incluido al inicio de cada página interna |
| Cierre de sesión completo (datos, cookie y sesión) | `logout.php` |
| Avisos desde una lista cerrada, no desde la URL | `login_form.php` |
| El script de creación de usuarios solo funciona desde la terminal y fue eliminado | `crear_usuario.php` |