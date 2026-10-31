<?php
// Menú general: cambia según la sesión y el rol.
// OJO: el menú es solo comodidad. La autorización real se comprueba en cada página.

$hayUsuarioMenu = isset($_SESSION["usuario_id"]);
$rolMenu        = $_SESSION["rol"] ?? "";
$esAdminMenu    = $hayUsuarioMenu && $rolMenu === "administrador";
$esConsultaMenu = $hayUsuarioMenu && $rolMenu === "consulta";
?>
<nav class="menu">
    <?php if ($hayUsuarioMenu) { ?>
        <a href="panel.php">Panel</a>
        <?php if ($esAdminMenu) { ?>
            <a href="crear.php">Nueva reseña</a>
            <a href="listar.php">Administrar reseñas</a>
        <?php } elseif ($esConsultaMenu) { ?>
            <a href="listar.php">Consultar reseñas</a>
        <?php } ?>
        <a href="resenas.php">Reseñas públicas</a>
        <a href="logout.php">Cerrar sesión</a>
    <?php } else { ?>
        <a href="index.php">Inicio</a>
        <a href="resenas.php">Reseñas públicas</a>
        <a href="login_form.php">Acceso administrador</a>
    <?php } ?>
</nav>