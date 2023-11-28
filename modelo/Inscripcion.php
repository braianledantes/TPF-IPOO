<?php
require_once __DIR__ . "/BaseDatos.php";
require_once __DIR__ . "/ORM.php";

class Inscripcion extends ORM
{
    private $id;
    private $fecha;
    private $costoFinal;
    private $modulos;

    public function __construct()
    {
        $this->id = 0;
        $this->fecha = "";
        $this->costoFinal = 0.0;
        $this->modulos = array();
    }

    public function cargar($id, $fecha, $costoFinal)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->costoFinal = $costoFinal;
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

    public function getModulos()
    {
        return $this->modulos;
    }

    public function setModulos($modulos)
    {
        $this->modulos = $modulos;
    }

    public function __toString()
    {
        return "{ id: $this->id, fecha: $this->fecha, costoFinal: $this->costoFinal }";
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM inscripcion WHERE id = '$id'";

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
            $registro['costo_final']
        );
        return true;
    }

    public function insertar()
    {
        $db = new BaseDatos();
        $consulta = "INSERT INTO inscripcion (fecha, costo_final) 
                     VALUES ('$this->fecha', '$this->costoFinal')";

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
        $consulta = "UPDATE inscripcion SET 
                     id = '$this->id', 
                     fecha = '$this->fecha', 
                     costo_final = '$this->costoFinal'
                     WHERE id = '$this->id'";

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
        $consulta = "DELETE FROM inscripcion WHERE id = '$this->id'";

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
        $consulta = "SELECT * FROM inscripcion ORDER BY id";
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
                $registro['costo_final']
            );
            array_push($arrInscripciones, $inscripcion);
        }

        return $arrInscripciones;
    }

    public function inscribirAModulos($arrModulos)
    {
        $db = new BaseDatos();
        $consulta = "INSERT INTO modulo_inscripcion (id_modulo, id_inscripcion) VALUES ";
        foreach ($arrModulos as $modulo) {
            $idModulo = $modulo->getId();
            $consulta .= "('$idModulo', '$this->id'),";
        }
        $consulta = rtrim($consulta, ',');
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
}
