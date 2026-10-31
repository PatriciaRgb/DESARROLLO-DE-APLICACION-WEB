<?php
require_once "autorizacion.php";
$esAdmin = tieneRol(["administrador"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Panel de administración</h2>

        <p>Bienvenida, <strong><?php echo htmlspecialchars($_SESSION["nombre"], ENT_QUOTES, "UTF-8"); ?></strong>.</p>
        <p>Tu rol: <strong><?php echo htmlspecialchars(rolActual(), ENT_QUOTES, "UTF-8"); ?></strong></p>

        <nav class="menu">
            <?php if ($esAdmin) { ?>
                <a href="crear.php">Nueva reseña</a>
                <a href="listar.php">Administrar reseñas</a>
            <?php } else { ?>
                <a href="listar.php">Consultar reseñas</a>
            <?php } ?>
            <a href="logout.php">Cerrar sesión</a>
        </nav>

    </div>
</body>
</html>