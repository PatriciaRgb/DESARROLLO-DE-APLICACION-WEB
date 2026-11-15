# Plan de pruebas — Semana 14

**Proyecto:**💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Versión probada:** `semana14` (copia de `semana13`)
**Alumna:** Patricia Segura Resendiz

## Cómo usar este plan
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

1. Levanta el servidor desde `semana14` y comprueba que WampServer esté en verde.
2. Ejecuta cada caso **tal como está escrito** y llena las dos últimas columnas con lo que **realmente pasó**.
3. **Estado:** `Correcta`, `Incorrecta`, `Pendiente` o `No aplica`.
4. Si un caso falla, no lo corrijas en silencio: regístralo en `registro_errores.md`, corrígelo, y **repite el caso**.
5. Después de cada corrección, repite también los casos de regresión (sección final).

Cuentas de demostración: `admin_prueba` (administrador) y `consulta_prueba` (consulta). Las contraseñas no se escriben en este documento.

## Módulos probados
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Módulo | Casos |
|---|---|
| Formularios y validaciones | PR-FORM-01 a 06 |
| Login y sesiones | PR-LOG-01 a 06 |
| Seguridad | PR-SEG-01 a 06 |
| CRUD y base de datos | PR-CRUD-01 a 08 |
| Roles y permisos | PR-ROL-01 a 05 |
| Fetch API y JSON | PR-API-01 a 05 |
| MVC, plantilla y componentes | PR-ARQ-01 a 03 |
| Función avanzada (búsqueda y orden) | PR-BUS-01 a 06 |

---

## 1. Formularios y validaciones
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-FORM-01 | Reseña pública válida | En el inicio, formulario de POST, datos válidos (comentario de 10 caracteres o más) | Mensaje verde y datos mostrados; la reseña aparece en la lista |  |  |
| PR-FORM-02 | Campos vacíos | Formulario de POST sin llenar nada | PHP rechaza con los errores de cada campo; no se guarda nada |  |  |
| PR-FORM-03 | Correo inválido | Abrir `procesar.php?nombre=Ana&correo=usuario&calificacion=4&libro=Ariel&comentario=comentario largo` | Error de correo válido |  |  |
| PR-FORM-04 | Calificación fuera de rango | Igual, con `calificacion=9` | Error de rango; no se guarda |  |  |
| PR-FORM-05 | Comentario demasiado corto | Comentario de menos de 10 caracteres | Error de longitud; no se guarda |  |  |
| PR-FORM-06 | Valor que no es texto | Abrir `procesar.php?nombre[]=x&correo=a@b.com&calificacion=3&libro=x&comentario=comentario largo` | Se muestra "El nombre es obligatorio"; sin error técnico |  |  |

## 2. Login y sesiones
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-LOG-01 | Login válido | Iniciar sesión con `admin_prueba` | Entra al panel con su nombre y rol |  |  |
| PR-LOG-02 | Contraseña incorrecta | Mismo usuario, contraseña equivocada | Mensaje genérico, sin decir qué falló |  |  |
| PR-LOG-03 | Usuario inactivo | Entrar con `inactivo_prueba` y su contraseña correcta | Mismo mensaje genérico |  |  |
| PR-LOG-04 | Página privada sin sesión | En incógnito, abrir `listar.php` | Redirige al login con aviso |  |  |
| PR-LOG-05 | Cerrar sesión | Cerrar sesión y escribir la dirección de `panel.php` | Redirige al login |  |  |
| PR-LOG-06 | Aviso que no es texto | Abrir `login_form.php?m[]=x` y `listar.php?mensaje[]=x` (esta con sesión) | Ambas cargan normal, sin error |  |  |

## 3. Seguridad
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-SEG-01 | Salida escapada | Guardar una reseña con el comentario `<b>prueba</b>` y abrir `resenas.php` | Se ve el texto con los símbolos, sin negritas |  |  |
| PR-SEG-02 | Contraseña como hash | En MySQL: `SELECT usuario, password_hash FROM usuarios;` | Cadenas que empiezan con `$2y$`; ninguna contraseña legible |  |  |
| PR-SEG-03 | Consultas preparadas | `grep -n "prepare(" *.php app/models/*.php` | Las operaciones que reciben datos usan `prepare(` |  |  |
| PR-SEG-04 | Error de conexión sin detalles | Cambiar temporalmente `"base"` en `config.php` y abrir `resenas.php`; **regresarlo** | Solo "El sistema no está disponible...", sin rutas ni usuario |  |  |
| PR-SEG-05 | Configuración ignorada | `git check-ignore -v semana14/config.php` | Responde con la regla de `.gitignore` |  |  |
| PR-SEG-06 | Sin secretos en el repositorio | `git ls-files \| grep config.php` | Solo aparece `config.ejemplo.php` |  |  |

## 4. CRUD y base de datos
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-CRUD-01 | Crear | Como administrador, **Nueva reseña** con datos válidos | Mensaje verde; el registro existe en MySQL |  |  |
| PR-CRUD-02 | Consultar | Abrir **Administrar reseñas** | Se listan las reseñas con sus datos reales |  |  |
| PR-CRUD-03 | Editar | Cambiar la calificación de una reseña de prueba y recargar | El cambio persiste, y solo en ese registro |  |  |
| PR-CRUD-04 | Id inexistente | Abrir `editar.php?id=9999` | Aviso rojo; no cambia ningún registro |  |  |
| PR-CRUD-05 | Id inválido | Abrir `editar.php?id=abc` | Aviso rojo; no cambia ningún registro |  |  |
| PR-CRUD-06 | Cancelar eliminación | Presionar **Eliminar** y **Cancelar** | El registro se conserva |  |  |
| PR-CRUD-07 | Eliminar | **Eliminar** y aceptar (solo una reseña de prueba) | Desaparece de la lista y de MySQL |  |  |
| PR-CRUD-08 | Eliminar por GET | Abrir `eliminar.php?id=...` con un id real | No borra nada; regresa a la lista |  |  |

## 5. Roles y permisosç
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-ROL-01 | Menú del administrador | Iniciar sesión con `admin_prueba` | Panel, Nueva reseña, Administrar reseñas, Reseñas públicas, Cerrar sesión |  |  |
| PR-ROL-02 | Menú de consulta | Iniciar sesión con `consulta_prueba` | Panel, Consultar reseñas, Reseñas públicas, Cerrar sesión |  |  |
| PR-ROL-03 | Creación directa sin permiso | Con consulta, abrir `crear.php` | "Acceso denegado" (403) |  |  |
| PR-ROL-04 | Eliminación sin permiso | Con consulta, enviar el formulario de eliminar de una reseña de prueba | "Acceso denegado"; el registro sigue en la base |  |  |
| PR-ROL-05 | Rol por la URL | Con consulta, abrir `crear.php?rol=administrador` | Sigue denegado |  |  |

## 6. Fetch API y JSON
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-API-01 | Endpoint con sesión | Abrir `api/resenas.php` con sesión | JSON válido, sin HTML ni correos |  |  |
| PR-API-02 | Endpoint sin sesión | En incógnito, abrir `api/resenas.php` | `401` en JSON, sin redirección |  |  |
| PR-API-03 | Método no permitido | Desde la consola: `fetch('api/resenas.php',{method:'POST'})` | `405` en JSON |  |  |
| PR-API-04 | Actualización sin recargar | Crear una reseña en otra pestaña y presionar **Actualizar lista** | Aparece sin recargar la página |  |  |
| PR-API-05 | Error del servidor en la interfaz | Cambiar `"base"` en `config.php` y abrir la lista; **regresarlo** | Mensaje general en rojo, sin detalles técnicos |  |  |

## 7. MVC, plantilla y componentes
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-ARQ-01 | SQL solo en el modelo | `grep -n "SELECT" resenas.php api/resenas.php` | No imprime nada |  |  |
| PR-ARQ-02 | Páginas con plantilla | `grep -ln "layouts/header.php" *.php app/views/resenas/*.php` | Lista las páginas migradas |  |  |
| PR-ARQ-03 | Endpoint sin plantilla | `grep -rn "layouts" api/ app/controllers/ app/models/` | No imprime nada |  |  |

## 8. Función avanzada
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| ID | Función | Pasos | Resultado esperado | Resultado obtenido | Estado |
|---|---|---|---|---|---|
| PR-BUS-01 | Búsqueda con resultados | Buscar `bell` | Solo coincidencias, sin recargar la página |  |  |
| PR-BUS-02 | Sin resultados | Buscar `zzzzzzzz` | Mensaje claro, no un error |  |  |
| PR-BUS-03 | Orden fuera de la lista | Abrir `api/resenas.php?orden=id%3B--` | `400`; no devuelve reseñas |  |  |
| PR-BUS-04 | Comodín literal | Abrir `api/resenas.php?q=%25` | Busca el carácter `%`; no devuelve toda la tabla |  |  |
| PR-BUS-05 | Búsqueda demasiado larga | Búsqueda de 51 caracteres (quitando `maxlength` desde las herramientas) | El servidor responde `400` |  |  |
| PR-BUS-06 | Resultado igual que la base de datos | Comparar el `total` de `?q=bell` con un `COUNT(*)` en MySQL | Los números coinciden |  |  |

---

## Casos de regresión
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

Después de **cada** corrección, repite como mínimo:

`PR-LOG-01`, `PR-LOG-04`, `PR-CRUD-01`, `PR-CRUD-02`, `PR-CRUD-03`, `PR-ROL-03`, `PR-API-01`, `PR-ARQ-01` y `PR-BUS-01`.

## Resumen de resultados
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Estado | Cantidad |
|---|---:|
| Correcta |  |
| Incorrecta |  |
| Pendiente |  |
| No aplica |  |
| **Total** | **42** |
