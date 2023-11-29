<?php
require_once __DIR__ . "/ActividadInterface.php";
require_once __DIR__ . "/ModuloInterface.php";
require_once __DIR__ . "/ModuloEnLineaInterface.php";
require_once __DIR__ . "/InscripcionInterface.php";

require_once __DIR__ . "/../control/ActividadControl.php";
require_once __DIR__ . "/../control/ModuloControl.php";
require_once __DIR__ . "/../control/IngresanteControl.php";


class MainInterface
{

    private $actividadInterface;
    private $moduloInterface;
    private $moduloEnLineaInterface;
    private $inscripcionInterface;

    public function __construct()
    {
        $this->actividadInterface = new ActividadInterface();
        $this->moduloInterface = new ModuloInterface();
        $this->moduloEnLineaInterface = new ModuloEnLineaInterface();
        $this->inscripcionInterface = new InscripcionInterface();
    }

    public function menuPrincipal()
    {
        do {
            echo "+- MENÚ PRINCIPAL -------------------+\n";
            echo "| 1. ABM de actividades              |\n";
            echo "| 2. ABM de módulos                  |\n";
            echo "| 3. ABM de módulos en línea         |\n";
            echo "| 4. ABM de inscripciones            |\n";
            echo "| 5. Ver todas las inscripciones     |\n";
            echo "| 6. Ver inscripciones de módulo     |\n";
            echo "| 7. Ver inscripciones de actividad  |\n";
            echo "| 8.                                 |\n";
            echo "| 9. Ver actividades de ingresante   |\n";
            echo "| 0. Salir                           |\n";
            echo "| Ingrese una opción:                |\n";
            echo "+------------------------------------+\n";
            $opcion = intval(trim(fgets(STDIN)));

            switch ($opcion) {
                case 1:
                    $this->actividadInterface->menuActividad();
                    break;
                case 2:
                    $this->moduloInterface->menuModulo();
                    break;
                case 3:
                    $this->moduloEnLineaInterface->menuModuloEnLinea();
                    break;
                case 4:
                    $this->inscripcionInterface->menuInscripcion();
                    break;
                case 5:
                    $this->visualizarInscripciones();
                    break;
                case 6:
                    $this->visualizarInscripcionesDeModulo();
                    break;
                case 7:
                    $this->mostrarInscripcionesDeUnaActividad();
                    break;
                case 8:
                    // TODO
                    break;
                case 9:
                    $this->mostrarActividadesDeIngresante();
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

    private function visualizarInscripciones()
    {
        // Visualizar todas las inscripciones realizadas.
        $inscripciones = InscripcionControl::listarInscripciones();
        if (empty($inscripciones)) {
            echo "| No hay inscripciones registradas.\n";
        } else {
            foreach ($inscripciones as $inscripcion) {
                echo $inscripcion->__toString();
                echo "\n";
            }
        }
    }

    private function visualizarInscripcionesDeModulo()
    {
        // Visualizar todas las inscripciones realizadas de un modulo determinado.
        echo "| Ingrese la identificación del módulo: ";
        $idModulo = trim(fgets(STDIN));
        $existeInscripcion = ModuloControl::existeModulo($idModulo);
        if (!$existeInscripcion) {
            echo "No existe modulo con id $idModulo\n";
        } else {
            $inscripciones = InscripcionControl::listarInscripcionesDeModulo($idModulo);
            if (empty($inscripciones)) {
                echo "| No hay inscripciones registradas.\n";
            } else {
                foreach ($inscripciones as $inscripcion) {
                    echo $inscripcion->__toString();
                    echo "\n";
                }
            }
        }
    }

    private function mostrarInscripcionesDeUnaActividad()
    {
        echo "| Ingrese la identificación de la actividad: ";
        $idActividad = trim(fgets(STDIN));
        $existeInscripcion = ActividadControl::existeActividad($idActividad);
        if (!$existeInscripcion) {
            echo "No existe actividad con id $idActividad\n";
        } else {
            $inscripciones = InscripcionControl::listarInscripcionesDeActividad($idActividad);
            if (empty($inscripciones)) {
                echo "| No hay inscripciones registradas.\n";
            } else {
                foreach ($inscripciones as $inscripcion) {
                    echo $inscripcion->__toString();
                    echo "\n";
                }
            }
        }
    }

    private function mostrarActividadesDeIngresante()
    {
        echo "| Ingrese el legajo del ingresante: ";
        $legajo = trim(fgets(STDIN));
        $existeIngresante = IngresanteControl::existeIngresante($legajo);
        if (!$existeIngresante) {
            echo "No existe ingresante con legajo $legajo\n";
        } else {
            $actividades = ActividadControl::listarActividadesDeIngresante($legajo);
            if (empty($actividades)) {
                echo "| No hay inscripciones registradas.\n";
            } else {
                foreach ($actividades as $actividad) {
                    echo $actividad->__toString();
                    echo "\n";
                }
            }
        }
    }
}

$MainInterface = new MainInterface();
$MainInterface->menuPrincipal();
