<?php
session_start();
require_once "conexion.php";

// Solo se acepta POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login_form.php");
    exit;
}

$usuario    = trim($_POST["usuario"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

if ($usuario === "" || $contrasena === "") {
    header("Location: login_form.php?m=campos");
    exit;
}

// Buscar al usuario con consulta preparada
try {
    $stmt = $conexion->prepare(
        "SELECT id, nombre, usuario, password_hash, activo
         FROM usuarios
         WHERE usuario = ?
         LIMIT 1"
    );
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log("Error en login: " . $e->getMessage());
    exit("No fue posible procesar el inicio de sesión en este momento.");
}

// Usuario existe, está activo y la contraseña coincide con el hash
if ($fila
    && (int)$fila["activo"] === 1
    && password_verify($contrasena, $fila["password_hash"])) {

    session_regenerate_id(true);

    $_SESSION["usuario_id"] = (int)$fila["id"];
    $_SESSION["nombre"]     = $fila["nombre"];
    $_SESSION["usuario"]    = $fila["usuario"];

    header("Location: panel.php");
    exit;
}

// Mensaje genérico: no revela si falló el usuario o la contraseña
header("Location: login_form.php?m=credenciales");
exit;