<?php
// Modelo: se encarga solo del acceso a los datos de la tabla resenas.
// No imprime nada, no conoce la sesión ni el HTML.

class Resena
{
    // Lista permitida: lo que llega del usuario se usa SOLO para elegir una clave de aquí.
    // El nombre de la columna que va al SQL es el valor, escrito por mí.
    private const COLUMNAS_ORDEN = [
        "id"           => "id",
        "nombre"       => "nombre",
        "libro"        => "libro",
        "calificacion" => "calificacion",
        "fecha"        => "fecha"
    ];

    private const DIRECCIONES = [
        "asc"  => "ASC",
        "desc" => "DESC"
    ];

    private mysqli $conexion;

    public function __construct(mysqli $conexion)
    {
        $this->conexion = $conexion;
    }

    public static function ordenesPermitidos(): array
    {
        return array_keys(self::COLUMNAS_ORDEN);
    }

    public static function direccionesPermitidas(): array
    {
        return array_keys(self::DIRECCIONES);
    }

    // De la más reciente a la más antigua
    public function obtenerTodas(): array
    {
        return $this->consultar(
            "SELECT id, nombre, libro, calificacion, comentario, fecha
             FROM resenas
             ORDER BY id DESC"
        );
    }

    // De la mejor calificada a la peor (página pública)
    public function obtenerPorCalificacion(): array
    {
        return $this->consultar(
            "SELECT id, nombre, libro, calificacion, comentario, fecha
             FROM resenas
             ORDER BY calificacion DESC, id DESC"
        );
    }

    // Búsqueda y orden. Aunque el controlador ya valida, aquí se vuelve a comprobar:
    // el modelo no confía en quien lo llame.
    public function buscar(string $texto, string $orden, string $direccion): array
    {
        if (!isset(self::COLUMNAS_ORDEN[$orden]) || !isset(self::DIRECCIONES[$direccion])) {
            throw new InvalidArgumentException("Criterio de orden no permitido.");
        }

        $columna = self::COLUMNAS_ORDEN[$orden];
        $sentido = self::DIRECCIONES[$direccion];

        $sql = "SELECT id, nombre, libro, calificacion, comentario, fecha FROM resenas";

        if ($texto !== "") {
            $sql .= " WHERE (nombre LIKE ? OR libro LIKE ? OR comentario LIKE ?)";
        }

        // $columna y $sentido salen de las listas de arriba, nunca de la petición
        $sql .= " ORDER BY " . $columna . " " . $sentido . ", id DESC";

        $stmt = $this->conexion->prepare($sql);

        if ($texto !== "") {
            // Se escapan \ % _ para buscarlos literalmente (el escape por defecto de LIKE es \)
            $patron = "%" . addcslashes($texto, "\\%_") . "%";
            $stmt->bind_param("sss", $patron, $patron, $patron);
        }

        $stmt->execute();
        $resenas = $this->darForma($stmt->get_result());
        $stmt->close();

        return $resenas;
    }

    // Consulta fija definida arriba (sin datos del usuario)
    private function consultar(string $sql): array
    {
        return $this->darForma($this->conexion->query($sql));
    }

    private function darForma(mysqli_result $resultado): array
    {
        $resenas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $resenas[] = [
                "id"           => (int)$fila["id"],
                "nombre"       => $fila["nombre"],
                "libro"        => $fila["libro"],
                "calificacion" => (int)$fila["calificacion"],
                "comentario"   => $fila["comentario"],
                "fecha"        => $fila["fecha"]
            ];
        }
        return $resenas;
    }
}