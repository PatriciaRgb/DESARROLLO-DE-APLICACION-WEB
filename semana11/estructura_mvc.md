# Estructura MVC — Semana 11

**Proyecto:**💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Alumna:** Patricia Segura Resendiz

Este documento describe cómo quedó el módulo de **consulta de reseñas** después de reorganizarlo con una arquitectura inspirada en MVC. Se compara con `estructura_inicial.md`.

## 1. Estructura de carpetas
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

```text
semana11/
├── app/
│   ├── models/
│   │   └── Resena.php                 ← Modelo
│   ├── controllers/
│   │   └── ResenaController.php       ← Controlador
│   └── views/
│       └── resenas/
│           └── publicas.php           ← Vista
├── api/
│   └── resenas.php                    ← Punto de entrada JSON
├── resenas.php                        ← Punto de entrada de la página pública
├── conexion.php, config.php           ← Conexión (sin mover)
├── proteger.php, autorizacion*.php    ← Sesión y roles (sin mover)
├── listar.php, listar.js              ← Lista del administrador con Fetch (sin cambios)
├── crear.php, editar.php, eliminar.php, login.php, ...   ← Sin migrar
└── estilos.css
```

## 2. Responsabilidad de cada pieza
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐


| Pieza | Archivo | Qué hace | Qué NO hace |
|---|---|---|---|
| **Modelo** | `app/models/Resena.php` | Ejecuta las consultas a la tabla `resenas` y da forma a las filas: `obtenerTodas()` y `obtenerPorCalificacion()` | No imprime nada, no conoce la sesión ni el HTML, no crea la conexión |
| **Controlador** | `app/controllers/ResenaController.php` | Pide los datos al modelo, atrapa los errores, los registra y decide qué responder: `listarJson()` y `listarPublicas()` | No escribe SQL ni HTML |
| **Vista** | `app/views/resenas/publicas.php` | Presenta la tabla con los datos que recibe, escapando cada valor | No ejecuta consultas ni toma decisiones |
| **Punto de entrada** | `resenas.php`, `api/resenas.php` | Reciben la solicitud, comprueban lo necesario, llaman al controlador y entregan la respuesta | No tienen SQL |

## 3. Flujo de cada solicitud
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐


**Página pública (`resenas.php`):**

```text
Solicitud → resenas.php → ResenaController::listarPublicas()
                              ↓
                        Resena::obtenerPorCalificacion() ↔ MySQL
                              ↓
                  resenas.php entrega los datos a la vista
                              ↓
                  app/views/resenas/publicas.php → HTML
```

**Endpoint JSON (`api/resenas.php`):**

```text
Fetch → api/resenas.php
          ↓ 401 si no hay sesión · 405 si no es GET · 403 si el rol no sirve
   ResenaController::listarJson()
          ↓
   Resena::obtenerTodas() ↔ MySQL
          ↓
   código HTTP + JSON → listar.js dibuja la tabla
```

## 4. Qué se movió y dónde quedó
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Antes | Después |
|---|---|
| SQL de la lista dentro de `api/resenas.php` | `Resena::obtenerTodas()` |
| SQL de la página pública dentro de `resenas.php` | `Resena::obtenerPorCalificacion()` |
| HTML de `resenas.php` | `app/views/resenas/publicas.php` |
| Manejo del error 500 y cálculo de `puedeAdministrar` en el endpoint | `ResenaController::listarJson()` |
| Manejo del error de la página pública | `ResenaController::listarPublicas()` |

La consulta de reseñas dejó de estar duplicada en dos archivos: ahora solo existe en el modelo, y ningún punto de entrada contiene SQL.

## 5. Qué conservé sin cambios
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

- Los roles `administrador` y `consulta`, y las comprobaciones de sesión y rol en cada punto de entrada.
- La dirección y el formato JSON del endpoint, así que `listar.js` no se modificó.
- Las consultas con datos del usuario siguen usando consultas preparadas (están en el CRUD, que no migré).
- Todo valor mostrado en HTML se escapa en la vista; la tabla del navegador sigue usando `textContent`.
- Los errores se registran con `error_log()` y al usuario solo se le muestra un mensaje general.
- Las credenciales siguen en `config.php`, fuera del repositorio y fuera de las carpetas `app/`.

## 6. Descripción honesta de la organización
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐


Mi proyecto sigue una estructura **inspirada en MVC**, no un MVC completo:

- **No hay enrutador ni controlador frontal.** Cada punto de entrada es un archivo PHP delgado que llama al controlador.
- **La comprobación de sesión y rol sigue en los puntos de entrada**, no dentro del controlador. Lo hice así porque el endpoint JSON y la página reaccionan distinto ante una falla de permisos (JSON con 401 o 403, frente a una redirección o una página de "Acceso denegado"), y por eso conservé `autorizacion.php` y `autorizacion_json.php` separados. Esa duplicación queda como limitación.
- **Solo migré un módulo.** El alta, la edición, la eliminación y el login siguen con la estructura anterior: autorización, validación, SQL y HTML en el mismo archivo.

## 7. Pendiente para una siguiente versión
🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐


1. Migrar crear, editar y eliminar a modelo, controlador y vista.
2. Unificar la comprobación de rol en un solo mecanismo que pueda responder de las dos formas.
3. Agregar un enrutador para no tener un punto de entrada por archivo.