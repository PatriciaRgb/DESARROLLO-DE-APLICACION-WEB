# Análisis de componentes — Semana 12

**Proyecto:**💐💐💐💐  El Árbol de Higos 💐💐💐💐 
**Alumna:** Patricia Segura Resendiz

Revisé las páginas de mi aplicación para encontrar qué elementos se repiten. Esta tabla describe el estado **antes** de usar plantilla.

## 1. Elementos repetidos 🌷🌸💗🌸

| Elemento repetido | Páginas donde aparece | Componente propuesto | Beneficio esperado |
|---|---|---|---|
| Estructura del documento (`<!DOCTYPE>`, `<head>`, enlace al CSS, apertura de `<body>` y del contenedor `#principal`) | `index.php`, `login_form.php`, `panel.php`, `listar.php`, `crear.php`, `editar.php`, `procesar.php`, la vista de reseñas públicas y la página de "Acceso denegado" | `layouts/header.php` | Cambiar el `<head>` o el CSS en un solo lugar |
| Encabezado con el nombre del sistema (`<h1>`) | Las mismas páginas | `layouts/header.php` | Nombre y título consistentes |
| Menú de navegación | Solo `index.php` y `panel.php` lo tienen; las demás páginas tienen enlaces sueltos al final, distintos entre sí | `layouts/menu.php` | Navegación igual en todas las páginas, adaptada al rol |
| Mensajes de éxito y de error | `crear.php`, `editar.php`, `procesar.php`, `listar.php`, `login_form.php` y la vista de reseñas públicas, cada una con su propio fragmento | `layouts/mensajes.php` | Avisos uniformes, con tipos permitidos y salida escapada |
| Pie de página | No existe; hay enlaces como "Volver al panel" o "Cerrar sesión" repetidos al final de cada página | `layouts/footer.php` | Un pie único y un lugar para cargar los scripts |
| Campos de formulario (etiqueta + campo + valor escapado) | `crear.php` y `editar.php` (cinco campos en cada uno), y los dos formularios de `index.php` | `componentes/campo.php` | Evitar repetir y olvidar `htmlspecialchars()` |

## 2. Qué NO se convierte en plantilla 🌷🌸💗🌸

| Archivo | Por qué |
|---|---|
| `api/resenas.php` | Responde JSON. Si incluyera el encabezado HTML, `listar.js` no podría leerlo |
| `listar.js` | Es JavaScript del navegador |
| La tabla que dibuja `listar.js` | La arma el navegador con los datos del JSON |

## 3. Decisión de diseño 🌷🌸💗🌸
 
Cada página incluye `header.php` y `footer.php` y escribe su contenido entre los dos. Elegí este esquema en lugar de una plantilla que "recibe" el nombre de la vista, porque así **ninguna ruta de `include` depende de un dato externo**: todos los nombres de archivo los escribo yo en el código.

La página puede definir antes del encabezado:

- `$tituloPagina`: el título de la pestaña.
- `$scripts` (antes del pie): la lista de archivos JavaScript que necesita, escrita en el código.

## 4. Estructura 🌷🌸💗🌸

```text
app/views/
├── layouts/
│   ├── header.php
│   ├── menu.php
│   ├── mensajes.php
│   └── footer.php
├── componentes/
│   └── campo.php
└── resenas/
    └── publicas.php
```

## 5. Reglas que respeto 🌷🌸💗🌸

- El menú cambia según la sesión y el rol, pero **solo es comodidad**: cada página protegida sigue comprobando sesión y rol en el servidor.
- Los endpoints JSON no usan la plantilla.
- Los componentes no ejecutan consultas SQL.
- Todo dato dinámico que muestran se escapa.
