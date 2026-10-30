<?php
require_once "conexion.php";

$filas = [];
$errorConsulta = false;

try {
    $resultado = $conexion->query("SELECT nombre, libro, calificacion, comentario, fecha
                                   FROM resenas
                                   ORDER BY calificacion DESC, id DESC");
    while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
    }
} catch (mysqli_sql_exception $e) {
    error_log("Error al consultar reseñas públicas: " . $e->getMessage());
    $errorConsulta = true;
}
?>
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

        <?php } elseif (count($filas) === 0) { ?>
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
                <?php foreach ($filas as $fila) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila["nombre"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo htmlspecialchars($fila["libro"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo (int)$fila["calificacion"]; ?></td>
                    <td><?php echo htmlspecialchars($fila["comentario"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo $fila["fecha"] ? htmlspecialchars($fila["fecha"], ENT_QUOTES, "UTF-8") : "—"; ?></td>
                </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <p><a href="index.php">Volver al inicio</a></p>

    </div>
</body>
</html>