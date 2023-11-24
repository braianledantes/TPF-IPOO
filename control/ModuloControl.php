<?php
require_once __DIR__ . "/../modelo/Modulo.php";

class ModuloControl
{
    public static function crearModulo(
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre
    ) {
        $resp = false;
        $moduloNueva = new Modulo();
        $moduloNueva->cargar(
            0,
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre
        );
        try {
            $resp = $moduloNueva->insertar();
        } catch (Exception $e) {
        }
        return $resp;
    }

    public static function obtenerModulo($id)
    {
        $modulo = new Modulo();
        $resp = $modulo->buscar($id);
        if (!$resp) {
            throw new Exception("No existe activida");
        }
        return $modulo;
    }

    public static function eliminarModulo($id)
    {
        $modulo = new Modulo();
        $modulo->cargar($id, "", 0, "", 0.0, "00:00", "00:00");
        $resp = $modulo->eliminar();
        return $resp;
    }

    public static function modificarModulo(
        $id,
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre
    ) {
        $modulo = new Modulo();
        $modulo->cargar(
            $id,
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre
        );
        $resp = $modulo->modificar();
        return $resp;
    }

    public static function listarModuloes()
    {
        return Modulo::listar();
    }
}
