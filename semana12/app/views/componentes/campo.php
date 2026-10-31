<?php
// Componente de campos de formulario: etiqueta + campo + valor siempre escapado.
// Solo acepta los tipos permitidos y no recibe HTML.

const TIPOS_CAMPO = ["text", "email", "number"];

function escaparHtml(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
}

// Campo de una línea. El nombre del campo coincide con su id.
function campoFormulario(
    string $id,
    string $etiqueta,
    string $valor,
    string $tipo = "text",
    ?int $min = null,
    ?int $max = null
): void {
    if (!in_array($tipo, TIPOS_CAMPO, true)) {
        $tipo = "text";
    }

    $limites = "";
    if ($tipo === "number") {
        if ($min !== null) {
            $limites .= ' min="' . $min . '"';
        }
        if ($max !== null) {
            $limites .= ' max="' . $max . '"';
        }
    }

    echo '<label for="' . escaparHtml($id) . '">' . escaparHtml($etiqueta) . '</label>';
    echo '<input type="' . $tipo . '" id="' . escaparHtml($id) . '" name="' . escaparHtml($id)
       . '" value="' . escaparHtml($valor) . '"' . $limites . '>';
}

// Campo de varias líneas
function campoAreaTexto(string $id, string $etiqueta, string $valor, int $filas = 4): void
{
    echo '<label for="' . escaparHtml($id) . '">' . escaparHtml($etiqueta) . '</label>';
    echo '<textarea id="' . escaparHtml($id) . '" name="' . escaparHtml($id)
       . '" rows="' . $filas . '">' . escaparHtml($valor) . '</textarea>';
}