<table style="width:100%; border:none; margin-bottom:20px;">
<tr>
<td width="120" align="center" style="border:none;">
<img src="img/logo.png" width="100" alt="Logo">
</td>
<td align="right" style="border:none; padding: 20px 10px;">
<h1 style="color:#c2185b; font-family: Georgia, serif; letter-spacing: 2px; margin-bottom:5px;">💐💐💐💐 EL ÁRBOL DE HIGOS 💐💐💐💐</h1>
<p style="color:#ad1457; font-style: italic; font-size: 15px; margin:0;">Semana 14 — Pruebas, integración y correcciones</p>
<p style="color:#e91e8c; font-size: 13px; margin:0;">Desarrollo de Aplicaciones Web</p>
</td>
</tr>
</table>

<br>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;">
<td style="padding:8px;"><b>Alumna</b></td>
<td style="padding:8px;">Patricia Segura Resendiz</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><b>Institución</b></td>
<td style="padding:8px;">Instituto Tecnológico Superior de Rioverde</td>
</tr>
<tr style="background-color:#c2185b; color:#ffffff;">
<td style="padding:8px;"><b>Carrera</b></td>
<td style="padding:8px;">Ingeniería en Sistemas Computacionales</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><b>Docente</b></td>
<td style="padding:8px;">Ing. José de Jesús Collazo Reyes</td>
</tr>
<tr style="background-color:#c2185b; color:#ffffff;">
<td style="padding:8px;"><b>Entorno</b></td>
<td style="padding:8px;">WampServer · Apache 2.4.59 · PHP 8.2.18 · MySQL 8.0.42</td>
</tr>
</table>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸🌸🌸🌸 Objetivo</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Comprobar que todas las partes de mi tienda funcionan <b>en conjunto</b>, no solo cada una por separado como las fui probando semana a semana: formularios, login, roles, CRUD, Fetch, MVC, plantilla y búsqueda. Y registrar con honestidad lo que encontrara.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌷🌸🌸🌸 Cómo preparé la revisión</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Copié la Semana 13 a <code>semana14</code> y marqué esa versión de partida con una etiqueta de Git (<code>semana14-inicio</code>), que es mi forma de recuperar la versión estable si una corrección rompiera algo. Documenté el punto de partida en <code>estado_inicial.md</code>: la estructura de archivos, los problemas que ya conocía y las cuentas de demostración (sin contraseñas). Después armé <code>plan_pruebas.md</code> <b>antes</b> de ejecutar nada.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💗🌸🌸🌸 El plan de pruebas</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;"><th style="padding:8px; text-align:left;">Módulo</th><th style="padding:8px; text-align:left;">Casos</th><th style="padding:8px; text-align:left;">Qué se comprueba</th></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">Formularios y validaciones</td><td style="padding:8px;">6</td><td style="padding:8px;">Datos válidos, campos vacíos, correo, rango, longitud y valores que no son texto</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">Login y sesiones</td><td style="padding:8px;">6</td><td style="padding:8px;">Acceso correcto, contraseña incorrecta, usuario desactivado, páginas privadas y cierre de sesión</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">Seguridad</td><td style="padding:8px;">6</td><td style="padding:8px;">Salida escapada, hash de contraseñas, consultas preparadas, errores sin detalles y configuración fuera del repositorio</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">CRUD y base de datos</td><td style="padding:8px;">8</td><td style="padding:8px;">Crear, consultar, editar, identificadores inválidos, cancelar y confirmar la eliminación</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">Roles y permisos</td><td style="padding:8px;">5</td><td style="padding:8px;">Menús por rol, rutas directas y eliminación sin permiso</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">Fetch API y JSON</td><td style="padding:8px;">5</td><td style="padding:8px;">JSON válido, 401 y 405, actualización sin recargar y errores controlados</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">MVC, plantilla y componentes</td><td style="padding:8px;">3</td><td style="padding:8px;">SQL solo en el modelo, páginas con plantilla y endpoint sin plantilla</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">Función avanzada</td><td style="padding:8px;">6</td><td style="padding:8px;">Búsqueda, orden, valores no permitidos, comodines y coincidencia con la base de datos</td></tr>
<tr style="background-color:#c2185b; color:#ffffff;"><td style="padding:8px;"><b>Total</b></td><td style="padding:8px;"><b>45</b></td><td style="padding:8px;"></td></tr>
</table>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌺🌸🌸 Resultado de las pruebas</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;"><th style="padding:8px; text-align:left;">Estado</th><th style="padding:8px; text-align:left;">Cantidad</th></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">Correcta</td><td style="padding:8px;">45</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">Incorrecta</td><td style="padding:8px;">0</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">Pendiente</td><td style="padding:8px;">0</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">No aplica</td><td style="padding:8px;">0</td></tr>
</table>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333; margin-top:10px;">
Ejecuté cada caso en mi aplicación, agrupándolos para cambiar de cuenta lo menos posible: sin sesión (ventana de incógnito), cuenta de consulta, administrador, terminal y MySQL, y las pruebas que modifican la configuración, que dejé al final y revertí. Las reseñas que creé para probar las eliminé al terminar. El detalle de cada caso, con sus pasos y su resultado, está en <code>plan_pruebas.md</code>.
<br><br>
Como ningún caso salió incorrecto, no hizo falta corregir código esta semana y no repetí los casos de regresión.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💕🌸🌸🌸 Errores del plan de pruebas</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Aunque la aplicación pasó las pruebas, <b>el propio plan tenía errores</b> que encontré al ejecutarlo:
</blockquote>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;"><th style="padding:8px; text-align:left;">Qué ocurrió</th><th style="padding:8px; text-align:left;">Corrección</th></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;"><b>PR-LOG-03</b> (usuario desactivado): la hice primero con la cuenta de consulta, que está <b>activa</b>, así que no probaba lo que decía</td><td style="padding:8px;">La repetí con una cuenta desactivada y su contraseña correcta, y la dejé registrada como Pendiente hasta entonces</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;"><b>PR-SEG-06</b> (sin secretos en el repositorio): el comando buscaba <code>config.php</code> y no habría mostrado la plantilla <code>config.ejemplo.php</code></td><td style="padding:8px;">Lo cambié a <code>grep config</code></td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">El plan decía 42 casos y en realidad son 45</td><td style="padding:8px;">Corregí el total</td></tr>
</table>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸🌸🌸 Registro de errores del semestre</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
En <code>registro_errores.md</code> reuní los errores reales que encontré durante el semestre, cada uno con su causa, su corrección y el caso del plan que comprueba que quedó corregido:
</blockquote>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;"><th style="padding:8px; text-align:left;">Semana</th><th style="padding:8px; text-align:left;">Error</th><th style="padding:8px; text-align:left;">Comprobado con</th></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">7</td><td style="padding:8px;"><code>listar.php</code> abría sin sesión: faltaba <code>proteger.php</code> en el CRUD</td><td style="padding:8px;">PR-LOG-04</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">8</td><td style="padding:8px;">La página pública ejecutaba el HTML escrito por un visitante</td><td style="padding:8px;">PR-SEG-01</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">8</td><td style="padding:8px;">Credenciales en el repositorio y errores técnicos en pantalla</td><td style="padding:8px;">PR-SEG-04, 05 y 06</td></tr>
<tr style="background-color:#ffffff;"><td style="padding:8px;">12</td><td style="padding:8px;"><code>?mensaje[]=x</code> provocaba un error fatal</td><td style="padding:8px;">PR-LOG-06</td></tr>
<tr style="background-color:#fce4ec;"><td style="padding:8px;">12</td><td style="padding:8px;"><code>nombre[]=x</code> provocaba un error fatal; mi auditoría de la Semana 8 no lo vio</td><td style="padding:8px;">PR-FORM-06</td></tr>
</table>

<p style="color:#c2185b; font-size:13px; margin-top:8px;">Además se registraron dos errores de procedimiento (comandos de MySQL escritos en Git Bash, y un archivo sin guardar cuando se apagó la laptop) y uno de documentación (imágenes con nombres que no coincidían).</p>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌷🌸🌸 Archivos creados</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
<code>estado_inicial.md</code>, <code>plan_pruebas.md</code>, <code>registro_errores.md</code> y <code>evidencia.md</code>. El código de <code>semana14</code> es el de <code>semana13</code>, sin modificaciones, porque no hubo fallas que corregir. La estructura de archivos y las tablas utilizadas (<code>resenas</code> y <code>usuarios</code>) son las descritas en <code>estado_inicial.md</code> y <code>README.md</code>.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💐🌸🌸🌸Limitaciones</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Que los 45 casos hayan pasado no significa que la aplicación no tenga fallas: solo demuestra que se comporta como mi plan esperaba. Lo que mi auditoría de la Semana 8 no vio hasta la Semana 12 es la prueba de que un plan solo encuentra los errores que alguien pensó en buscar. Los pendientes conocidos siguen documentados en <code>estado_inicial.md</code>: no hay token CSRF, el login no limita los intentos, solo el módulo de consulta de reseñas sigue MVC, y <code>index.php</code> y la página de "Acceso denegado" no usan la plantilla.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸🌸🌸 Reflexión final</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Esta semana entendí que probar no es repetir lo que ya sé que funciona: es buscar activamente cómo puede fallar. Lo que más me enseñó fue lo que salió mal en mi propio plan: una prueba que parecía pasar pero no probaba lo que decía, y un comando que no habría mostrado lo que yo quería comprobar. También aprendí a registrar cada error con su causa y con la prueba que demuestra que se corrigió, y a no marcar nada como corregido sin volver a ejecutar esa prueba. Y volví a ver que una revisión solo encuentra lo que se piensa buscar: el error de los valores que no son texto estuvo en mi código desde la Semana 6 y pasó dos revisiones. Mi tienda "El Árbol de Higos" ya no solo funciona: ahora tengo un plan, un registro y una versión estable a la que puedo volver.
</blockquote>

<br>
