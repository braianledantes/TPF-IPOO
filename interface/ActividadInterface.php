<?php
include_once __DIR__ . '/../control/ActividadControl.php';

class ActividadInterface
{
    public function menuActividad()
    {
        do {
            echo "+- MENÚ DE ACTIVIDADES ---------+\n";
            echo "| 1. Ingresar un actividad      |\n";
            echo "| 2. Modificar un actividad     |\n";
            echo "| 3. Eliminar un actividad      |\n";
            echo "| 4. Listar todos los actividad |\n";
            echo "| 0. Salir                      |\n";
            echo "| Ingrese una opción:           |\n";
            echo "+-------------------------------+\n";
            $opcion = intval(trim(fgets(STDIN)));

            switch ($opcion) {
                case 1:
                    $this->crearActividad();
                    break;
                case 2:
                    $this->modificarActividad();
                    break;
                case 3:
                    $this->eliminarActividad();
                    break;
                case 4:
                    $this->listarActividades();
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

    private function crearActividad()
    {
        echo "+- Crear Actividad ---------------------\n";

        echo "| Ingrese la descripción corta: ";
        $descripcionCorta = trim(fgets(STDIN));
        echo "| Ingrese la descripción larga: ";
        $descripcionLarga = trim(fgets(STDIN));

        if (ActividadControl::crearActividad($descripcionCorta, $descripcionLarga)) {
            echo "| Actividad creada correctamente.\n";
        } else {
            echo "| Error al crear la actividad.\n";
        }
        echo "+---------------------------------------\n";
    }

    private function eliminarActividad()
    {
        echo "+- Eliminar Actividad ------------------\n";

        echo "| Ingrese la identificación de la actividad: ";
        $id = trim(fgets(STDIN));

        if (ActividadControl::eliminarActividad($id)) {
            echo "| Actividad $id eliminada correctamente.\n";
        } else {
            echo "| Error al eliminar actividad $id.\n";
        }
        echo "+---------------------------------------\n";
    }

    private function modificarActividad()
    {
        echo "+- Modificar Actividad -----------------\n";

        echo "| Ingrese la identificación de la actividad: ";
        $id = trim(fgets(STDIN));

        $actividad = ActividadControl::obtenerActividad($id);
        $descripcionCorta = $actividad->getDescripcionCorta();
        $descripcionLarga = $actividad->getDescripcionLarga();

        echo "| Ingrese la descripción corta ($descripcionCorta)// Enter para saltar paso:  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $descripcionCorta = $input;
        
        echo "| Ingrese la descripción larga ($descripcionLarga)// Enter para saltar paso:  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $descripcionLarga = $input;

        if (ActividadControl::modificarActividad($id, $descripcionCorta, $descripcionLarga)) {
            echo "| Actividad creada correctamente.\n";
        } else {
            echo "| Error al crear la actividad.\n";
        }
        echo "+---------------------------------------\n";
    }

    private function listarActividades()
    {
        echo "+- Listar Actividades ------------------\n";

        $actividades = ActividadControl::listarActividades();
        if (empty($actividades)) {
            echo "| No hay actividades registradas.\n";
        } else {
            foreach ($actividades as $actividad) {
                echo $actividad->__toString();
                echo "\n";
            }
        }
        echo "+---------------------------------------\n";
    }
}


$interface = new ActividadInterface();
$interface->menuActividad();
