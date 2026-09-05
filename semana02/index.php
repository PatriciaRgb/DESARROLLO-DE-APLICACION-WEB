<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>El Árbol de Higos - Reseñas</title>
</head>
<body>
    <h1>El Árbol de Higos</h1>
    <h2>Deja tu reseña (usando GET)</h2>

    <form action="procesar.php" method="GET">

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="correo">Correo electrónico:</label><br>
        <input type="email" id="correo" name="correo"><br><br>

        <label for="calificacion">Calificación (1-5):</label><br>
        <input type="number" id="calificacion" name="calificacion" min="1" max="5"><br><br>

        <label for="comentario">Tu reseña:</label><br>
        <textarea id="comentario" name="comentario" rows="4" cols="40"></textarea><br><br>

        <button type="submit">Enviar reseña (GET)</button>

    </form>

    <hr>

    <h2>Deja tu reseña (usando POST)</h2>

    <form action="procesar.php" method="POST">

        <label for="nombre2">Nombre:</label><br>
        <input type="text" id="nombre2" name="nombre"><br><br>

        <label for="correo2">Correo electrónico:</label><br>
        <input type="email" id="correo2" name="correo"><br><br>

        <label for="calificacion2">Calificación (1-5):</label><br>
        <input type="number" id="calificacion2" name="calificacion" min="1" max="5"><br><br>

        <label for="comentario2">Tu reseña:</label><br>
        <textarea id="comentario2" name="comentario" rows="4" cols="40"></textarea><br><br>

        <button type="submit">Enviar reseña (POST)</button>

    </form>

</body>
</html>