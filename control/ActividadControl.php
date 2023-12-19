<?php
require_once __DIR__ . "/../modelo/Actividad.php";
require_once __DIR__ . "/../modelo/Ingresante.php";
require_once __DIR__ . "/../modelo/Modulo.php";

class ActividadControl
{
    public static function crearActividad($descripcionCorta, $descripcionLarga)
    {
        $actividadNueva = new Actividad();
        $actividadNueva->cargar(0, $descripcionCorta, $descripcionLarga);
        $resp = $actividadNueva->insertar();
        return $resp;
    }

    public static function existeActividad($id)
    {
        $actividad = new Actividad();
        $resp = $actividad->buscar($id);
        return $resp;
    }

    public static function obtenerActividad($id)
    {
        $actividad = new Actividad();
        $resp = $actividad->buscar($id);
        if (!$resp) {
            throw new Exception("No existe activida");
        }
        return $actividad;
    }

    public static function eliminarActividad($id)
    {
        $actividad = new Actividad();
        $actividad->cargar($id, "", "");
        $resp = $actividad->eliminar();
        return $resp;
    }

    public static function modificarActividad($id, $descripcionCorta, $descripcionLarga)
    {
        $actividad = new Actividad();
        $actividad->cargar($id, $descripcionCorta, $descripcionLarga);
        $resp = $actividad->modificar();
        return $resp;
    }

    public static function listarActividades()
    {
        return Actividad::listar();
    }

    public static function listarActividadesDeIngresante($legajo)
    {
        $actividades = array();
        $ingresante = new Ingresante();

        if ($ingresante->buscar($legajo)) {

            $modulos = Modulo::listar();
            foreach ($modulos as $modulo) {
                $actividad = new Actividad();
                if (
                    in_array($ingresante->getInscripcion(), $modulo->getInscripciones()) &&
                    $actividad->buscar($modulo->getIdActividad())
                ) {
                    array_push($actividades, $actividad);
                }
            }
        }

        return array_unique($actividades);
    }
}
