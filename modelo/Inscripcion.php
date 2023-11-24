<?php
include_once "BaseDatos.php";

class Inscripcion extends ORM
{
    private $id;
    private $fecha;
    private $costoFinal;
    private $ingresante;

    public function __construct()
    {
        $this->id = 0;
        $this->fecha = "";
        $this->costoFinal = 0.0;
    }

    public function cargar($id, $fecha, $costoFinal, $legajo)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->costoFinal = $costoFinal;
        $this->ingresante = new Ingresante();
        $this->ingresante->buscar($legajo);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getCostoFinal()
    {
        return $this->costoFinal;
    }

    public function setCostoFinal($costoFinal)
    {
        $this->costoFinal = $costoFinal;
    }

    public function getIngresante()
    {
        return $this->ingresante;
    }

    public function setIngresante($ingresante)
    {
        $this->ingresante = $ingresante;
    }

    public function __toString()
    {
        return "{ id: $this->id, fecha: $this->fecha, costoFinal: $this->costoFinal }";
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM inscripcion WHERE id = $id";

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
            $id,
            $registro['fecha'],
            $registro['costo_final'],
            $registro['legajo']
        );
        return true;
    }

    public function insertar()
    {
        $db = new BaseDatos();
        $consulta = "INSERT INTO inscripcion (fecha, costo_final) 
                     VALUES ($this->fecha, $this->costoFinal)";

        if (!$db->Iniciar()) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        $id = $db->devuelveIDInsercion($consulta);

        if (!$id) {
            $this->setMensajeOperacion($db->getError());
            return false;
        }

        $this->setId($id);
        return true;
    }

    public function modificar()
    {
        $db = new BaseDatos();
        $consulta = "UPDATE ingresante SET 
                     id = $this->id, 
                     fecha = $this->fecha, 
                     costo_final = $this->costoFinal
                     WHERE id = $this->id";

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
        $consulta = "DELETE FROM ingresante WHERE id = $this->id";

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
        $consulta = "SELECT * FROM ingresante ORDER BY id";
        $arrInscripciones = array();

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            // $this->setMensajeOperacion($db->getError());
            return $arrInscripciones;
        }

        while ($registro = $db->Registro()) {
            $inscripcion = new Inscripcion();
            $inscripcion->cargar(
                $registro['id'],
                $registro['fecha'],
                $registro['costo_final'],
                $registro['legajo']
            );
            array_push($arrInscripciones, $inscripcion);
        }

        return $arrInscripciones;
    }
}
