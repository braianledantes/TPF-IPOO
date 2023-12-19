<?php
require_once __DIR__ . "/../modelo/Ingresante.php";
require_once __DIR__ . "/../modelo/Modulo.php";
require_once __DIR__ . "/../modelo/Inscripcion.php";

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

    // Buscar dado un módulo todos aquellos registros que poseen el mismo DNI y aparecen mas de una vez
    public static function listarIngresantesDeModuloConMismoDni($idModulo)
    {
        $ingresantes = array();

        $modulo = new Modulo();
        if ($modulo->buscar($idModulo)) {
            $dniIngresantes = array();
            $listaIngresantes = Ingresante::listar();

            // se obtienen los dni de los ingresantes del modulo
            foreach ($listaIngresantes as $ingresante) {
                if (in_array($ingresante->getInscripcion(), $modulo->getInscripciones())) {
                    array_push($dniIngresantes, $ingresante->getDni());
                }
            }

            // cuenta los valores
            $dniIngresantes = array_count_values($dniIngresantes);

            // obtiene los ingresantes que esten mas de una vez
            foreach ($dniIngresantes as $dni => $cant) {
                if ($cant > 1) {
                    $ingresante = new Ingresante();
                    if ($ingresante->buscarPorDni($dni)) {
                        array_push($ingresantes, $ingresante);
                    }
                }
            }
        }

        return $ingresantes;
    }
}
