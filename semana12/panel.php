<?php
require_once "autorizacion.php";

$tituloPagina = "Panel";
require __DIR__ . "/app/views/layouts/header.php";
?>

        <h2>Panel de administración</h2>

        <p>Bienvenida, <strong><?php echo htmlspecialchars($_SESSION["nombre"], ENT_QUOTES, "UTF-8"); ?></strong>.</p>
        <p>Tu rol: <strong><?php echo htmlspecialchars(rolActual(), ENT_QUOTES, "UTF-8"); ?></strong></p>

<?php require __DIR__ . "/app/views/layouts/footer.php"; ?>