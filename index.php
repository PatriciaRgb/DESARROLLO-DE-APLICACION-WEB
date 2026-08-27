<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 01 - PHP</title>
</head>
<body>

    <h1>Mi primera página web con PHP</h1>

    <?php

    $nombre = "Patricia Segura Resendiz";
    $edad = 22;
    $carrera = "Ingeniería en Sistemas Computacionales";

    $precio = 250.50;
    $cantidad = 3;
    $disponible = true;

    $total = $precio * $cantidad;

    echo "<h2>Datos del estudiante</h2>";
    echo "<p>Nombre: $nombre</p>";
    echo "<p>Edad: $edad años</p>";
    echo "<p>Carrera: $carrera</p>";

    echo "<h2>Tipos de datos</h2>";
    echo "<p>Precio: $$precio</p>";
    echo "<p>Cantidad: $cantidad</p>";
    echo "<p>Disponible: $disponible</p>";

    echo "<h2>Operación</h2>";
    echo "<p>Total: $$total</p>";

    ?>

</body>
</html>