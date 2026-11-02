<?php
$tituloPagina = "Reseñas";
require __DIR__ . "/../layouts/header.php";
?>

        <h2>Reseñas de nuestros lectores</h2>

        <?php if ($errorConsulta) { ?>
            <?php mostrarMensaje("error", "No fue posible mostrar las reseñas en este momento."); ?>

        <?php } elseif (count($resenas) === 0) { ?>
            <?php mostrarMensaje("advertencia", "Todavía no hay reseñas registradas."); ?>

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

<?php require __DIR__ . "/../layouts/footer.php"; ?>