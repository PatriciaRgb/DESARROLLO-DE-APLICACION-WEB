<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseñas - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Reseñas de nuestros lectores</h2>

        <?php if ($errorConsulta) { ?>
            <div class="mensaje-error">No fue posible mostrar las reseñas en este momento.</div>

        <?php } elseif (count($resenas) === 0) { ?>
            <div class="mensaje-error">Todavía no hay reseñas registradas.</div>

        <?php } else { ?>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Libro</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                </tr>
                <?php foreach ($resenas as $resena) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($resena["nombre"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo htmlspecialchars($resena["libro"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo (int)$resena["calificacion"]; ?></td>
                    <td><?php echo htmlspecialchars($resena["comentario"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo $resena["fecha"] ? htmlspecialchars($resena["fecha"], ENT_QUOTES, "UTF-8") : "—"; ?></td>
                </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <p><a href="index.php">Volver al inicio</a></p>

    </div>
</body>
</html>