<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$archivoConfig = __DIR__ . "/config.php";

if (!is_file($archivoConfig)) {
    error_log("Falta config.php: copia config.ejemplo.php y completa los datos.");
    http_response_code(500);
    exit("El sistema no está configurado correctamente.");
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
    http_response_code(500);
    exit("El sistema no está disponible en este momento. Intenta más tarde.");
}