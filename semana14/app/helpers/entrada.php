<?php
// Lectura segura de datos recibidos: si llega algo que no es texto
// (por ejemplo nombre[]=x), se trata como vacío en lugar de provocar un error.

// Lee un dato de cualquier arreglo (por ejemplo $_GET o $_POST)
function textoDato(array $datos, string $clave): string
{
    $valor = $datos[$clave] ?? "";
    return is_string($valor) ? trim($valor) : "";
}

function textoPost(string $clave): string
{
    return textoDato($_POST, $clave);
}