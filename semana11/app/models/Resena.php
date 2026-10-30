<?php
// Modelo: se encarga solo del acceso a los datos de la tabla resenas.
// No imprime nada, no conoce la sesión ni el HTML.

class Resena
{
    private mysqli $conexion;

    public function __construct(mysqli $conexion)
    {
        $this->conexion = $conexion;
    }

    // De la más reciente a la más antigua (lista del administrador)
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

    // Ejecuta una consulta fija definida arriba y da forma a las filas.
    // Si MySQL falla lanza mysqli_sql_exception: el controlador decide qué responder.
    private function consultar(string $sql): array
    {
        $resultado = $this->conexion->query($sql);

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