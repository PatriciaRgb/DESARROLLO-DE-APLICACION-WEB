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

    // Todas las reseñas, de la más reciente a la más antigua.
    // Si MySQL falla lanza mysqli_sql_exception: el controlador decide qué responder.
    public function obtenerTodas(): array
    {
        $resultado = $this->conexion->query(
            "SELECT id, nombre, libro, calificacion, comentario, fecha
             FROM resenas
             ORDER BY id DESC"
        );

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