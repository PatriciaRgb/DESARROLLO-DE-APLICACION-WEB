<?php
require_once "proteger.php";

const ROLES_VALIDOS = ["administrador", "consulta"];

// Devuelve el rol de la sesión, o "" si no existe o no es uno de los valores conocidos
function rolActual(): string
{
    $rol = $_SESSION["rol"] ?? "";
    return in_array($rol, ROLES_VALIDOS, true) ? $rol : "";
}

// Dice si el usuario actual tiene alguno de los roles indicados
function tieneRol(array $rolesPermitidos): bool
{
    $rol = rolActual();
    return $rol !== "" && in_array($rol, $rolesPermitidos, true);
}

// Corta la ejecución con un 403 si el usuario no tiene permiso
function exigirRol(array $rolesPermitidos): void
{
    if (tieneRol($rolesPermitidos)) {
        return;
    }

    http_response_code(403);
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">'
       . '<title>Acceso denegado</title>'
       . '<link rel="stylesheet" href="estilos.css"></head><body>'
       . '<div id="principal"><h1>El Árbol de Higos</h1><h2>Acceso denegado</h2>'
       . '<div class="mensaje-error">No tienes permiso para realizar esta operación.</div>'
       . '<p><a href="panel.php">Volver al panel</a></p></div></body></html>';
    exit;
}