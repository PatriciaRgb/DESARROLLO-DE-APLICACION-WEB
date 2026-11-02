<?php
session_start();

// Si ya hay sesión, no tiene sentido mostrar el login
if (isset($_SESSION["usuario_id"])) {
    header("Location: panel.php");
    exit;
}

// Avisos permitidos (lista cerrada: nunca se imprime lo que venga en la URL)
$mensajes = [
    "campos"       => ["mensaje-error", "Escribe tu usuario y contraseña."],
    "credenciales" => ["mensaje-error", "No fue posible iniciar sesión con esas credenciales."],
    "protegida"    => ["mensaje-error", "Debes iniciar sesión para entrar a esa página."],
    "cerrada"      => ["mensaje-exito", "Cerraste sesión correctamente."]
];

$aviso = null;
if (isset($_GET["m"]) && array_key_exists($_GET["m"], $mensajes)) {
    $aviso = $mensajes[$_GET["m"]];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>
        <h2>Iniciar sesión</h2>

        <?php if ($aviso !== null) { ?>
            <div class="<?php echo $aviso[0]; ?>"><?php echo $aviso[1]; ?></div>
        <?php } ?>

        <form action="login.php" method="POST" autocomplete="off">

            <label for="usuario">Usuario</label>
            <input id="usuario" name="usuario" type="text" required>

            <label for="contrasena">Contraseña</label>
            <input id="contrasena" name="contrasena" type="password" required>

            <button type="submit">Iniciar sesión</button>
        </form>

        <p><a href="index.php">Volver al inicio</a></p>

    </div>
</body>
</html>