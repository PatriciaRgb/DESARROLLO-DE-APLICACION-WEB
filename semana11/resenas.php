<?php
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/app/models/Resena.php";
require_once __DIR__ . "/app/controllers/ResenaController.php";

$controlador = new ResenaController(new Resena($conexion));
$datos = $controlador->listarPublicas();

$resenas       = $datos["resenas"];
$errorConsulta = $datos["error"];

require __DIR__ . "/app/views/resenas/publicas.php";