<?php
require_once "autorizacion.php";
exigirRol(["administrador"]);
require_once "conexion.php";
require_once __DIR__ . "/app/helpers/entrada.php";

$errores = [];
$exito = false;

$nombre = "";
$correo = "";
$libro = "";
$calificacion = "";
$comentario = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre       = textoPost("nombre");
    $correo       = textoPost("correo");
    $libro        = textoPost("libro");
    $calificacion = textoPost("calificacion");
    $comentario   = textoPost("comentario");

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
    } elseif (mb_strlen($comentario) < 10) {
        $errores[] = "El comentario debe tener al menos 10 caracteres.";
    } elseif (mb_strlen($comentario) > 1000) {
        $errores[] = "El comentario no puede tener más de 1000 caracteres.";
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

$tituloPagina = "Nueva reseña";
require_once __DIR__ . "/app/views/componentes/campo.php";
require __DIR__ . "/app/views/layouts/header.php";
?>

        <h2>Registrar una reseña</h2>

        <?php if ($exito) { ?>
            <?php mostrarMensaje("exito", "Reseña guardada correctamente."); ?>
        <?php } ?>

        <?php mostrarErrores($errores); ?>

        <form action="crear.php" method="POST" novalidate>

            <?php campoFormulario("nombre", "Nombre:", $nombre); ?>
            <?php campoFormulario("correo", "Correo electrónico:", $correo, "email"); ?>
            <?php campoFormulario("libro", "Libro reseñado:", $libro); ?>
            <?php campoFormulario("calificacion", "Calificación (1-5):", $calificacion, "number", 1, 5); ?>
            <?php campoAreaTexto("comentario", "Tu reseña:", $comentario); ?>

            <button type="submit">Guardar reseña</button>
        </form>

<?php require __DIR__ . "/app/views/layouts/footer.php"; ?>