# 💐 EL ÁRBOL DE HIGOS
## Semana 11 — Arquitectura MVC
### Desarrollo de Aplicaciones Web

<table style="width:100%; border:none; margin-bottom:20px;">
<tr>
<td width="120" align="center" style="border:none;">
<img src="img/logo.png" width="100" alt="Logo">
</td>
<td align="right" style="border:none; padding: 20px 10px;">
<h1 style="color:#c2185b; font-family: Georgia, serif; letter-spacing: 2px; margin-bottom:5px;">💐💐💐💐 EL ÁRBOL DE HIGOS 💐💐💐💐</h1>
<p style="color:#ad1457; font-style: italic; font-size: 15px; margin:0;">Semana 11 — Arquitectura MVC</p>
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

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Objetivo</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Reorganizar una parte de mi tienda utilizando una arquitectura inspirada en MVC, separando el acceso a los datos, la lógica que coordina las solicitudes y la presentación de la información. El propósito fue mejorar la organización del código y facilitar su mantenimiento, conservando las funciones que ya tenía implementadas, como el inicio de sesión, los roles de usuario, la seguridad y las consultas mediante Fetch.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌷🌸💗🌸 Punto de partida</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Copié la Semana 10 a la carpeta <code>semana11</code> y comprobé que la aplicación funcionara correctamente antes de realizar cualquier modificación. Después elaboré un inventario para identificar cómo estaban organizados los archivos y las responsabilidades de cada uno. Esto me permitió tener una referencia para comparar la estructura inicial con la estructura final del proyecto (<code>estructura_inicial.md</code>).
</blockquote>

<div align="center">
<img src="img/01-proyecto-funcionando.png" width="500">
<p style="color:#c2185b; font-style:italic; font-size:13px;">Proyecto funcionando antes de reorganizar</p>
</div>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💗🌸💗🌸 Lo que encontré en el inventario</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Al revisar mis archivos observé que algunas responsabilidades estaban mezcladas. Por ejemplo, <code>api/resenas.php</code> comprobaba la sesión y el rol del usuario, ejecutaba las consultas SQL y preparaba la respuesta JSON en un mismo archivo. Por otra parte, <code>resenas.php</code> contenía tanto las consultas a la base de datos como el código HTML de la página. También encontré que algunas consultas de reseñas estaban repetidas. Por esta razón decidí reorganizar el módulo para separar mejor las responsabilidades.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌺🌸💗🌸 Qué es cada pieza</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;">
<th style="padding:8px; text-align:left;">Pieza</th>
<th style="padding:8px; text-align:left;">Archivo</th>
<th style="padding:8px; text-align:left;">Responsabilidad</th>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><b>Modelo</b></td>
<td style="padding:8px;"><code>app/models/Resena.php</code></td>
<td style="padding:8px;">Se encarga de realizar las consultas a la base de datos y obtener los registros. No presenta información HTML ni administra las sesiones.</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;"><b>Controlador</b></td>
<td style="padding:8px;"><code>app/controllers/ResenaController.php</code></td>
<td style="padding:8px;">Coordina las solicitudes, obtiene los datos del modelo, controla los errores y prepara la respuesta correspondiente.</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><b>Vista</b></td>
<td style="padding:8px;"><code>app/views/resenas/publicas.php</code></td>
<td style="padding:8px;">Se encarga de mostrar la información recibida y proteger la salida utilizando <code>htmlspecialchars()</code>.</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;"><b>Puntos de entrada</b></td>
<td style="padding:8px;"><code>resenas.php</code>, <code>api/resenas.php</code></td>
<td style="padding:8px;">Reciben las solicitudes, comprueban la sesión y los permisos, llaman al controlador y entregan la respuesta correspondiente.</td>
</tr>
</table>

```text
Solicitud → Punto de entrada → Controlador → Modelo ↔ MySQL
                                      ↓
                         Vista (HTML) o respuesta JSON
```

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💕🌸💗🌸 Cómo lo hice, paso a paso</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Realicé la reorganización por etapas para evitar afectar el funcionamiento de la aplicación. Primero creé el modelo y lo conecté con el endpoint, comprobando que la respuesta JSON conservara su estructura y que la lista de reseñas siguiera cargando correctamente. También realicé una prueba de error controlado modificando temporalmente el nombre de la tabla para comprobar que el modelo detectara el problema y que el endpoint respondiera con un mensaje general, sin mostrar información técnica. Después incorporé el controlador y la vista, y adapté la página pública para que utilizara el mismo modelo.
</blockquote>

<div align="center">
<table style="width:100%;">
<tr>
<td align="center" width="50%"><img src="img/02-modelo-endpoint-json.png" width="350"><p style="font-size:12px; color:#c2185b;">Endpoint utilizando el modelo</p></td>
<td align="center" width="50%"><img src="img/03-lista-con-modelo.png" width="350"><p style="font-size:12px; color:#c2185b;">Lista de reseñas funcionando</p></td>
</tr>
<tr>
<td align="center" width="50%"><img src="img/04-modelo-error-controlado.png" width="350"><p style="font-size:12px; color:#a33a2e;">Error del modelo manejado correctamente</p></td>
<td align="center" width="50%"><img src="img/09-resenas-error-controlado.png" width="350"><p style="font-size:12px; color:#a33a2e;">Error en la página pública manejado</p></td>
</tr>
</table>
</div>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Qué se movió y qué no</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;">
<th style="padding:8px; text-align:left;">Antes</th>
<th style="padding:8px; text-align:left;">Después</th>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;">SQL de la lista dentro de <code>api/resenas.php</code></td>
<td style="padding:8px;"><code>Resena::obtenerTodas()</code></td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;">SQL de la página pública dentro de <code>resenas.php</code></td>
<td style="padding:8px;"><code>Resena::obtenerPorCalificacion()</code></td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;">HTML de <code>resenas.php</code></td>
<td style="padding:8px;"><code>app/views/resenas/publicas.php</code></td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;">Manejo del error 500 y cálculo de <code>puedeAdministrar</code> en el endpoint</td>
<td style="padding:8px;"><code>ResenaController::listarJson()</code></td>
</tr>
</table>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333; margin-top:10px;">
No modifiqué los archivos <code>conexion.php</code>, <code>config.php</code> y <code>proteger.php</code>, ni los archivos de autorización, el inicio de sesión o las operaciones CRUD de crear, editar y eliminar. Decidí conservarlos para evitar afectar funcionalidades que ya estaban funcionando. La reorganización se concentró únicamente en el módulo de reseñas. Como resultado, las consultas correspondientes quedaron centralizadas en el modelo y los puntos de entrada dejaron de contener instrucciones SQL.
</blockquote>

<div align="center">
<img src="img/10-grep-sin-sql.png" width="500">
<p style="color:#c2185b; font-style:italic; font-size:13px;">Comprobación con grep: las consultas SQL están centralizadas en el modelo</p>
</div>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Seguridad, roles y Fetch conservados</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;">
<th style="padding:8px; text-align:left;">Medida</th>
<th style="padding:8px; text-align:left;">Estado después de reorganizar</th>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;">Sesión y rol en el servidor</td>
<td style="padding:8px;">Se siguen comprobando en cada punto de entrada, antes de llamar al controlador.</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;">Formato y dirección del endpoint JSON</td>
<td style="padding:8px;">Se conservaron sin cambios para que <code>listar.js</code> siguiera funcionando.</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;">Salida escapada</td>
<td style="padding:8px;"><code>htmlspecialchars()</code> en la vista y <code>textContent</code> en la tabla del navegador.</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;">Errores sin detalles técnicos</td>
<td style="padding:8px;">El controlador registra los errores mediante <code>error_log()</code> y muestra un mensaje general.</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;">Credenciales fuera del repositorio</td>
<td style="padding:8px;"><code>config.php</code> continúa ignorado por Git y fuera de <code>app/</code>.</td>
</tr>
</table>

<div align="center">
<table style="width:100%;">
<tr>
<td align="center" width="50%"><img src="img/05-resenas-publicas-vista.png" width="350"><p style="font-size:12px; color:#c2185b;">Página pública utilizando la vista</p></td>
<td align="center" width="50%"><img src="img/06-resenas-escape.png" width="350"><p style="font-size:12px; color:#c2185b;">El contenido HTML se muestra como texto</p></td>
</tr>
<tr>
<td align="center" width="50%"><img src="img/07-endpoint-con-controlador.png" width="350"><p style="font-size:12px; color:#c2185b;">Endpoint conectado al controlador</p></td>
<td align="center" width="50%"><img src="img/08-lista-con-controlador.png" width="350"><p style="font-size:12px; color:#c2185b;">Lista de reseñas con Fetch funcionando</p></td>
</tr>
<tr>
<td align="center" width="50%"><img src="img/11-consulta-crear-denegado.png" width="350"><p style="font-size:12px; color:#a33a2e;">La cuenta de consulta no tiene permiso para crear</p></td>
<td align="center" width="50%"><img src="img/12-logout-pagina-privada.png" width="350"><p style="font-size:12px; color:#c2185b;">Sin sesión, no se permite acceder a la página privada</p></td>
</tr>
</table>
</div>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Archivos creados o modificados</h2>

<table style="width:100%; border-collapse: collapse;">
<tr style="background-color:#c2185b; color:#ffffff;">
<th style="padding:8px; text-align:left;">Archivo</th>
<th style="padding:8px; text-align:left;">Estado</th>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><code>app/models/Resena.php</code></td>
<td style="padding:8px;">Nuevo</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;"><code>app/controllers/ResenaController.php</code></td>
<td style="padding:8px;">Nuevo</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><code>app/views/resenas/publicas.php</code></td>
<td style="padding:8px;">Nuevo</td>
</tr>
<tr style="background-color:#ffffff;">
<td style="padding:8px;"><code>resenas.php</code>, <code>api/resenas.php</code></td>
<td style="padding:8px;">Modificados. Ahora funcionan como puntos de entrada.</td>
</tr>
<tr style="background-color:#fce4ec;">
<td style="padding:8px;"><code>estructura_inicial.md</code>, <code>estructura_mvc.md</code>, <code>pruebas_mvc.md</code></td>
<td style="padding:8px;">Nuevos documentos de organización y comprobación.</td>
</tr>
</table>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌺🌸💗🌸 Tablas de la base de datos involucradas</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Durante esta reorganización únicamente trabajé con la tabla <code>resenas</code> para consultar los registros. No modifiqué su estructura ni alteré otras tablas de la base de datos.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸🌸💗🌸 Pruebas realizadas</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Realicé las pruebas establecidas en la guía para comprobar el funcionamiento de la aplicación antes y después de la reorganización. Verifiqué la conexión entre el modelo, el controlador y la vista, la consulta de reseñas, la respuesta del endpoint en formato JSON, la carga de información mediante Fetch y el manejo de errores. También comprobé que se conservaran las restricciones de acceso según los roles de usuario y que las páginas privadas no fueran accesibles sin iniciar sesión. La prueba 7, relacionada con la reorganización de las operaciones de creación o actualización, no aplicó porque el cambio se limitó a la consulta de reseñas. Los resultados y sus respectivas capturas se encuentran en <code>pruebas_mvc.md</code>.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Errores encontrados</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Durante el proceso de reorganización fue necesario revisar cuidadosamente las rutas de los archivos y las conexiones entre los diferentes componentes. Uno de los aspectos que requirió mayor atención fue comprobar que los puntos de entrada pudieran localizar correctamente el modelo y el controlador después de crear las nuevas carpetas. También revisé que los errores generados durante las consultas no mostraran información técnica al usuario. Para solucionar y prevenir estos problemas comprobé las rutas utilizadas en los archivos PHP, revisé las respuestas del endpoint y volví a probar la carga de las reseñas. Después de las modificaciones, la aplicación continuó funcionando correctamente.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌷🌸💗🌸 Una observación de diseño</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Durante el trabajo pensé que reorganizar el módulo con MVC también permitiría eliminar la duplicación entre <code>autorizacion.php</code> y <code>autorizacion_json.php</code>, pero comprendí que ambas tienen responsabilidades diferentes al momento de responder ante una falta de permisos. La página puede redirigir al usuario o mostrar un mensaje de acceso denegado, mientras que el endpoint debe responder con un formato JSON y el código HTTP correspondiente. Por eso decidí mantener ambos archivos separados y documentar esta situación como una decisión de diseño.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">💗🌸💗🌸 Limitaciones</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Mi proyecto tiene una estructura inspirada en MVC, pero todavía no implementa este patrón de manera completa. No cuenta con un enrutador ni con un controlador frontal; en su lugar, cada punto de entrada es un archivo PHP que recibe la solicitud y llama al controlador correspondiente. Además, la reorganización se concentró únicamente en el módulo de reseñas. Las operaciones de alta, edición, eliminación y el inicio de sesión conservan su organización anterior. Estas partes representan oportunidades de mejora que podrían trabajarse posteriormente y quedaron documentadas en <code>estructura_mvc.md</code>.
</blockquote>

<br>

<h2 style="color:#c2185b; border-bottom: 3px solid #f48fb1; padding-bottom: 6px;">🌸💗🌸 Conclusión personal</h2>

<blockquote style="border-left: 4px solid #f48fb1; background:#fff0f5; padding: 10px 15px; color:#333;">
Esta actividad me permitió comprender de una manera más práctica la importancia de organizar correctamente el código de una aplicación web. Antes de realizar la actividad, algunas funciones estaban concentradas en los mismos archivos, por lo que resultaba más complicado identificar dónde se realizaban las consultas, dónde se procesaban los datos y dónde se mostraba la información.

Al trabajar con el modelo, el controlador y la vista pude entender mejor la función de cada componente y cómo se relacionan entre sí. También comprendí que utilizar una arquitectura MVC no significa solamente crear nuevas carpetas o mover archivos, sino separar las responsabilidades para que el proyecto sea más fácil de mantener y modificar.

Algo que considero importante fue comprobar que la reorganización no afectara las funciones que ya tenía implementadas, especialmente el inicio de sesión, los permisos de los usuarios, la seguridad y las consultas mediante Fetch. Las pruebas me ayudaron a verificar que los cambios se realizaran correctamente y que la aplicación continuara funcionando.

Finalmente, reconozco que todavía existen partes del proyecto que podrían reorganizarse en el futuro. Sin embargo, considero que este primer paso fue importante porque ahora tengo una estructura más clara en el módulo de reseñas y una mejor comprensión de cómo aplicar MVC en un proyecto real. 
</blockquote>

<br>

<p align="center" style="color:#c2185b; font-family:Georgia,serif; font-style:italic;">
💗 El Árbol de Higos · Semana 11 · Arquitectura MVC 💗
</p>