<?php
session_start();

// 1) Vaciar los datos de la sesión
$_SESSION = [];

// 2) Borrar la cookie de sesión del navegador
if (ini_get("session.use_cookies")) {
    $parametros = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $parametros["path"],
        $parametros["domain"],
        $parametros["secure"],
        $parametros["httponly"]
    );
}

// 3) Destruir la sesión en el servidor
session_destroy();

header("Location: login_form.php?m=cerrada");
exit;