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
require_once __DIR__ . "/../app/models/Resena.php";
require_once __DIR__ . "/../app/controllers/ResenaController.php";

$controlador = new ResenaController(new Resena($conexion));
[$codigo, $cuerpo] = $controlador->listarJson($_SESSION);

responderJson($codigo, $cuerpo);