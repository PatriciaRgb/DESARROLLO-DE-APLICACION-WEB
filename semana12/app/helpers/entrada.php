<?php
// Lectura segura de datos recibidos: si llega algo que no es texto
// (por ejemplo nombre[]=x), se trata como vacío en lugar de provocar un error.

function textoPost(string $clave): string
{
    $valor = $_POST[$clave] ?? "";
    return is_string($valor) ? trim($valor) : "";
}