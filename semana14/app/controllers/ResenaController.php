<?php
// Controlador: coordina la solicitud. Valida los parámetros, pide los datos al modelo
// y decide qué responder, incluso cuando algo falla. No escribe SQL ni HTML.

class ResenaController
{
    private const LONGITUD_MAXIMA_BUSQUEDA = 50;

    private Resena $modelo;

    public function __construct(Resena $modelo)
    {
        $this->modelo = $modelo;
    }

    // Para el endpoint JSON. Devuelve [código HTTP, cuerpo de la respuesta].
    // La sesión y el rol ya se comprobaron en el punto de entrada.
    // $consulta son los parámetros de la URL (q, orden, dir).
    public function listarJson(array $sesion, array $consulta = []): array
    {
        $q     = $consulta["q"]     ?? "";
        $orden = $consulta["orden"] ?? "id";
        $dir   = $consulta["dir"]   ?? "desc";

        // Un parámetro repetido (q[]=x) llega como arreglo: no es texto, se rechaza
        if (!is_string($q) || !is_string($orden) || !is_string($dir)) {
            return $this->rechazo("Los parámetros de consulta no son válidos.");
        }

        $q = trim($q);

        if (!mb_check_encoding($q, "UTF-8")) {
            return $this->rechazo("La búsqueda contiene caracteres no válidos.");
        }

        if (mb_strlen($q) > self::LONGITUD_MAXIMA_BUSQUEDA) {
            return $this->rechazo("La búsqueda no puede tener más de " . self::LONGITUD_MAXIMA_BUSQUEDA . " caracteres.");
        }

        if (!in_array($orden, Resena::ordenesPermitidos(), true)) {
            return $this->rechazo("El criterio de orden no es válido.");
        }

        if (!in_array($dir, Resena::direccionesPermitidas(), true)) {
            return $this->rechazo("La dirección del orden no es válida.");
        }

        try {
            $datos = $this->modelo->buscar($q, $orden, $dir);
        } catch (mysqli_sql_exception | InvalidArgumentException $e) {
            error_log("Reseñas (JSON): " . $e->getMessage());
            return [500, ["ok" => false, "mensaje" => "No fue posible consultar las reseñas."]];
        }

        return [200, [
            "ok"               => true,
            "puedeAdministrar" => ($sesion["rol"] ?? "") === "administrador",
            "total"            => count($datos),
            "filtros"          => ["q" => $q, "orden" => $orden, "dir" => $dir],
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

    private function rechazo(string $mensaje): array
    {
        return [400, ["ok" => false, "mensaje" => $mensaje]];
    }
}