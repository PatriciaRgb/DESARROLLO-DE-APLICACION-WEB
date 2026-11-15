# 💐💐💐💐El Árbol de Higos 💐💐💐💐

Aplicación web de una pequeña tienda de libros, desarrollada durante el semestre en la materia **Desarrollo de Aplicaciones Web** (Instituto Tecnológico Superior de Rioverde, Ingeniería en Sistemas Computacionales, agosto–diciembre 2026).

**Autora:** Patricia Segura Resendiz
**Docente:** Ing. José de Jesús Collazo Reyes

Los lectores pueden dejar reseñas de libros, y el personal autorizado las administra con control de acceso por roles.

## Funciones 💐💐💐💐

- **Parte pública:** formulario para dejar una reseña (con validación en el navegador y en el servidor) y página con las reseñas publicadas.
- **Acceso:** inicio de sesión, sesiones y cierre de sesión. Las contraseñas se guardan con `password_hash()`.
- **Roles:** `administrador` (consulta, crea, edita y elimina) y `consulta` (solo consulta). La autorización se comprueba en el servidor.
- **CRUD de reseñas** con consultas preparadas y validación en PHP.
- **Lista con Fetch API:** se actualiza sin recargar la página, con un endpoint que responde JSON.
- **Búsqueda y ordenamiento** de la lista, con valores validados y una lista permitida para el orden.
- **Plantilla y componentes:** encabezado, menú según el rol, mensajes y pie reutilizables.
- **Organización inspirada en MVC** en el módulo de consulta de reseñas.

## Tecnologías 💐💐💐💐

PHP 8.2 · MySQL 8 (con `mysqli`) · HTML · CSS · JavaScript (Fetch API) · Git y GitHub.

## Requisitos 💐💐💐💐

- Windows con **WampServer** (Apache 2.4, PHP 8.2 y MySQL 8), o un entorno equivalente.
- Git.
- Un navegador actual.

## Instalación 💐💐💐💐

### 1. Obtener el proyecto

```bash
git clone git@github.com:PatriciaRgb/DESARROLLO-DE-APLICACION-WEB.git
```

La versión final está en la carpeta **`semana14`**. Las carpetas `semana01` a `semana13` conservan el avance de cada semana.

### 2. Crear la base de datos 💐💐💐💐

Con WampServer en verde, desde la raíz del repositorio:

```bash
mysql -u root -p < semana14/esquema.sql
```

(En WampServer el ejecutable está en `C:\wamp64\bin\mysql\<versión>\bin\mysql.exe`.) Esto crea la base `arbol_de_higos` con las tablas `resenas` y `usuarios`, **sin datos**.

### 3. Configurar la conexión 💐💐💐💐

Los datos de conexión **no están en el repositorio**. En la carpeta `semana14`, copia la plantilla y edítala con tus datos:

```bash
cp semana14/config.ejemplo.php semana14/config.php
```

`config.php` está en `.gitignore`: no lo subas a GitHub.

### 4. Crear el primer usuario administrador 💐💐💐💐

Genera el hash de una contraseña que elijas (no uses una que emplees en otros servicios):

```bash
php -r "echo password_hash('ESCRIBE_AQUI_TU_CLAVE', PASSWORD_DEFAULT);"
```

En MySQL, inserta el usuario con ese hash. La columna `rol` acepta solo `administrador` o `consulta`:

```sql
USE arbol_de_higos;
INSERT INTO usuarios (nombre, usuario, correo, password_hash, rol)
VALUES ('Administrador', 'admin', 'admin@example.com', 'PEGA_AQUI_EL_HASH', 'administrador');
```

La contraseña nunca se guarda en la base de datos: solo su hash.

### 5. Datos de demostración (opcional) 💐💐💐💐

Para ver la aplicación con reseñas de ejemplo (todas ficticias):

```bash
mysql -u root -p < semana14/datos_demo.sql
```

Incluye una reseña con HTML en el comentario, que sirve para comprobar que la salida se escapa.

### 6. Ejecutar 💐💐💐💐

```bash
cd semana14
php -S localhost:8000
```

Abre `http://localhost:8000`. El acceso de administración está en el menú ("Acceso administrador").

## Cuentas de demostración 💐💐💐💐

Para las pruebas se usan dos cuentas con permisos distintos: una con rol `administrador` y otra con rol `consulta`. Sus contraseñas no se publican; se crean siguiendo el paso 4.

## Estructura de la versión final 💐💐💐💐

```text
semana14/
├── app/
│   ├── models/          Resena.php — acceso a los datos
│   ├── controllers/     ResenaController.php — coordina y valida
│   ├── views/
│   │   ├── layouts/     header, menú, mensajes y pie
│   │   ├── componentes/ campos de formulario
│   │   └── resenas/     vista de reseñas públicas
│   └── helpers/         lectura segura de datos
├── api/                 resenas.php — endpoint JSON
├── conexion.php         conexión a MySQL (lee config.php)
├── config.ejemplo.php   plantilla de configuración (sin secretos)
├── autorizacion.php     roles en páginas
├── autorizacion_json.php roles en el endpoint JSON
├── proteger.php         exige sesión
├── index.php, panel.php, listar.php, crear.php, editar.php, eliminar.php,
│   login_form.php, login.php, logout.php, procesar.php, resenas.php
├── listar.js, script.js
├── estilos.css
└── esquema.sql          estructura de la base de datos, sin datos
```

## Seguridad 💐💐💐💐

- Consultas preparadas para todo valor que recibe del usuario.
- Validación en PHP aunque el navegador también valide.
- Salida escapada con `htmlspecialchars()` en HTML y `textContent` en JavaScript.
- Contraseñas con `password_hash()` y `password_verify()`.
- Control de acceso por rol en el servidor; ocultar un botón no se considera protección.
- El orden de la búsqueda usa una lista permitida: el nombre de la columna nunca sale de la petición.
- Errores técnicos al registro del servidor, con mensajes generales para el usuario.
- Credenciales fuera del repositorio.

## Pruebas 💐💐💐💐

El plan de pruebas y sus resultados están en `semana14/plan_pruebas.md`, y los errores encontrados y corregidos en `semana14/registro_errores.md`.

## Limitaciones conocidas 💐💐💐💐

- Los formularios no tienen token CSRF y el login no limita los intentos.
- Solo el módulo de consulta de reseñas sigue la organización MVC; el alta, la edición, la eliminación y el login siguen con la estructura anterior.
- La comprobación de rol está duplicada entre las páginas y el endpoint JSON.
- No hay módulo para gestionar usuarios: los roles se asignan en la base de datos.
- La lista no tiene paginación.
- La tienda aún no tiene catálogo de libros ni carrito: hoy gestiona las reseñas.