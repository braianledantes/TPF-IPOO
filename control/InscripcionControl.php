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
        $inscripcion->cargar(0, $fecha, $costoFinal);
        $inscripcion->setModulos($arrModulos);
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

    public static function eliminarInscripcion($id)
    {
        $inscripcion = new Inscripcion();
        $inscripcion->cargar($id, "", "");
        $resp = $inscripcion->eliminar();
        return $resp;
    }

    public static function modificarInscripcion($id, $fecha, $arrModulos) {
        // si no hay modolos a los que inscribirse no hace nada
        if (!$arrModulos) return false;
        
        // calcula el costo final
        $costoFinal = 0;
        foreach ($arrModulos as $modulo) {
            $costoFinal += $modulo->darCostoModulo();
        }
        
        // modifica la inscripcion y la relacion
        $inscripcion = new Inscripcion();
        $inscripcion->cargar($id, $fecha, $costoFinal);
        $inscripcion->setModulos($arrModulos);
        return $inscripcion->modificar();
    }

    public static function listarInscripciones()
    {
        return Inscripcion::listar();
    }

    public static function listarInscripcionesDeModulo($idModulo)
    {
        return Inscripcion::listarInscripcionesDeModulo($idModulo);
    }

    public static function listarInscripcionesDeActividad($idActividad)
    {
        return Inscripcion::listarInscripcionesDeActividad($idActividad);
    }
}
