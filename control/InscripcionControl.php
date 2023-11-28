<?php
require_once __DIR__ . "/../modelo/Inscripcion.php";

class InscripcionControl
{
    public static function crearInscripcion(
        $legajo,
        $dni,
        $nombre,
        $apellido,
        $correoElectronico,
        $fecha,
        $arrModulos
    ) {
        // si no hay modolos a los que inscribirse no hace nada
        if (!$arrModulos) return false;
        
        // calcula el costo final
        $costoFinal = 0;
        foreach ($arrModulos as $modulo) {
            $costoFinal += $modulo->darCostoModulo();
        }
        
        // crea la inscripcion
        $inscripcion = new Inscripcion();
        $inscripcion->cargar(0, $fecha, $costoFinal, $legajo);
        $inscripcion->insertar();

        // crea un nuevo ingresante
        // el id de la inscripcion ya lo obtiene al haberlo ingresado
        $ingresante = new Ingresante();
        $ingresante->cargar(
            $legajo,
            $dni,
            $nombre,
            $apellido,
            $correoElectronico,
            $inscripcion->getId()
        );    
        
        $ingresante->insertar();
        $inscripcion->inscribirAModulos($arrModulos);

        return true;
    }

    public static function existeInscripcion($id)
    {
        $inscripcion = new Inscripcion();
        $resp = $inscripcion->buscar($id);
        return $resp;
    }

    public static function obtenerInscripcion($id)
    {
        $inscripcion = new Inscripcion();
        $resp = $inscripcion->buscar($id);
        if (!$resp) {
            throw new Exception("No existe inscripcion");
        }
        return $inscripcion;
    }

    public static function eliminarInscripcion($legajo)
    {
        $inscripcion = new Inscripcion();
        $inscripcion->cargar($legajo, "", "", "", "");
        $resp = $inscripcion->eliminar();
        return $resp;
    }

    public static function modificarInscripcion($id, $fecha, $costoFinal, $legajo)
    {
        $inscripcion = new Inscripcion();
        $inscripcion->cargar($id, $fecha, $costoFinal, $legajo);
        $resp = $inscripcion->modificar();
        return $resp;
    }

    public static function listarInscripciones()
    {
        return Inscripcion::listar();
    }
}
