<?php
require_once __DIR__ . "/BaseDatos.php";
require_once __DIR__ . "/ORM.php";

class Ingresante extends ORM
{
    private $legajo;
    private $dni;
    private $nombre;
    private $apellido;
    private $correoElectronico;
    private $inscripcion;

    public function __construct()
    {
        $this->legajo = "";
        $this->dni = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->correoElectronico = "";
        $this->inscripcion = new Inscripcion();
    }

    public function cargar($legajo, $dni, $nombre, $apellido, $correoElectronico, $idInscripcion)
    {
        $this->legajo = $legajo;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correoElectronico = $correoElectronico;
        $this->inscripcion->buscar($idInscripcion);
    }

    public function getLegajo()
    {
        return $this->legajo;
    }

    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;
    }

    public function buscar($legajo)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM ingresante WHERE legajo = '$legajo'";

        if (!$db->Iniciar()) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        if (!$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        $registro = $db->Registro();

        if (!$registro) {
            return false;
        }

        $this->cargar(
            $legajo,
            $registro['dni'],
            $registro['nombre'],
            $registro['apellido'],
            $registro['correo_electronico'],
            $registro['id_inscripcion']
        );
        return true;
    }

    public function insertar()
    {
        $db = new BaseDatos();
        $idInscripcion = $this->inscripcion->getId();
        $consulta = "INSERT INTO ingresante (legajo, dni, nombre, apellido, correo_electronico, id_inscripcion) 
                     VALUES ('$this->legajo',
                             '$this->dni',
                             '$this->nombre',
                             '$this->apellido',
                             '$this->correoElectronico',
                             '$idInscripcion')";

        if (!$db->Iniciar()) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        $id = $db->devuelveIDInsercion($consulta);

        if (!$id) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        $this->setLegajo($id);
        return true;
    }

    public function modificar()
    {
        $idInsgresante = $this->inscripcion->getId();
        $db = new BaseDatos();
        $consulta = "UPDATE ingresante SET 
                     legajo = '$this->legajo',
                     dni = '$this->dni',
                     nombre = '$this->nombre',
                     apellido = '$this->apellido',
                     correo_electronico = '$this->correoElectronico',
                     id_inscripcion = '$idInsgresante',
                     WHERE legajo = '$this->legajo'";

        if (!$db->Iniciar()) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        if (!$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        return true;
    }

    public function eliminar()
    {
        $db = new BaseDatos();
        $consulta = "DELETE FROM ingresante WHERE legajo = '$this->legajo'";

        if (!$db->Iniciar()) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        if (!$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        return true;
    }

    public static function listar()
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM ingresante ORDER BY legajo";
        $arrIngresantes = array();

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            // $this->setMensajeOperacion($db->getError());
            return $arrIngresantes;
        }

        while ($registro = $db->Registro()) {
            $ingresante = new Ingresante();
            $ingresante->cargar(
                $registro['legajo'],
                $registro['dni'],
                $registro['nombre'],
                $registro['apellido'],
                $registro['correo_electronido'],
                $registro['id_inscripcion']
            );
            array_push($arrIngresantes, $ingresante);
        }

        return $arrIngresantes;
    }

    public function __toString()
    {
        return "{ legajo: $this->legajo, dni: $this->dni, nombre: $this->nombre, apellido: $this->apellido, correoElectronico: $this->correoElectronico, inscripcion: $this->inscripcion }";
    }
}
