# Diseño de Fetch API — Semana 10

**Proyecto:** 💐💐💐💐 El Árbol de Higos 💐💐💐💐
**Alumna:** Patricia Segura Resendiz

| Punto de la guía | Decisión |
|---|---|
| Módulo seleccionado | Consultar reseñas (solo lectura) |
| Archivo de la interfaz que inicia la petición | `listar.php`, con el script `listar.js` |
| Archivo PHP que atiende la petición | `api/resenas.php` |
| Método | GET |
| Datos que envía JavaScript | Ninguno en el cuerpo. La cookie de sesión viaja sola porque es la misma dirección |
| Permisos necesarios | `administrador` y `consulta` |
| Elemento que se actualiza | La tabla de reseñas (`#zonaTabla`) y el mensaje de estado (`#estadoLista`) |

## Formato de respuesta 🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

Éxito (200):

    {
      "ok": true,
      "puedeAdministrar": true,
      "total": 2,
      "datos": [
        { "id": 6, "nombre": "...", "libro": "...", "calificacion": 5,
          "comentario": "...", "fecha": "2026-10-13" }
      ]
    }

Error:

    { "ok": false, "mensaje": "Texto que se puede mostrar al usuario" }

## Códigos HTTP 🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

| Código | Cuándo |
|---|---|
| 200 | Consulta correcta |
| 401 | No hay ssesión |
| 403 | Hay sesión, pero el rol no tiene permiso |
| 405 | El método no es GET |
| 500 | Falla la conexión o la consulta (el detalle va al registro, no a la respuesta) |

## Decisiones de seguridad 🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

- El endpoint tiene su propia comprobación (`autorizacion_json.php`) porque `proteger.php` redirige al login, y `fetch()` recibiría HTML en lugar de JSON.
- La autorización se comprueba en el servidor con el rol de la sesión; el rol nunca se recibe del navegador.
- No se envía el correo de los usuarios.
- `display_errors` se apaga en el endpoint para que ningún aviso de PHP se mezcle con el JSON.
- Si falla la conexión, `conexion.php` responde en JSON (constante `RESPUESTA_JSON`).
- Al mostrar los datos en la tabla se usará `textContent`, nunca `innerHTML`.

## Limitación conocida 🌸🌸🌸🌷🌸🌸💐🌸🌸🌷🌸🌸💐💐

La comprobación de rol del endpoint (`exigirRolJson`) duplica en parte la de `autorizacion.php`. Se unificará al reorganizar el proyecto en la Semana 11.