<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseña recibida</title>
</head>
<body>
    <h1>El Árbol de Higos</h1>
    <h2>Resultado de tu reseña</h2>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $nombre = $_GET['nombre'];
            $correo = $_GET['correo'];
            $calificacion = $_GET['calificacion'];
            $comentario = $_GET['comentario'];
        } else {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $calificacion = $_POST['calificacion'];
            $comentario = $_POST['comentario'];
        }

        $errores = array();

        // Validar nombre
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        }

        // Validar correo
        if (empty($correo)) {
            $errores[] = "El correo es obligatorio.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Debes proporcionar un correo válido.";
        }

        // Validar calificación
        if (empty($calificacion)) {
            $errores[] = "La calificación es obligatoria.";
        } elseif (!is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
            $errores[] = "La calificación debe ser un número entre 1 y 5.";
        }

        // Validar comentario
        if (empty($comentario)) {
            $errores[] = "El comentario es obligatorio.";
        }

        // Mostrar resultado
        if (count($errores) > 0) {
            echo "<h3>Se encontraron los siguientes errores:</h3>";
            echo "<ul>";
            foreach ($errores as $error) {
                echo "<li>⚠️ $error</li>";
            }
            echo "</ul>";
        } else {
            echo "<h3>✔️ Información recibida correctamente</h3>";
            echo "<p><strong>Nombre:</strong> $nombre</p>";
            echo "<p><strong>Correo:</strong> $correo</p>";
            echo "<p><strong>Calificación:</strong> $calificacion</p>";
            echo "<p><strong>Comentario:</strong> $comentario</p>";
        }
    ?>

</body>
</html>