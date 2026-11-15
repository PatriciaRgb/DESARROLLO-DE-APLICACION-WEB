# Registro de errores — Semana 14

**Proyecto:** El Árbol de Higos
**Alumna:** Patricia Segura Resendiz

Este registro reúne los errores reales que encontré durante el semestre y los que aparezcan al ejecutar `plan_pruebas.md`. Cada error se enlaza con el caso de prueba que comprueba su corrección.

**Regla:** un error no se marca como corregido hasta que el caso de prueba correspondiente se ejecuta y pasa. La columna **Estado** se llena al ejecutar el plan.

## Errores del semestre

| ID | Semana | Descripción | Causa identificada | Corrección | Nueva prueba | Estado |
|---|---|---|---|---|---|---|
| ERR-01 | 6 | Al escribir `USE arbol_de_higos;` y `SELECT ...` directamente en Git Bash apareció `command not found` | Esos comandos son de MySQL, no de Git Bash; solo funcionan dentro del cliente (`mysql>`) | Entrar primero con `mysql.exe -u root -p` y escribir los comandos ya dentro | No aplica (error de procedimiento, no del código) | Resuelto |
| ERR-02 | 6 y 7 | Se apagó la laptop a medio trabajo y `editar.php` no estaba en la carpeta | El archivo no se había guardado ni subido a Git | Volver a crearlo y guardarlo con `Ctrl+S`; comprobar con `git status` y `git log` qué estaba a salvo | No aplica (error de procedimiento) | Resuelto |
| ERR-03 | 7 | `listar.php` abría en una ventana de incógnito sin haber iniciado sesión, y hasta permitía editar | Los archivos del CRUD no tenían la línea que incluye `proteger.php` (el `grep` no devolvió ningún resultado) | Agregar `require_once "proteger.php";` como primera línea de `listar.php`, `crear.php`, `editar.php` y `eliminar.php`, y verificar con `grep` | PR-LOG-04 |  |
| ERR-04 | 8 | `resenas.php`, la página pública, mostraba en negritas un comentario con `<b>prueba</b>`: el HTML del visitante se ejecutaba | Imprimía los datos de MySQL sin escapar; ese archivo venía de la Semana 05 y no se actualizó | `htmlspecialchars()` en cada dato de usuario (hoy en la vista de reseñas públicas) | PR-SEG-01 |  |
| ERR-05 | 8 | Las credenciales de MySQL estaban en el repositorio y un error de conexión mostraba la pila de llamadas, rutas y usuario | Datos escritos directamente en `conexion.php`; la excepción de PHP 8.2 no se atrapaba | Datos en `config.php` ignorado por `.gitignore`; `try / catch` con `error_log()` y mensaje general | PR-SEG-04, PR-SEG-05, PR-SEG-06 |  |
| ERR-06 | 9 | `pruebas_roles_permisos.md` referenciaba una imagen (`13-admin-crud-funciona.png`) que no existía | Los nombres de las capturas no coincidían con los de los archivos reales (`13.0-...`, `13.02-...`, `13.03-...`) | Corregir las referencias y verificar con un comando que revisa todas las imágenes de los documentos | Revisión de imágenes de todo el repositorio (ver `estado_inicial.md`) |  |
| ERR-07 | 12 | Una dirección como `listar.php?mensaje[]=x` o `login_form.php?m[]=x` puede provocar un error fatal en PHP 8 | El valor de la URL puede ser un arreglo y el código daba por hecho que era texto | Comprobar con `is_string()` antes de usarlo | PR-LOG-06 |  |
| ERR-08 | 12 | Un envío como `nombre[]=x` en `procesar.php`, `crear.php` o `editar.php` provoca un error fatal que muestra datos técnicos. Existía desde la Semana 06 y la auditoría de la Semana 08 no lo vio | `trim()` recibía un arreglo | Ayudante `textoDato()` / `textoPost()`: lo que no es texto se trata como vacío | PR-FORM-06 |  |

## Errores encontrados al ejecutar el plan de pruebas (Semana 14)

Hasta que se ejecute el plan completo no hay errores nuevos registrados. Cuando un caso de `plan_pruebas.md` resulte `Incorrecta`, se agrega aquí una fila (ERR-09, ERR-10, ...) con el mismo formato de la tabla anterior: la descripción con los pasos que lo provocan, la causa comprobada, la corrección, el caso que se repitió y el estado final.

## Pasos para cada error nuevo

1. Reproduce el problema y anota los pasos exactos.
2. Identifica la causa probable **y compruébala**.
3. Haz una corrección controlada (un cambio a la vez).
4. Repite el caso que falló.
5. Repite los casos de regresión indicados en `plan_pruebas.md`.
6. Anota el resultado final en la columna **Estado**.
