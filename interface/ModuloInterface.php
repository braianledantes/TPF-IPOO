<?php
include_once __DIR__ . '/../control/ModuloControl.php';
include_once __DIR__ . '/../control/ActividadControl.php';

class ModuloInterface
{
    public function menuModulo()
    {
        do {
            echo "+- MENÚ DE MÓDULOS -------------+\n";
            echo "| 1. Ingresar un modulo         |\n";
            echo "| 2. Modificar un modulo        |\n";
            echo "| 3. Eliminar un modulo         |\n";
            echo "| 4. Listar todos los modulos   |\n";
            echo "| 0. Salir                      |\n";
            echo "| Ingrese una opción:           |\n";
            echo "+-------------------------------+\n";
            $opcion = intval(trim(fgets(STDIN)));

            switch ($opcion) {
                case 1:
                    $this->crearModulo();
                    break;
                case 2:
                    $this->modificarModulo();
                    break;
                case 3:
                    $this->eliminarModulo();
                    break;
                case 4:
                    $this->listarModulos();
                    break;
                case 0:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción inválida. Intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 0);
    }

    private function crearModulo()
    {
        echo "+- Crear Módulo ---------------------\n";

        do {
            echo "| Ingrese el id de la actividad que pertenece: ";
            $idActividad = trim(fgets(STDIN));
            $existeActividad = ActividadControl::existeActividad($idActividad);
            if (!$existeActividad) {
                echo "No existe actividad con id $idActividad\n";
            }
        } while (!$existeActividad);

        echo "| Ingrese la descripción: ";
        $descripcion = trim(fgets(STDIN));
        echo "| Ingrese el tope de inscripciones: ";
        $topeInscripciones = trim(fgets(STDIN));
        echo "| Ingrese el costo: ";
        $costo = trim(fgets(STDIN));
        echo "| Ingrese el horario de inicio (ej: 16:00): ";
        $horarioInicio = trim(fgets(STDIN));
        echo "| Ingrese el horario de cierre (ej: 18:00): ";
        $horarioCierre = trim(fgets(STDIN));

        if (ModuloControl::crearModulo(
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre
        )) {
            echo "| Módulo creado correctamente.\n";
        } else {
            echo "\n\n";
            echo "+/////////////////////////////+\n";
            echo "// Error al crear la módulo. //\n";
            echo "+/////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+---------------------------------------\n";
    }

    private function eliminarModulo()
    {
        echo "+- Eliminar Módulo ------------------\n";
        echo "| Ingrese la identificación de la módulo: ";
        $id = trim(fgets(STDIN));

        if (ModuloControl::eliminarModulo($id)) {
            echo "| Módulo $id eliminada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+/////////////////////////////////+\n";
            echo "// Error al eliminar módulo $id. //\n";
            echo "+/////////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+---------------------------------------\n";
    }

    private function modificarModulo()
    {
        echo "+- Modificar Módulo -----------------\n";
        echo "| Ingrese la identificación de la módulo: ";
        $id = trim(fgets(STDIN));

        $modulo = ModuloControl::obtenerModulo($id);
        $idActividad = $modulo->getIdActividad();
        $descripcion = $modulo->getDescripcion();
        $topeInscripciones = $modulo->getTopeInscripciones();
        $costo = $modulo->getCosto();
        $horarioInicio = $modulo->getHorarioInicio();
        $horarioCierre = $modulo->getHorarioCierre();

        echo $modulo->__toString();

        echo "| Ingrese el id de la actividad (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $idActividad = $input;

        echo "| Ingrese una descripción (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $descripcion = $input;

        echo "| Ingrese el tope de inscripciones (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $topeInscripciones = $input;

        echo "| Ingrese el costo (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $costo = $input;

        echo "| Ingrese el horario de inicio (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $horarioInicio = $input;

        echo "| Ingrese el horario de cierre (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $horarioCierre = $input;

        if (ModuloControl::modificarModulo(
            $id,
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre
        )) {
            echo "| Módulo modificado correctamente.\n";
        } else {
            echo "\n\n";
            echo "+/////////////////////////////////+\n";
            echo "// Error al modificar el módulo. //\n";
            echo "+/////////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+---------------------------------------\n";
    }

    private function listarModulos()
    {
        echo "+- Listar Módulos ------------------\n";

        $moduloes = ModuloControl::listarModuloes();
        if (empty($moduloes)) {
            echo "| No hay modulos registrados.\n";
        } else {
            foreach ($moduloes as $modulo) {
                echo $modulo->__toString();
                echo "\n";
            }
        }
        echo "+---------------------------------------\n";
    }
}


$interface = new ModuloInterface();
$interface->menuModulo();
