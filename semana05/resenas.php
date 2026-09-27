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

        <?php
            require_once "conexion.php";

            $sql = "SELECT * FROM resenas";
            $resultado = $conexion->query($sql);
        ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Libro</th>
                <th>Calificación</th>
                <th>Comentario</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila["id"]; ?></td>
                <td><?php echo $fila["nombre"]; ?></td>
                <td><?php echo $fila["libro"]; ?></td>
                <td><?php echo $fila["calificacion"]; ?></td>
                <td><?php echo $fila["comentario"]; ?></td>
            </tr>
            <?php } ?>
        </table>

        <p><a href="index.php">Volver al formulario</a></p>

    </div>
</body>
</html>