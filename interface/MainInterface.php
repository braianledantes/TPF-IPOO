<?php
require_once __DIR__ . "/ActividadInterface.php";
require_once __DIR__ . "/ModuloInterface.php";
require_once __DIR__ . "/ModuloEnLineaInterface.php";
require_once __DIR__ . "/InscripcionInterface.php";


class MainInterface {

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
            echo "| 1. Menú de Actividades             |\n";
            echo "| 2. Menú de Módulos                 |\n";
            echo "| 3. Menú de Módulos en Línea        |\n";
            echo "| 4. Menú de Inscripciones           |\n";
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
                case 0:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción inválida. Intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 0);
    }
}

$MainInterface = new MainInterface();
$MainInterface->menuPrincipal();