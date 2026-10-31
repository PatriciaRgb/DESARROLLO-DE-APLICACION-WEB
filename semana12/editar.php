<?php
require_once "autorizacion.php";
exigirRol(["administrador"]);
require_once "conexion.php";
require_once __DIR__ . "/app/helpers/entrada.php";

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

    $nombre       = textoPost("nombre");
    $correo       = textoPost("correo");
    $libro        = textoPost("libro");
    $calificacion = textoPost("calificacion");
    $comentario   = textoPost("comentario");

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

$tituloPagina = "Editar reseña";
require_once __DIR__ . "/app/views/componentes/campo.php";
require __DIR__ . "/app/views/layouts/header.php";
?>

        <h2>Editar reseña #<?php echo (int)$id; ?></h2>

        <?php mostrarErrores($errores); ?>

        <form action="editar.php" method="POST" novalidate>

            <input type="hidden" name="id" value="<?php echo (int)$id; ?>">

            <?php campoFormulario("nombre", "Nombre:", $nombre); ?>
            <?php campoFormulario("correo", "Correo electrónico:", $correo, "email"); ?>
            <?php campoFormulario("libro", "Libro reseñado:", $libro); ?>
            <?php campoFormulario("calificacion", "Calificación (1-5):", $calificacion, "number", 1, 5); ?>
            <?php campoAreaTexto("comentario", "Tu reseña:", $comentario); ?>

            <button type="submit">Guardar cambios</button>
        </form>

        <p><a href="listar.php">Cancelar y volver a la lista</a></p>

<?php require __DIR__ . "/app/views/layouts/footer.php"; ?>