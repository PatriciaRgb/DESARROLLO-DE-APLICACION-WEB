# Diseño de la función avanzada — Semana 13
🌷🌸🌸🌸🌷🌸🌸🌸🌸🌷🌸🌸

**Proyecto:** 💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Alumna:** Patricia Segura Resendiz

## Función elegida
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

Búsqueda y ordenamiento de la lista de reseñas.

## Problema que resuelve
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

La lista de reseñas crece con cada reseña nueva y hoy solo se puede ver completa, sin forma de encontrar una reseña concreta ni de verlas ordenadas por calificación, fecha o libro.

## Usuarios
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

- `administrador` y `consulta`: ambos pueden buscar y ordenar, porque es una operación de solo lectura.

## Datos que necesita
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Parámetro | Tipo | Regla |
|---|---|---|
| `q` | Texto | Opcional; de 0 a 50 caracteres; busca en nombre, libro y comentario |
| `orden` | Texto | Opcional; solo `id`, `nombre`, `libro`, `calificacion` o `fecha` |
| `dir` | Texto | Opcional; solo `asc` o `desc` |

Valores por defecto: sin búsqueda, `orden=id` y `dir=desc` (la misma lista de ahora).

## Módulo e integración
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

Se integra a la lista del administrador (`listar.php` + `listar.js`), que ya usa Fetch, y reutiliza la organización MVC:

- **Modelo** (`Resena.php`): método `buscar()` con consulta preparada.
- **Controlador** (`ResenaController.php`): valida los parámetros y decide la respuesta.
- **Punto de entrada** (`api/resenas.php`): lee los parámetros y los pasa al controlador.
- **Interfaz**: `listar.php` y `listar.js`.

## Seguridad
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

- El texto de búsqueda va como **parámetro** de una consulta preparada; los comodines `%` y `_` que escriba el usuario se escapan.
- El nombre de la columna **nunca** se arma con lo recibido: se busca en una lista permitida definida en el servidor.
- Un parámetro inválido se rechaza con `400`; no se corrige en silencio.
- Se conservan la comprobación de sesión (401) y de rol (403) del endpoint.
- Los resultados se pintan con `textContent`.

## Permisos
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

El endpoint exige sesión y uno de los roles `administrador` o `consulta`.

## Pruebas necesarias
🌷🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

1. Búsqueda con coincidencias.
2. Búsqueda sin resultados.
3. Parámetro `q` demasiado largo.
4. `orden` fuera de la lista permitida (incluyendo un intento de inyección).
5. `dir` inválido.
6. Comodines `%` y `_` escritos por el usuario.
7. Sin sesión (401) y método no permitido (405).
8. Que el CRUD y las funciones anteriores sigan funcionando.