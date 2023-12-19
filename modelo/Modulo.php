<?php
require_once __DIR__ . "/BaseDatos.php";
require_once __DIR__ . "/ORM.php";

class Modulo extends ORM
{
    protected $id;
    protected $idActividad;
    protected $descripcion;
    protected $topeInscripciones;
    protected $costo;
    protected $horarioInicio;
    protected $horarioCierre;
    protected $inscripciones;

    public function __construct()
    {
        $this->id = 0;
        $this->idActividad = 0;
        $this->descripcion = "";
        $this->topeInscripciones = 0;
        $this->costo = 0.0;
        $this->horarioInicio = "00:00";
        $this->horarioCierre = "00:00";
        $this->inscripciones = array();
    }

    public function cargar(
        $id,
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre
    ) {
        $this->id = $id;
        $this->idActividad = $idActividad;
        $this->descripcion = $descripcion;
        $this->topeInscripciones = $topeInscripciones;
        $this->costo = $costo;
        $this->horarioInicio = $horarioInicio;
        $this->horarioCierre = $horarioCierre;
        $this->inscripciones = Modulo::listarInscripciones($this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdActividad()
    {
        return $this->idActividad;
    }

    public function setIdActividad($idActividad)
    {
        $this->idActividad = $idActividad;
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

    public function getInscripciones()
    {
        return $this->inscripciones;
    }

    public function setInscripciones($inscripciones)
    {
        $this->inscripciones = $inscripciones;
    }

    public function darCostoModulo()
    {
        return $this->costo;
    }

    public function __toString()
    {
        return
            "{\n id: $this->id,\n idActividad: $this->idActividad,\n descripcion: $this->descripcion,\n topeInscripciones: $this->topeInscripciones,\n costo: $this->costo,\n horarioInicio: $this->horarioInicio,\n horarioCierre: $this->horarioCierre\n}";
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM modulo WHERE id = '$id'";
        $result = true;
        if (
            $db->Iniciar() &&
            $db->Ejecutar($consulta) &&
            $registro = $db->Registro()
        ) {
            $this->cargar(
                $id,
                $registro['id_actividad'],
                $registro['descripcion'],
                $registro['tope_inscripciones'],
                $registro['costo'],
                $registro['horario_inicio'],
                $registro['horario_cierre']
            );
        } else {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public function insertar()
    {
        $db = new BaseDatos();
        $consulta = "INSERT INTO modulo (id_actividad, descripcion, tope_inscripciones, costo, horario_inicio, horario_cierre) 
                     VALUES ('$this->idActividad','$this->descripcion', '$this->topeInscripciones', '$this->costo', '$this->horarioInicio', '$this->horarioCierre')";
        $result = true;

        if (
            $db->Iniciar() &&
            $id = $db->devuelveIDInsercion($consulta)
        ) {
            $this->setId($id);
        } else {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public function modificar()
    {
        $db = new BaseDatos();
        $consulta = "UPDATE modulo SET 
                     id_actividad = '$this->idActividad', 
                     descripcion = '$this->descripcion', 
                     tope_inscripciones = '$this->topeInscripciones', 
                     costo = '$this->costo', 
                     horario_inicio = '$this->horarioInicio',
                     horario_cierre = '$this->horarioCierre' 
                     WHERE id = '$this->id'";
        $result = true;

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public function eliminar()
    {
        $db = new BaseDatos();
        $consulta = "DELETE FROM modulo WHERE id = '$this->id'";
        $result = true;

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public static function listar()
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM modulo ORDER BY id";
        $arrModulos = array();

        if ($db->Iniciar() && $db->Ejecutar($consulta)) {
            while ($registro = $db->Registro()) {
                $modulo = new Modulo();
                $modulo->cargar(
                    $registro['id'],
                    $registro['id_actividad'],
                    $registro['descripcion'],
                    $registro['tope_inscripciones'],
                    $registro['costo'],
                    $registro['horario_inicio'],
                    $registro['horario_cierre']
                );
                array_push($arrModulos, $modulo);
            }
        }

        return $arrModulos;
    }

    private static function listarInscripciones($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT inscripcion.*
                     FROM inscripcion
                     INNER JOIN modulo_inscripcion ON id_inscripcion = id
                     WHERE id_modulo = $id";
        $arrInscripciones = array();

        if ($db->Iniciar() && $db->Ejecutar($consulta)) {
            while ($registro = $db->Registro()) {
                $inscripcion = new Inscripcion();
                $inscripcion->cargar(
                    $registro['id'],
                    $registro['fecha'],
                    $registro['costo_final']
                );
                array_push($arrInscripciones, $inscripcion);
            }
        }

        return $arrInscripciones;
    }
}
