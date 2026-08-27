<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saurely - Tienda de belleza</title>
</head>
<body>

    <header>
        <h1>Saurely</h1>
        <p>Tu espacio de belleza y cuidado de la piel</p>
    </header>

    <main>

        <section>
            <h2>Producto destacado</h2>

            <?php

            $producto = "Limpiador facial";
            $precio = 250.50;
            $cantidad = 3;

            echo "<p><strong>Producto:</strong> $producto</p>";
            echo "<p><strong>Precio:</strong> $$precio</p>";
            echo "<p><strong>Cantidad:</strong> $cantidad</p>";

            ?>
        </section>

        <section>
            <h2>Compra</h2>

            <?php

            $total = $precio * $cantidad;

            echo "<p><strong>Total de la compra:</strong> $$total</p>";

            ?>
        </section>

        <section>
            <h2>Mensaje</h2>

            <?php

            echo "<p>En Saurely puedes encontrar productos para el cuidado de tu piel.</p>";

            ?>

        </section>

    </main>

</body>
</html>