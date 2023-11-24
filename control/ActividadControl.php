<?php
require_once __DIR__ . "/../modelo/Actividad.php";

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
}
