<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Responde al fallo según quién pidió la página:
// un endpoint JSON recibe JSON; una página normal recibe texto.
function terminarPorError(string $mensaje): void
{
    http_response_code(500);

    if (defined("RESPUESTA_JSON")) {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["ok" => false, "mensaje" => $mensaje], JSON_UNESCAPED_UNICODE);
    } else {
        echo $mensaje;
    }
    exit;
}

$archivoConfig = __DIR__ . "/config.php";

if (!is_file($archivoConfig)) {
    error_log("Falta config.php: copia config.ejemplo.php y completa los datos.");
    terminarPorError("El sistema no está configurado correctamente.");
}

$config = require $archivoConfig;

try {
    $conexion = new mysqli(
        $config["host"],
        $config["usuario"],
        $config["password"],
        $config["base"]
    );
    $conexion->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // El detalle técnico va al registro, no a la pantalla
    error_log("Error de conexión a MySQL: " . $e->getMessage());
    terminarPorError("El sistema no está disponible en este momento. Intenta más tarde.");
}