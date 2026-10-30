<?php
require_once "autorizacion.php";
exigirRol(["administrador", "consulta"]);

$esAdmin = tieneRol(["administrador"]);

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
        <h2><?php echo $esAdmin ? "Administrar reseñas" : "Consultar reseñas"; ?></h2>

        <?php if ($aviso !== "") { ?>
            <div class="<?php echo $claseAviso; ?>"><?php echo $aviso; ?></div>
        <?php } ?>

        <?php if ($esAdmin) { ?>
            <p><a class="btn-enlace" href="crear.php">+ Nueva reseña</a></p>
        <?php } ?>

        <p><button type="button" id="btnActualizar">Actualizar lista</button></p>

        <div id="estadoLista" role="status"></div>
        <div id="zonaTabla"></div>

        <noscript>
            <div class="mensaje-error">Activa JavaScript para ver la lista de reseñas.</div>
        </noscript>

        <p><a href="panel.php">Volver al panel</a> | <a href="logout.php">Cerrar sesión</a></p>

    </div>

    <script src="listar.js"></script>
</body>
</html>