<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseña recibida</title>
</head>
<body>
    <h1>El Árbol de Higos</h1>
    <h2>Reseña recibida</h2>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $nombre = $_GET['nombre'];
            $correo = $_GET['correo'];
            $calificacion = $_GET['calificacion'];
            $comentario = $_GET['comentario'];
            echo "<p><em>Datos recibidos mediante GET</em></p>";
        } else {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $calificacion = $_POST['calificacion'];
            $comentario = $_POST['comentario'];
            echo "<p><em>Datos recibidos mediante POST</em></p>";
        }

        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Correo:</strong> $correo</p>";
        echo "<p><strong>Calificación:</strong> $calificacion</p>";
        echo "<p><strong>Comentario:</strong> $comentario</p>";
    ?>

</body>
</html>