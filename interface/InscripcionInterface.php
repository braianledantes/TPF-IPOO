<?php
include_once __DIR__ . '/../control/InscripcionControl.php';
include_once __DIR__ . '/../control/ModuloEnLineaControl.php';
include_once __DIR__ . '/../control/ModuloControl.php';
include_once __DIR__ . '/../control/IngresanteControl.php';

class InscripcionInterface
{
    public function menuInscripcion()
    {
        do {
            system('clear');
            echo "+- MENÚ DE INSCRIPCIONES -----------+\n";
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
                    $this->crearInscripcion();
                    break;
                case 2:
                    $this->modificarInscripcion();
                    break;
                case 3:
                    $this->eliminarInscripcion();
                    break;
                case 4:
                    $this->listarInscripciones();
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

    private function crearInscripcion()
    {
        system('clear');
        echo "+- Crear Inscripción --------------------------\n";

        $arrModulos = array();

        // solicta los datos del ingresante
        echo "| Ingrese el legajo del ingresante:  ";
        $legajo = trim(fgets(STDIN));
        echo "| Ingrese el DNI del ingresante:  ";
        $dni = trim(fgets(STDIN));
        echo "| Ingrese el nombre del ingresante:  ";
        $nombre = trim(fgets(STDIN));
        echo "| Ingrese el apellido del ingresante:  ";
        $apellido = trim(fgets(STDIN));
        echo "| Ingrese el correo electronico del ingresante:  ";
        $correoElectronico = trim(fgets(STDIN));

        // solicita la fecha al usuario
        $fecha = date("Y-m-d");
        echo "| Ingrese la fecha de inscripción (AAAA-MM-DD) (Enter para actual $fecha):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $fecha = $input;

        // solicita los modulos al usuario
        $this->mostrarListadoModulos();
        do {
            echo "| Ingrese el id del modulo a inscribir (Enter para salir): ";
            $idModulo = trim(fgets(STDIN));
            $modulo = null;
            if ($idModulo != "") {
                try {
                    $modulo = ModuloEnLineaControl::obtenerModuloEnLinea($idModulo);
                } catch (\Throwable $th) {
                    try {
                        $modulo = ModuloControl::obtenerModulo($idModulo);
                    } catch (\Throwable $th) {
                        echo "No existe modulo con id = $idModulo\n";
                    }
                } finally {
                    if ($modulo != null) {
                        array_push($arrModulos, $modulo);
                        echo "Modulo $idModulo agregado\n";
                    }
                }
            }
        } while ($idModulo != "");

        if (InscripcionControl::crearInscripcion(
            $legajo,
            $dni,
            $nombre,
            $apellido,
            $correoElectronico,
            $fecha,
            $arrModulos
        )) {
            echo "| Inscripción creada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+/////////////////////////////+\n";
            echo "// Error al crear inscripción. //\n";
            echo "+/////////////////////////////+\n";
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function eliminarInscripcion()
    {
        system('clear');
        echo "+- Eliminar Inscripción -----------------------\n";

        echo "| Ingrese la identificación de la inscripción: ";
        $id = trim(fgets(STDIN));

        if (InscripcionControl::eliminarInscripcion($id)) {
            echo "| Inscripción $id eliminada correctamente.\n";
        } else {
            echo "\n\n";
            echo "+//////////////////////////////////////+\n";
            echo "// Error al eliminar inscripción $id. //\n";
            echo "+//////////////////////////////////////+\n";
            echo "Presione Enter para continuar...";
            fgets(STDIN);
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }
    
    private function modificarInscripcion()
    {
        system('clear');
        echo "+- Modificar Inscripción ----------------------\n";

        do {
            echo "| Ingrese la identificación de la inscripción: ";
            $id = trim(fgets(STDIN));
            $existeInscripcion = InscripcionControl::existeInscripcion($id);
            if (!$existeInscripcion) {
                echo "| No existe inscripción con id $id\n";
            }
        } while (!$existeInscripcion);

        $inscripcion = InscripcionControl::obtenerInscripcion($id);
        echo $inscripcion->__toString();

        $fecha = $inscripcion->getFecha();
        $modulosInscripcion = $inscripcion->getModulos();

        echo "| Modulos inscriptos:\n";
        foreach ($modulosInscripcion as $modulo) {
            echo $modulo->__toString() . "\n";
        }

        echo "| Ingrese la fecha de inscripción (AAAA-MM-DD) (Enter para saltar paso):  ";
        $input = trim(fgets(STDIN));
        if ($input !== "") $fecha = $input;

        // solicita los modulos al usuario
        $arrModulos = array();
        $this->mostrarListadoModulos();
        do {
            echo "| Ingrese el id del modulo a inscribir (Enter para salir): ";
            $idModulo = trim(fgets(STDIN));
            $modulo = null;
            if ($idModulo != "") {
                try {
                    $modulo = ModuloEnLineaControl::obtenerModuloEnLinea($idModulo);
                } catch (\Throwable $th) {
                    try {
                        $modulo = ModuloControl::obtenerModulo($idModulo);
                    } catch (\Throwable $th) {
                        echo "No existe modulo con id = $idModulo\n";
                    }
                } finally {
                    if ($modulo != null) {
                        array_push($arrModulos, $modulo);
                        echo "Modulo $idModulo agregado\n";
                    }
                }
            }
        } while ($idModulo != "");

        if (InscripcionControl::modificarInscripcion(
            $id,
            $fecha,
            $arrModulos
        )) {
            echo "| Actividad modificar correctamente.\n";
        } else {
            echo "\n\n";
            echo "+//////////////////////////////////////+\n";
            echo "// Error al modificar la inscripción. //\n";
            echo "+//////////////////////////////////////+\n";
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function listarInscripciones()
    {
        system('clear');
        echo "+- Listar Inscripciones -----------------------\n";

        $inscripciones = InscripcionControl::listarInscripciones();
        if (empty($inscripciones)) {
            echo "| No hay inscripciones registradas.\n";
        } else {
            foreach ($inscripciones as $inscripcion) {
                echo $inscripcion->__toString();
                echo "\n";
            }
        }
        echo "+----------------------------------------------\n";
        echo "Presione Enter para continuar...";
        fgets(STDIN);
        system('clear');
    }

    private function mostrarListadoModulos()
    {
        $modulos = ModuloControl::listarModuloes();
        echo "Ingresantes:\n";
        foreach ($modulos as $modulo) {
            echo $modulo->__toString() . "\n";
        }
    }

    
}
