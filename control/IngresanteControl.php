<?php
require_once __DIR__ . "/../modelo/Ingresante.php";

class IngresanteControl
{
    public static function crearIngresante(
        $legajo,
        $dni,
        $nombre,
        $apellido,
        $correoElectronico,
        $idInscripcion
    ) {
        $ingresanteNuevo = new Ingresante();
        $ingresanteNuevo->cargar(
            $legajo,
            $dni,
            $nombre,
            $apellido,
            $correoElectronico,
            $idInscripcion
        );
        $resp = $ingresanteNuevo->insertar();
        return $resp;
    }

    public static function existeIngresante($id)
    {
        $ingresante = new Ingresante();
        $resp = $ingresante->buscar($id);
        return $resp;
    }

    public static function obtenerIngresante($id)
    {
        $ingresante = new Ingresante();
        $resp = $ingresante->buscar($id);
        if (!$resp) {
            throw new Exception("No existe ingresante");
        }
        return $ingresante;
    }

    public static function eliminarIngresante($legajo)
    {
        $ingresante = new Ingresante();
        $ingresante->cargar($legajo, "", "", "", "", 0);
        $resp = $ingresante->eliminar();
        return $resp;
    }

    public static function modificarIngresante(
        $legajo,
        $dni,
        $nombre,
        $apellido,
        $correoElectronico
    ) {
        $ingresante = new Ingresante();
        $ingresante->cargar(
            $legajo,
            $dni,
            $nombre,
            $apellido,
            $correoElectronico,
            0
        );
        $resp = $ingresante->modificar();
        return $resp;
    }

    public static function listarIngresantes()
    {
        return Ingresante::listar();
    }
}
