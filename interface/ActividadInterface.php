<?php
include_once __DIR__ . '/../control/ActividadControl.php';

class ActividadInterface
{
    public function menuActividad()
    {
        do {
            system('clear');
            echo "+- MENÚ DE ACTIVIDADES -----------+\n";
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
        system('clear');
    }

    private function crearActividad()
    {
        system('clear');
        echo "+- Crear Actividad ----------------------------\n";

        echo "| Ingrese la descripción corta: ";
        $descripcionCorta = trim(fgets(STDIN));
        echo "| Ingrese la descripción larga: ";
        $descripcionLarga = trim(fgets(STDIN));

        if (ActividadControl::crearActividad($descripcionCorta, $descripcionLarga)) {
            echo "| Actividad creada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+/////////////////////////////+\n";
            echo "// Error al crear actividad. //\n";
            echo "+/////////////////////////////+\n";
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function eliminarActividad()
    {
        system('clear');
        echo "+- Eliminar Actividad -------------------------\n";

        echo "| Ingrese la identificación de la actividad: ";
        $id = trim(fgets(STDIN));

        if (ActividadControl::eliminarActividad($id)) {
            echo "| Actividad $id eliminada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+////////////////////////////////////+\n";
            echo "// Error al eliminar actividad $id. //\n";
            echo "+////////////////////////////////////+\n";
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function modificarActividad()
    {
        system('clear');
        echo "+- Modificar Actividad ------------------------\n";

        do {
            echo "| Ingrese la identificación de la actividad: ";
            $id = trim(fgets(STDIN));
            $existeActividad = ActividadControl::existeActividad($id);
            if (!$existeActividad) {
                echo "No existe actividad con id $id\n";
            }
        } while (!$existeActividad);

        $actividad = ActividadControl::obtenerActividad($id);
        $descripcionCorta = $actividad->getDescripcionCorta();
        $descripcionLarga = $actividad->getDescripcionLarga();

        echo $actividad->__toString() . "\n";
        echo "| Ingrese la descripción corta (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $descripcionCorta = $input;

        echo "| Ingrese la descripción larga (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $descripcionLarga = $input;

        if (ActividadControl::modificarActividad($id, $descripcionCorta, $descripcionLarga)) {
            echo "| Actividad modificar correctamente.\n";
        } else {
            echo "\n\n";
            echo "+////////////////////////////////////+\n";
            echo "// Error al modificar la actividad. //\n";
            echo "+////////////////////////////////////+\n";
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function listarActividades()
    {
        system('clear');
        echo "+- Listar Actividades -------------------------\n";

        $actividades = ActividadControl::listarActividades();
        if (empty($actividades)) {
            echo "| No hay actividades registradas.\n";
        } else {
            foreach ($actividades as $actividad) {
                echo $actividad->__toString();
                echo "\n";
            }
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }
}
