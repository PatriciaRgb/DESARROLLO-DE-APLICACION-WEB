<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Árbol de Higos - Semana 01</title>
</head>
<body>
    <h1>El Árbol de Higos</h1>
    <?php
        $autor = "Sylvia Plath";       // string
        $libro = "The Bell Jar";       // string
        $precio = 250.50;              // float
        $cantidad = 2;                 // integer
        $disponible = true;            // boolean

        echo "<p>Autora: $autor</p>";
        echo "<p>Libro: $libro</p>";
        echo "<p>Precio: $precio</p>";
        echo "<p>Cantidad: $cantidad</p>";
        echo "<p>Disponible: " . ($disponible ? "Sí" : "No") . "</p>";
    ?>
</body>
</html>