<?php
require_once "conexion.php";

$errores = [];
$exito = false;

$nombre = "";
$correo = "";
$libro = "";
$calificacion = "";
$comentario = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $libro = trim($_POST["libro"] ?? "");
    $calificacion = trim($_POST["calificacion"] ?? "");
    $comentario = trim($_POST["comentario"] ?? "");

    // Validaciones del servidor
    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    } elseif (mb_strlen($nombre) > 100) {
        $errores[] = "El nombre no puede tener más de 100 caracteres.";
    }

    if ($correo === "") {
        $errores[] = "El correo es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Debes proporcionar un correo válido.";
    } elseif (mb_strlen($correo) > 150) {
        $errores[] = "El correo no puede tener más de 150 caracteres.";
    }

    if ($libro === "") {
        $errores[] = "Debes indicar qué libro estás reseñando.";
    } elseif (mb_strlen($libro) > 150) {
        $errores[] = "El nombre del libro no puede tener más de 150 caracteres.";
    }

    $calificacionInt = filter_var($calificacion, FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 1, "max_range" => 5]
    ]);
    if ($calificacionInt === false) {
        $errores[] = "La calificación debe ser un número entero entre 1 y 5.";
    }

    if ($comentario === "") {
        $errores[] = "El comentario es obligatorio.";
    }

    // Guardar solo si no hay errores
    if (count($errores) === 0) {
        try {
            $sql = "INSERT INTO resenas (nombre, correo, libro, calificacion, comentario, fecha)
                    VALUES (?, ?, ?, ?, ?, CURDATE())";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssis", $nombre, $correo, $libro, $calificacionInt, $comentario);
            $stmt->execute();
            $stmt->close();

            $exito = true;
            $nombre = $correo = $libro = $calificacion = $comentario = "";
        } catch (mysqli_sql_exception $e) {
            error_log("Error al guardar reseña: " . $e->getMessage());
            $errores[] = "No fue posible guardar la reseña. Intenta de nuevo más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva reseña - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Registrar una reseña</h2>

        <?php if ($exito) { ?>
            <div class="mensaje-exito">Reseña guardada correctamente.</div>
        <?php } ?>

        <?php if (count($errores) > 0) { ?>
            <div class="mensaje-error">
                <ul>
                    <?php foreach ($errores as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <form action="crear.php" method="POST" novalidate>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo"
                   value="<?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="libro">Libro reseñado:</label>
            <input type="text" id="libro" name="libro"
                   value="<?php echo htmlspecialchars($libro, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="calificacion">Calificación (1-5):</label>
            <input type="number" id="calificacion" name="calificacion" min="1" max="5"
                   value="<?php echo htmlspecialchars($calificacion, ENT_QUOTES, 'UTF-8'); ?>">

            <label for="comentario">Tu reseña:</label>
            <textarea id="comentario" name="comentario" rows="4"><?php echo htmlspecialchars($comentario, ENT_QUOTES, 'UTF-8'); ?></textarea>

            <button type="submit">Guardar reseña</button>
        </form>

        <p><a href="resenas.php">Ver reseñas</a> | <a href="index.php">Volver al inicio</a></p>

    </div>
</body>
</html>