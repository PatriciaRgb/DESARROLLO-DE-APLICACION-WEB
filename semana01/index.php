<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Árbol de Higos - Semana 01</title>
</head>
<body>
    <h1>El Árbol de Higos</h1>
    <p>Una pequeña librería para quienes aman leer, pensar y explorar.</p>

    <h2>Libro destacado</h2>
    <?php
        $autor = "Sylvia Plath";       // string
        $libro = "The Bell Jar";       // string
        $precio = 250.50;              // float
        $cantidad = 2;                 // integer
        $disponible = true;            // boolean
        $total = $precio * $cantidad;  // operación aritmética

        echo "<p><strong>Autora:</strong> $autor</p>";
        echo "<p><strong>Libro:</strong> $libro</p>";
        echo "<p><strong>Precio:</strong> $precio</p>";
        echo "<p><strong>Cantidad:</strong> $cantidad</p>";
        echo "<p><strong>Disponible:</strong> " . ($disponible ? "Sí" : "No") . "</p>";
        echo "<p><strong>Total:</strong> $total</p>";
    ?>
</body>
</html>