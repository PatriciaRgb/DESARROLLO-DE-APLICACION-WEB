<?php
require_once "conexion.php";

// 1) Solo se acepta POST. Si alguien abre esta dirección directamente (GET),
//    no se borra nada: se le regresa a la lista.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit;
}

// 2) Validar el id recibido
$id = filter_var($_POST["id"] ?? "", FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

if ($id === false) {
    header("Location: listar.php?mensaje=noexiste");
    exit;
}

// 3) Eliminar con consulta preparada, solo el registro con ese id
try {
    $stmt = $conexion->prepare("DELETE FROM resenas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $filasAfectadas = (int)$stmt->affected_rows;
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log("Error al eliminar reseña: " . $e->getMessage());
    exit("No fue posible eliminar la reseña en este momento.");
}

// 4) affected_rows dice cuántos registros se borraron de verdad
if ($filasAfectadas === 1) {
    header("Location: listar.php?mensaje=eliminado");
} else {
    header("Location: listar.php?mensaje=noexiste");
}
exit;