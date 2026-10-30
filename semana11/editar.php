<?php
require_once "autorizacion.php";
exigirRol(["administrador"]);
require_once "conexion.php";

$esPost = ($_SERVER["REQUEST_METHOD"] === "POST");

// 1) Validar el id (de la URL al abrir, del campo oculto al guardar)
$idCrudo = $esPost ? ($_POST["id"] ?? "") : ($_GET["id"] ?? "");
$id = filter_var($idCrudo, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

if ($id === false) {
    header("Location: listar.php?mensaje=noexiste");
    exit;
}

// 2) Buscar la reseña actual (consulta preparada)
try {
    $stmt = $conexion->prepare(
        "SELECT nombre, correo, libro, calificacion, comentario FROM resenas WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $actual = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log("Error al consultar reseña: " . $e->getMessage());
    exit("No fue posible consultar la reseña en este momento.");
}

// Si el id no corresponde a ningún registro, no hay nada que editar
if (!$actual) {
    header("Location: listar.php?mensaje=noexiste");
    exit;
}

// 3) Valores iniciales: los de la base de datos
$errores = [];
$nombre       = $actual["nombre"];
$correo       = $actual["correo"] ?? "";
$libro        = $actual["libro"];
$calificacion = (string)($actual["calificacion"] ?? "");
$comentario   = $actual["comentario"] ?? "";

// 4) Si se envió el formulario, validar y actualizar
if ($esPost) {

    $nombre       = trim($_POST["nombre"] ?? "");
    $correo       = trim($_POST["correo"] ?? "");
    $libro        = trim($_POST["libro"] ?? "");
    $calificacion = trim($_POST["calificacion"] ?? "");
    $comentario   = trim($_POST["comentario"] ?? "");

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
} elseif (mb_strlen($comentario) < 10) {
    $errores[] = "El comentario debe tener al menos 10 caracteres.";
} elseif (mb_strlen($comentario) > 1000) {
    $errores[] = "El comentario no puede tener más de 1000 caracteres.";
}
    if (count($errores) === 0) {
        try {
            $sql = "UPDATE resenas
                    SET nombre = ?, correo = ?, libro = ?, calificacion = ?, comentario = ?
                    WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssisi", $nombre, $correo, $libro, $calificacionInt, $comentario, $id);
            $stmt->execute();
            $stmt->close();

            header("Location: listar.php?mensaje=editado");
            exit;
        } catch (mysqli_sql_exception $e) {
            error_log("Error al actualizar reseña: " . $e->getMessage());
            $errores[] = "No fue posible actualizar la reseña. Intenta de nuevo más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar reseña - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Editar reseña #<?php echo (int)$id; ?></h2>

        <?php if (count($errores) > 0) { ?>
            <div class="mensaje-error">
                <ul>
                    <?php foreach ($errores as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <form action="editar.php" method="POST" novalidate>

            <input type="hidden" name="id" value="<?php echo (int)$id; ?>">

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

            <button type="submit">Guardar cambios</button>
        </form>

        <p><a href="listar.php">Cancelar y volver a la lista</a></p>

    </div>
</body>
</html>