# Descripción del proyecto — Semana 15 🌷🌸🌸🌸
💐💐💐💐💐💐💐💐
**Alumna:** Patricia Segura Resendiz
**Materia:** Desarrollo de Aplicaciones Web — Instituto Tecnológico Superior de Rioverde
**Docente:** Ing. José de Jesús Collazo Reyes

## ¿Cómo se llama la aplicación? 🌷🌸🌸🌸

**El Árbol de Higos**, una pequeña tienda de libros en línea.

## ¿Qué problema resuelve? 🌷🌸🌸🌸

Una librería pequeña necesita saber qué opinan sus lectores sobre los libros y poder administrar esas opiniones sin que cualquiera pueda modificarlas. La aplicación permite que cualquier lector deje una reseña, y que solo las personas autorizadas puedan consultarla, editarla o eliminarla.

La aplicación todavía no tiene catálogo de libros ni carrito de compras: hoy resuelve la parte de las reseñas, que es la que construí completa.

## ¿Quiénes son sus usuarios? 🌷🌸🌸🌸

| Usuario | Qué puede hacer |
|---|---|
| **Lector** (sin cuenta) | Dejar una reseña y ver las reseñas publicadas |
| **Consulta** (con cuenta) | Además, consultar, buscar y ordenar la lista de reseñas en el panel |
| **Administrador** (con cuenta) | Todo lo anterior, y crear, editar y eliminar reseñas |

## ¿Qué información administra? 🌷🌸🌸🌸

- **Reseñas:** nombre del lector, correo, libro reseñado, calificación del 1 al 5, comentario y fecha.
- **Usuarios:** nombre, usuario, correo, rol (`administrador` o `consulta`), estado (activo o desactivado) y el hash de su contraseña. La contraseña nunca se guarda.

## ¿Cuáles son sus funciones principales? 🌷🌸🌸🌸

1. Formulario público para dejar una reseña, con validación en el navegador y en el servidor.
2. Página pública con las reseñas, ordenadas de mejor a peor calificación.
3. Inicio de sesión, sesiones y cierre de sesión.
4. Roles y permisos: cada cuenta solo puede hacer lo que su rol permite, comprobado en el servidor.
5. CRUD de reseñas (crear, consultar, editar y eliminar) con consultas preparadas.
6. Lista del panel con Fetch API: se actualiza sin recargar la página.
7. Búsqueda y ordenamiento de la lista, con parámetros validados.
8. Interfaz consistente mediante una plantilla y componentes reutilizables, con un menú que cambia según el rol.

## ¿Qué característica la distingue? 🌷🌸🌸🌸

Tiene una identidad propia de librería: una interfaz en tonos rosa pastel con el logo de la tienda, pensada para quienes aman leer. Y su desarrollo quedó documentado semana a semana, con pruebas, errores encontrados y limitaciones reconocidas, de modo que se puede explicar no solo qué hace, sino por qué se tomó cada decisión.
