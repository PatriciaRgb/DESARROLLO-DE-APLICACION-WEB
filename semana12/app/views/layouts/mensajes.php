<?php
// Componente de mensajes: solo tipos permitidos y salida siempre escapada.

const TIPOS_MENSAJE = [
    "exito"       => "mensaje-exito",
    "error"       => "mensaje-error",
    "advertencia" => "mensaje-advertencia"
];

// Muestra un aviso. Un tipo desconocido se trata como error y nunca se imprime tal cual.
function mostrarMensaje(string $tipo, string $texto): void
{
    $clase = TIPOS_MENSAJE[$tipo] ?? TIPOS_MENSAJE["error"];
    $rol   = ($clase === TIPOS_MENSAJE["error"]) ? "alert" : "status";

    echo '<div class="' . $clase . '" role="' . $rol . '">'
       . htmlspecialchars($texto, ENT_QUOTES, "UTF-8")
       . '</div>';
}

// Muestra una lista de errores de validación (textos escritos en el código).
function mostrarErrores(array $errores): void
{
    if (count($errores) === 0) {
        return;
    }

    echo '<div class="mensaje-error" role="alert"><ul>';
    foreach ($errores as $error) {
        echo '<li>' . htmlspecialchars((string)$error, ENT_QUOTES, "UTF-8") . '</li>';
    }
    echo '</ul></div>';
}