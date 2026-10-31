<?php
// Controlador: coordina la solicitud. Pide los datos al modelo y decide
// qué responder, incluso cuando algo falla. No escribe SQL ni HTML.

class ResenaController
{
    private Resena $modelo;

    public function __construct(Resena $modelo)
    {
        $this->modelo = $modelo;
    }

    // Para el endpoint JSON. Devuelve [código HTTP, cuerpo de la respuesta].
    // La sesión y el rol ya se comprobaron en el punto de entrada.
    public function listarJson(array $sesion): array
    {
        try {
            $datos = $this->modelo->obtenerTodas();
        } catch (mysqli_sql_exception $e) {
            error_log("Reseñas (JSON): " . $e->getMessage());
            return [500, ["ok" => false, "mensaje" => "No fue posible consultar las reseñas."]];
        }

        return [200, [
            "ok"               => true,
            "puedeAdministrar" => ($sesion["rol"] ?? "") === "administrador",
            "total"            => count($datos),
            "datos"            => $datos
        ]];
    }

    // Para la página pública. Devuelve los datos que necesita la vista.
    public function listarPublicas(): array
    {
        try {
            return ["resenas" => $this->modelo->obtenerPorCalificacion(), "error" => false];
        } catch (mysqli_sql_exception $e) {
            error_log("Reseñas (públicas): " . $e->getMessage());
            return ["resenas" => [], "error" => true];
        }
    }
}