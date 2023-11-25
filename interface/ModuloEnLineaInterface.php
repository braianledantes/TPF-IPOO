<?php
include_once __DIR__ . '/../control/ModuloEnLineaControl.php';
include_once __DIR__ . '/../control/ActividadControl.php';

class ModuloEnLineaInterface
{
    public function menuModuloEnLinea()
    {
        do {
            echo "+- MENÚ DE MÓDULOS EN LINEA ------+\n";
            echo "| 1. Ingresar                     |\n";
            echo "| 2. Modificar                    |\n";
            echo "| 3. Eliminar                     |\n";
            echo "| 4. Listar todo                  |\n";
            echo "| 0. Salir                        |\n";
            echo "| Ingrese una opción:             |\n";
            echo "+---------------------------------+\n";
            $opcion = intval(trim(fgets(STDIN)));

            switch ($opcion) {
                case 1:
                    $this->crearModuloEnLinea();
                    break;
                case 2:
                    $this->modificarModuloEnLinea();
                    break;
                case 3:
                    $this->eliminarModuloEnLinea();
                    break;
                case 4:
                    $this->listarModulosEnLinea();
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

    private function crearModuloEnLinea()
    {
        echo "+- Crear Módulo En Linea ---------------------\n";

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
        echo "| Ingrese link: ";
        $link = trim(fgets(STDIN));
        echo "| Ingrese la bonificación: ";
        $bonificacion = trim(fgets(STDIN));

        if (ModuloEnLineaControl::crearModuloEnLinea(
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre,
            $link,
            $bonificacion
        )) {
            echo "| Módulo En Linea creado correctamente.\n";
        } else {
            echo "\n\n";
            echo "+//////////////////////////////////////+\n";
            echo "// Error al crear la módulo en linea. //\n";
            echo "+//////////////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+---------------------------------------\n";
    }

    private function eliminarModuloEnLinea()
    {
        echo "+- Eliminar Módulo En Linea ------------------\n";
        echo "| Ingrese la identificación de la módulo: ";
        $id = trim(fgets(STDIN));

        if (ModuloEnLineaControl::eliminarModuloEnLinea($id)) {
            echo "| Módulo $id eliminada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+//////////////////////////////////////////+\n";
            echo "// Error al eliminar módulo en linea $id. //\n";
            echo "+//////////////////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+---------------------------------------\n";
    }

    private function modificarModuloEnLinea()
    {
        echo "+- Modificar Módulo En Linea -----------------\n";
        echo "| Ingrese la identificación del módulo: ";
        $id = trim(fgets(STDIN));

        $modulo = ModuloEnLineaControl::obtenerModuloEnLinea($id);
        $idActividad = $modulo->getIdActividad();
        $descripcion = $modulo->getDescripcion();
        $topeInscripciones = $modulo->getTopeInscripciones();
        $costo = $modulo->getCosto();
        $horarioInicio = $modulo->getHorarioInicio();
        $horarioCierre = $modulo->getHorarioCierre();
        $link = $modulo->getLink();
        $bonificacion = $modulo->getBonificacion();

        echo $modulo->__toString();

        echo "\n| Ingrese el id de la actividad (Enter para saltar paso):  ";
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

        if (ModuloEnLineaControl::modificarModuloEnLinea(
            $id,
            $idActividad,
            $descripcion,
            $topeInscripciones,
            $costo,
            $horarioInicio,
            $horarioCierre,
            $link,
            $bonificacion
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

    private function listarModulosEnLinea()
    {
        echo "+- Listar Módulos ------------------\n";

        $moduloes = ModuloEnLineaControl::listarModuloEnLineas();
        if (empty($moduloes)) {
            echo "| No hay modulos en linea registrados.\n";
        } else {
            foreach ($moduloes as $modulo) {
                echo $modulo->__toString();
                echo "\n";
            }
        }
        echo "+---------------------------------------\n";
    }
}
