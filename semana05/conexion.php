<?php
    $conexion = new mysqli(
        "localhost",
        "root",
        "",
        "arbol_de_higos"
    );

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
?>