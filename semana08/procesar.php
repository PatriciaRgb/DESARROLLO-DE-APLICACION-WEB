<?php
require_once "conexion.php";

// Los formularios del inicio pueden mandar los datos por GET o por POST
$datos = ($_SERVER["REQUEST_METHOD"] === "POST") ? $_POST : $_GET;

$nombre       = trim($datos["nombre"] ?? "");
$correo       = trim($datos["correo"] ?? "");
$libro        = trim($datos["libro"] ?? "");
$calificacion = trim($datos["calificacion"] ?? "");
$comentario   = trim($datos["comentario"] ?? "");

$errores = [];
$guardado = false;

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

// Guardar solo si no hay errores, con consulta preparada
if (count($errores) === 0) {
    try {
        $sql = "INSERT INTO resenas (nombre, correo, libro, calificacion, comentario, fecha)
                VALUES (?, ?, ?, ?, ?, CURDATE())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssis", $nombre, $correo, $libro, $calificacionInt, $comentario);
        $stmt->execute();
        $stmt->close();
        $guardado = true;
    } catch (mysqli_sql_exception $e) {
        error_log("Error al guardar reseña: " . $e->getMessage());
        $errores[] = "No fue posible guardar la reseña. Intenta de nuevo más tarde.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reseña recibida - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Resultado de tu reseña</h2>

        <?php if (count($errores) > 0) { ?>
            <div class="mensaje-error">
                <p>Se encontraron los siguientes errores:</p>
                <ul>
                    <?php foreach ($errores as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <?php if ($guardado) { ?>
            <div class="mensaje-exito">Reseña guardada correctamente en la base de datos.</div>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($correo, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Calificación:</strong> <?php echo (int)$calificacionInt; ?></p>
            <p><strong>Libro:</strong> <?php echo htmlspecialchars($libro, ENT_QUOTES, "UTF-8"); ?></p>
            <p><strong>Comentario:</strong> <?php echo htmlspecialchars($comentario, ENT_QUOTES, "UTF-8"); ?></p>
        <?php } ?>

        <p><a href="index.php">Volver al formulario</a> | <a href="listar.php">Administrar reseñas</a></p>

    </div>
</body>
</html>