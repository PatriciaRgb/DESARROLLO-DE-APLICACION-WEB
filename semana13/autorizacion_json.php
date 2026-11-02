<?php
// Comprobaciones de sesión y rol para endpoints JSON.
// A diferencia de proteger.php y autorizacion.php, NO redirigen ni imprimen HTML:
// responden con JSON y el código HTTP que corresponde.

function responderJson(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 401: no se identificó
if (!isset($_SESSION["usuario_id"])) {
    responderJson(401, ["ok" => false, "mensaje" => "Debes iniciar sesión."]);
}

// 403: está identificado, pero su rol no tiene permiso
function exigirRolJson(array $rolesPermitidos): void
{
    $rol = $_SESSION["rol"] ?? "";

    if ($rol === "" || !in_array($rol, $rolesPermitidos, true)) {
        responderJson(403, ["ok" => false, "mensaje" => "No tienes permiso para esta operación."]);
    }
}