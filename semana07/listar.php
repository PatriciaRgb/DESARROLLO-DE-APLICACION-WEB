<?php
require_once "proteger.php";
require_once "conexion.php";

// Mensajes permitidos (lista cerrada: nunca se imprime lo que venga en la URL)
$mensajes = [
    "creado"    => "Reseña guardada correctamente.",
    "editado"   => "Reseña actualizada correctamente.",
    "eliminado" => "Reseña eliminada correctamente.",
    "noexiste"  => "La reseña solicitada no existe."
];

$aviso = "";
$claseAviso = "mensaje-exito";
if (isset($_GET["mensaje"]) && array_key_exists($_GET["mensaje"], $mensajes)) {
    $aviso = $mensajes[$_GET["mensaje"]];
    if ($_GET["mensaje"] === "noexiste") {
        $claseAviso = "mensaje-error";
    }
}

$filas = [];
$errorConsulta = false;

try {
    $resultado = $conexion->query("SELECT id, nombre, libro, calificacion, comentario, fecha
                                   FROM resenas
                                   ORDER BY id DESC");
    while ($fila = $resultado->fetch_assoc()) {
        $filas[] = $fila;
    }
} catch (mysqli_sql_exception $e) {
    error_log("Error al listar reseñas: " . $e->getMessage());
    $errorConsulta = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar reseñas - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Administrar reseñas</h2>

        <?php if ($aviso !== "") { ?>
            <div class="<?php echo $claseAviso; ?>"><?php echo $aviso; ?></div>
        <?php } ?>

        <p><a class="btn-enlace" href="crear.php">+ Nueva reseña</a></p>

        <?php if ($errorConsulta) { ?>
            <div class="mensaje-error">No fue posible consultar las reseñas en este momento.</div>

        <?php } elseif (count($filas) === 0) { ?>
            <div class="mensaje-error">Todavía no hay reseñas registradas.</div>

        <?php } else { ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Libro</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($filas as $fila) { ?>
                <tr>
                    <td><?php echo (int)$fila["id"]; ?></td>
                    <td><?php echo htmlspecialchars($fila["nombre"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo htmlspecialchars($fila["libro"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo (int)$fila["calificacion"]; ?></td>
                    <td><?php echo htmlspecialchars($fila["comentario"], ENT_QUOTES, "UTF-8"); ?></td>
                    <td><?php echo $fila["fecha"] ? htmlspecialchars($fila["fecha"], ENT_QUOTES, "UTF-8") : "—"; ?></td>
                    <td>
                        <a class="btn-enlace" href="editar.php?id=<?php echo (int)$fila["id"]; ?>">Editar</a>

                        <form class="form-inline" action="eliminar.php" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres eliminar esta reseña?');">
                            <input type="hidden" name="id" value="<?php echo (int)$fila["id"]; ?>">
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } ?>

        <p><a href="panel.php">Volver al panel</a> | <a href="logout.php">Cerrar sesión</a></p>

    </div>
</body>
</html>