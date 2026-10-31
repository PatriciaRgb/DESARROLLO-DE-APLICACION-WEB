<?php
require_once "autorizacion.php";
exigirRol(["administrador", "consulta"]);

$esAdmin = tieneRol(["administrador"]);

// Avisos permitidos: lista cerrada, nunca se imprime lo que venga en la URL
$avisos = [
    "creado"    => ["exito", "Reseña guardada correctamente."],
    "editado"   => ["exito", "Reseña actualizada correctamente."],
    "eliminado" => ["exito", "Reseña eliminada correctamente."],
    "noexiste"  => ["error", "La reseña solicitada no existe."]
];

$aviso = null;
$claveAviso = $_GET["mensaje"] ?? "";
if (is_string($claveAviso) && array_key_exists($claveAviso, $avisos)) {
    $aviso = $avisos[$claveAviso];
}

$tituloPagina = $esAdmin ? "Administrar reseñas" : "Consultar reseñas";
require __DIR__ . "/app/views/layouts/header.php";
?>

        <h2><?php echo $esAdmin ? "Administrar reseñas" : "Consultar reseñas"; ?></h2>

        <?php if ($aviso !== null) { ?>
            <?php mostrarMensaje($aviso[0], $aviso[1]); ?>
        <?php } ?>

        <?php if ($esAdmin) { ?>
            <p><a class="btn-enlace" href="crear.php">+ Nueva reseña</a></p>
        <?php } ?>

        <p><button type="button" id="btnActualizar">Actualizar lista</button></p>

        <div id="estadoLista" role="status"></div>
        <div id="zonaTabla"></div>

        <noscript>
            <?php mostrarMensaje("error", "Activa JavaScript para ver la lista de reseñas."); ?>
        </noscript>

<?php
$scripts = ["listar.js"];
require __DIR__ . "/app/views/layouts/footer.php";
?>