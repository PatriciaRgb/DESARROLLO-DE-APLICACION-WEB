# Proyecto integrador — Desarrollo de Aplicaciones Web 🌷🌸🌸🌸

**Alumna:** Patricia Segura Resendiz
**Docente:** Ing. José de Jesús Collazo Reyes
**Institución:** Instituto Tecnológico Superior de Rioverde — Ingeniería en Sistemas Computacionales
**Periodo:** agosto–diciembre 2026

## 1. Nombre del proyecto 🌷🌸🌸🌸

**El Árbol de Higos**, una pequeña tienda de libros en línea.

## 2. Problema que resuelve 🌷🌸🌸🌸

Una librería pequeña necesita saber qué opinan sus lectores y administrar esas opiniones sin que cualquiera pueda modificarlas. La aplicación permite que cualquier lector deje una reseña, y que solo las personas autorizadas la consulten, editen o eliminen. Todavía no tiene catálogo de libros ni carrito: hoy resuelve la parte de las reseñas.

## 3. Objetivo general 🌷🌸🌸🌸

Construir, de forma progresiva durante el semestre, una aplicación web funcional con PHP, MySQL, HTML, CSS y JavaScript, que guarde información de manera permanente, controle quién accede a ella y esté organizada, probada y documentada.

## 4. Usuarios y funciones principalesm 🌷🌸🌸🌸

| Usuario | Funciones |
|---|---|
| Lector (sin cuenta) | Dejar una reseña y ver las reseñas publicadas |
| Consulta | Además, consultar, buscar y ordenar la lista del panel |
| Administrador | Todo lo anterior, y crear, editar y eliminar reseñas |

## 5. Tecnologías utilizadas

| Tecnología | Para qué se usó |
|---|---|
| HTML | Estructura de las páginas |
| CSS | Presentación: paleta rosa pastel, formularios, tablas, Flexbox y diseño adaptable (`@media`) |
| JavaScript | Validación en el navegador, interacciones y Fetch API |
| PHP 8.2 | Procesamiento, validación, sesiones, autorización y respuestas JSON |
| MySQL 8 (`mysqli`) | Almacenamiento permanente de reseñas y usuarios |
| Git y GitHub (SSH) | Control de versiones: un commit por cada avance |
| WampServer | Entorno local (Apache, PHP y MySQL) |

## 6. Estructura de la aplicación

La versión final está en `semana14`. Las carpetas `semana01` a `semana13` conservan el avance de cada semana.

```text
semana14/
├── app/
│   ├── models/          Resena.php — acceso a los datos
│   ├── controllers/     ResenaController.php — coordina y valida
│   ├── views/
│   │   ├── layouts/     encabezado, menú, mensajes y pie
│   │   ├── componentes/ campos de formulario
│   │   └── resenas/     vista de reseñas públicas
│   └── helpers/         lectura segura de datos
├── api/                 resenas.php — endpoint JSON
├── conexion.php, config.ejemplo.php
├── autorizacion.php, autorizacion_json.php, proteger.php
├── páginas: index, panel, listar, crear, editar, eliminar,
│            login_form, login, logout, procesar, resenas
├── listar.js, script.js, estilos.css
└── esquema.sql
```

**Cómo evolucionó semana a semana:**

| Semana | Se agregó |
|---|---|
| 1 | PHP y HTML: primera página con variables, tipos de datos y una operación |
| 2 | Formularios con GET y POST, validaciones y mensajes |
| 3 | CSS: formulario con estilo, modelo de caja, Flexbox y diseño adaptable |
| 4 | JavaScript: eventos, DOM, validación en el navegador |
| 5 | MySQL: guardar y consultar información de forma permanente |
| 6 | CRUD completo con consultas preparadas |
| 7 | Login, sesiones y páginas protegidas |
| 8 | Auditoría de seguridad y correcciones |
| 9 | Roles y permisos |
| 10 | Fetch API y JSON |
| 11 | Arquitectura inspirada en MVC |
| 12 | Plantilla y componentes reutilizables |
| 13 | Búsqueda y ordenamiento |
| 14 | Pruebas de integración y registro de errores |
| 15 | Presentación del proyecto |

## 7. Diseño de la base de datos

Base de datos `arbol_de_higos`, con dos tablas.

**`resenas`**

| Campo | Tipo | Notas |
|---|---|---|
| `id` | INT | Llave primaria, `AUTO_INCREMENT` |
| `nombre` | VARCHAR(100) | Obligatorio |
| `correo` | VARCHAR(150) | |
| `libro` | VARCHAR(150) | Obligatorio |
| `calificacion` | INT | De 1 a 5 (validado en PHP) |
| `comentario` | TEXT | De 10 a 1000 caracteres (validado en PHP) |
| `fecha` | DATE | Se llena con `CURDATE()` al guardar |

**`usuarios`**

| Campo | Tipo | Notas |
|---|---|---|
| `id` | INT | Llave primaria, `AUTO_INCREMENT` |
| `nombre` | VARCHAR(100) | Obligatorio |
| `usuario` | VARCHAR(50) | Único |
| `correo` | VARCHAR(150) | Único |
| `password_hash` | VARCHAR(255) | Solo el hash, nunca la contraseña |
| `activo` | TINYINT(1) | 1 puede entrar, 0 está desactivado |
| `creado_en` | TIMESTAMP | |
| `rol` | VARCHAR(30) | `administrador` o `consulta` (con `CHECK`); por defecto `consulta` |

La estructura completa, sin datos, está en `esquema.sql`.

## 8. Autenticación, roles y seguridad

- **Login:** `login.php` busca al usuario con una consulta preparada, comprueba que esté activo y verifica la contraseña con `password_verify()`. Si falla, el mensaje es siempre el mismo. Al entrar se regenera el identificador de sesión.
- **Páginas protegidas:** `proteger.php` y `autorizacion.php` comprueban la sesión en el servidor, antes de enviar cualquier HTML.
- **Roles:** el rol se lee de la base de datos al iniciar sesión y se guarda en `$_SESSION`; nunca se acepta de un formulario ni de la URL. El menú cambia según el rol, pero **ocultar un botón no se considera protección**: cada página y cada acción comprueba el rol.
- **Consultas preparadas** para todo valor recibido del usuario. En el orden de la búsqueda, el nombre de la columna sale de una lista permitida, nunca de la petición.
- **Salida escapada:** `htmlspecialchars()` en HTML y `textContent` en JavaScript.
- **Errores:** el detalle técnico va al registro del servidor y al usuario solo se le muestra un mensaje general.
- **Credenciales:** en `config.php`, ignorado por Git; en el repositorio solo hay una plantilla.

## 9. Implementación de Fetch API

La lista de reseñas del panel la carga `listar.js` con `fetch()` a `api/resenas.php` y se actualiza sin recargar la página.

- **Petición:** GET, con los parámetros opcionales `q` (búsqueda), `orden` y `dir`.
- **Respuesta:** JSON con `ok`, `puedeAdministrar`, `total`, `filtros` y `datos`; o `{"ok": false, "mensaje": ...}` si hay error.
- **Códigos HTTP:** 200, 400 (parámetros inválidos), 401 (sin sesión), 403 (sin permiso), 405 (método no permitido) y 500 (fallo del servidor).
- **Decisión importante:** el endpoint tiene su propia comprobación de sesión y rol, que responde en JSON. Las páginas redirigen al login, y `fetch()` recibiría HTML en lugar de JSON.
- `listar.js` revisa `respuesta.ok` a mano (porque `fetch()` no trata un 403 o un 500 como error) y pinta los datos con `textContent`.

## 10. Organización MVC y componentes

- **Modelo** (`Resena.php`): solo ejecuta las consultas; no imprime nada ni conoce la sesión.
- **Controlador** (`ResenaController.php`): valida los parámetros, pide los datos al modelo, atrapa los errores y decide qué responder.
- **Vista** (`app/views/resenas/publicas.php`): presenta los datos, escapándolos.
- **Plantilla y componentes:** `header.php`, `menu.php`, `mensajes.php`, `footer.php` y el componente de campos de formulario. Cada página incluye el encabezado y el pie con rutas escritas en el código, nunca tomadas de la URL. El endpoint JSON no usa la plantilla.

Solo migré a MVC el módulo de consulta de reseñas; el alta, la edición, la eliminación y el login conservan la estructura anterior.

## 11. Función avanzada: búsqueda y ordenamiento

La lista del panel permite buscar texto en nombre, libro y comentario, y ordenar por ID, nombre, libro, calificación o fecha, ascendente o descendente.

- Los parámetros se validan: `q` de 0 a 50 caracteres, `orden` y `dir` solo de las listas permitidas. Lo que no cumple se rechaza con un 400.
- El texto buscado va como parámetro de una consulta preparada, y se escapan los comodines de `LIKE` (`%`, `_` y `\`).
- El servidor vuelve a validar aunque el navegador ya limite la longitud: lo comprobé quitando ese límite desde las herramientas de desarrollador.

## 12. Pruebas realizadas y resultados

En la Semana 14 ejecuté un plan de **45 casos** (`plan_pruebas.md`) sobre formularios, login, seguridad, CRUD, roles, Fetch, MVC y búsqueda. **Los 45 resultaron correctos.** Además, cada semana tuvo sus propias pruebas con capturas, documentadas en su carpeta.

## 13. Errores encontrados y soluciones

| Semana | Error | Solución |
|---|---|---|
| 7 | `listar.php` abría sin sesión | Agregar `proteger.php` al inicio de las páginas del CRUD |
| 8 | La página pública ejecutaba el HTML escrito por un visitante | `htmlspecialchars()` en cada dato de usuario |
| 8 | Credenciales en el repositorio y errores técnicos en pantalla | `config.php` ignorado por Git y `try / catch` con mensaje general |
| 12 | `?mensaje[]=x` provocaba un error fatal | Comprobar con `is_string()` |
| 12 | `nombre[]=x` provocaba un error fatal; mi auditoría de la Semana 8 no lo vio | Ayudante que trata lo que no es texto como vacío |
| 14 | Errores del propio plan de pruebas (una prueba con la cuenta equivocada, un comando que no mostraba lo esperado y un total mal contado) | Se corrigieron y se repitió la prueba |

El registro completo, con la causa y el caso que comprueba cada corrección, está en `registro_errores.md`.

## 14. Evidencias

Cada carpeta `semana01` a `semana14` tiene su `evidencia.md` con capturas, pruebas y reflexión; `semana14` reúne el estado inicial, el plan de pruebas y el registro de errores. El `README.md` de la raíz explica cómo instalar y ejecutar el proyecto. El historial de commits en GitHub muestra el avance de cada semana.

## 15. Limitaciones conocidas

- Los formularios no tienen token CSRF.
- El login no limita los intentos.
- Solo el módulo de consulta de reseñas sigue MVC.
- La comprobación de rol está duplicada entre las páginas y el endpoint JSON.
- No hay módulo de gestión de usuarios: los roles se asignan en la base de datos.
- La lista no tiene paginación.
- `index.php` y la página de "Acceso denegado" no usan la plantilla.
- Que los 45 casos pasaran no prueba que no haya fallas: un plan solo encuentra lo que alguien pensó en buscar.

## 16. Mejoras futuras

1. Migrar el alta, la edición, la eliminación y el login a MVC y unificar la autorización.
2. Agregar token CSRF y límite de intentos al login.
3. Un módulo para administrar usuarios y sus roles.
4. Paginación de la lista.
5. El catálogo de libros y un carrito, que era la idea original de la tienda.
6. Un enrutador y un punto de entrada único.

## 17. Conclusión personal

Empecé el semestre con una página de PHP que mostraba un libro y un total, y terminé con una aplicación que guarda reseñas, controla quién puede hacer qué y se puede probar. Lo que más aprendí no fue una tecnología, sino una forma de trabajar: avanzar en pasos pequeños, comprobar cada uno y guardar cada avance con un commit. También aprendí que una aplicación que funciona no es necesariamente una aplicación segura.