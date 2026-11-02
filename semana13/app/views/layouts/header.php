<?php
// Encabezado general. La página que lo incluye define $tituloPagina antes.
// Debe incluirse ANTES de enviar cualquier contenido, porque inicia la sesión.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . "/mensajes.php";

$tituloPagina = $tituloPagina ?? "Inicio";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina, ENT_QUOTES, "UTF-8"); ?> - El Árbol de Higos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div id="principal">

        <h1>El Árbol de Higos</h1>

        <?php require __DIR__ . "/menu.php"; ?>