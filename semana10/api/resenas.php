<?php
// Endpoint JSON: lista las reseñas. Solo lectura (GET).

// Un aviso de PHP impreso en pantalla rompería el JSON
ini_set("display_errors", "0");

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

define("RESPUESTA_JSON", true);   // conexion.php responderá en JSON si falla

require_once __DIR__ . "/../autorizacion_json.php";   // 401 si no hay sesión

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("Allow: GET");
    responderJson(405, ["ok" => false, "mensaje" => "Método no permitido."]);
}

exigirRolJson(["administrador", "consulta"]);          // 403 si el rol no sirve

require_once __DIR__ . "/../conexion.php";

try {
    $resultado = $conexion->query(
        "SELECT id, nombre, libro, calificacion, comentario, fecha
         FROM resenas
         ORDER BY id DESC"
    );

    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = [
            "id"           => (int)$fila["id"],
            "nombre"       => $fila["nombre"],
            "libro"        => $fila["libro"],
            "calificacion" => (int)$fila["calificacion"],
            "comentario"   => $fila["comentario"],
            "fecha"        => $fila["fecha"]
        ];
    }
} catch (mysqli_sql_exception $e) {
    error_log("API reseñas: " . $e->getMessage());
    responderJson(500, ["ok" => false, "mensaje" => "No fue posible consultar las reseñas."]);
}

responderJson(200, [
    "ok"               => true,
    "puedeAdministrar" => ($_SESSION["rol"] ?? "") === "administrador",
    "total"            => count($datos),
    "datos"            => $datos
]);