<?php
// Pie general. Cierra lo que abrió header.php.
// La página puede definir $scripts: archivos .js escritos en el código, nunca tomados de la URL.
$scripts = $scripts ?? [];
?>

        <footer class="pie">
            El Árbol de Higos · Proyecto integrador de Desarrollo de Aplicaciones Web
        </footer>

    </div>

    <?php foreach ($scripts as $script) { ?>
        <script src="<?php echo htmlspecialchars($script, ENT_QUOTES, "UTF-8"); ?>"></script>
    <?php } ?>
</body>
</html>