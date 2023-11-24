<?php
include_once "BaseDatos.php";

class Modulo extends ORM
{
    protected $id;
    protected $descripcion;
    protected $topeInscripciones;
    protected $costo;
    protected $horarioInicio;
    protected $horarioCierre;

    public function __construct()
    {
        $this->id = 0;
        $this->descripcion = "";
        $this->topeInscripciones = 0;
        $this->costo = 0.0;
        $this->horarioInicio = "";
        $this->horarioCierre = "";
    }

    public function cargar(
        $id,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre
    ) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->topeInscripciones = $topeInscripciones;
        $this->costo = $costo;
        $this->horarioInicio = $horarioInicio;
        $this->horarioCierre = $horarioCierre;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getTopeInscripciones()
    {
        return $this->topeInscripciones;
    }

    public function setTopeInscripciones($topeInscripciones)
    {
        $this->topeInscripciones = $topeInscripciones;
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    public function getHorarioInicio()
    {
        return $this->horarioInicio;
    }

    public function setHorarioInicio($horarioInicio)
    {
        $this->horarioInicio = $horarioInicio;
    }

    public function getHorarioCierre()
    {
        return $this->horarioCierre;
    }

    public function setHorarioCierre($horarioCierre)
    {
        $this->horarioCierre = $horarioCierre;
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM modulo WHERE id = $id";

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
            $registro['descripcion'],
            $registro['tope_inscripciones'],
            $registro['costo'],
            $registro['horario_inicio'],
            $registro['horario_cierre']
        );
        return true;
    }

    public function insertar()
    {
        $db = new BaseDatos();
        $consulta = "INSERT INTO modulo (descripcion, tope_inscripciones, costo, horario_inicio, horario_cierre) 
                     VALUES ($this->descripcion, $this->topeInscripciones, $this->costo, $this->horarioInicio, $this->horarioCierre)";

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
        $consulta = "UPDATE modulo SET 
                     descripcion = $this->descripcion, 
                     tope_inscripciones = $this->topeInscripciones, 
                     costo = $this->costo, 
                     horario_inicio = $this->horarioInicio,
                     horario_cierre = $this->horarioCierre 
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
        $consulta = "DELETE FROM modulo WHERE id = $this->id";

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
        $consulta = "SELECT * FROM modulo ORDER BY id";
        $arrModulos = array();

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            // $this->setMensajeOperacion($db->getError());
            return $arrModulos;
        }

        while ($registro = $db->Registro()) {
            $modulo = new Modulo();
            $modulo->cargar(
                $registro['id'],
                $registro['descripcion'],
                $registro['tope_inscripciones'],
                $registro['costo'],
                $registro['horario_inicio'],
                $registro['horario_cierre']
            );
            array_push($arrModulos, $modulo);
        }

        return $arrModulos;
    }
}
