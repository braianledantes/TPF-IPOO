<?php
require_once __DIR__ . "/../modelo/ModuloEnLinea.php";

class ModuloEnLineaControl
{
    public static function crearModuloEnLinea(
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre,
        $link,
        $bonificacion
    ) {
        $resp = false;
        try {
            $moduloEnlineaNuevo = new ModuloEnLinea();
            $moduloEnlineaNuevo->cargarr(
                0,
                $idActividad,
                $descripcion,
                $topeInscripciones,
                $costo,
                $horarioInicio,
                $horarioCierre,
                $link,
                $bonificacion
            );
            $resp = $moduloEnlineaNuevo->insertar();
        } catch (Exception $e) {
        }
        return $resp;
    }

    public static function obtenerModuloEnLinea($id)
    {
        $moduloenlinea = new ModuloEnLinea();
        $resp = $moduloenlinea->buscar($id);
        if (!$resp) {
            throw new Exception("No existe activida");
        }
        return $moduloenlinea;
    }

    public static function eliminarModuloEnLinea($id)
    {
        $moduloenlinea = new ModuloEnLinea();
        $moduloenlinea->cargarr($id, "", 0, "", 0.0, "00:00", "00:00", "", 0);
        $resp = $moduloenlinea->eliminar();
        return $resp;
    }

    public static function modificarModuloEnLinea(
        $id,
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre,
        $link,
        $bonificacion
    ) {
        $moduloenlinea = new ModuloEnLinea();
        $moduloenlinea->cargarr(
            $id,
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre,
            $link,
            $bonificacion
        );
        $resp = $moduloenlinea->modificar();
        return $resp;
    }

    public static function listarModuloEnLineas()
    {
        return ModuloEnLinea::listar();
    }
}
