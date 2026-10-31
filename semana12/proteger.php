<?php
session_start();

// Evita que el navegador guarde copias de páginas internas
header("Cache-Control: no-store, no-cache, must-revalidate");

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login_form.php?m=protegida");
    exit;
}