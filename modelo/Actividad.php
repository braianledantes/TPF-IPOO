<?php
require_once __DIR__ . "/BaseDatos.php";
require_once __DIR__ . "/ORM.php";
require_once __DIR__ . "/Modulo.php";

class Actividad extends ORM
{
    private $id;
    private $descripcionCorta;
    private $descripcionLarga;
    private $modulos;

    public function __construct()
    {
        $this->id = 0;
        $this->descripcionCorta = "";
        $this->descripcionLarga = "";
        $this->modulos = array();
    }

    public function cargar($id, $descripcionCorta, $descripcionLarga)
    {
        $this->id = $id;
        $this->descripcionCorta = $descripcionCorta;
        $this->descripcionLarga = $descripcionLarga;
        $this->modulos = Modulo::listar($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcionCorta()
    {
        return $this->descripcionCorta;
    }

    public function getDescripcionLarga()
    {
        return $this->descripcionLarga;
    }

    public function getModulos()
    {
        return $this->modulos;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescripcionCorta($descripcionCorta)
    {
        $this->descripcionCorta = $descripcionCorta;
    }

    public function setDescripcionLarga($descripcionLarga)
    {
        $this->descripcionLarga = $descripcionLarga;
    }

    public function setModulos($modulos)
    {
        $this->modulos = $modulos;
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM actividad WHERE id = '$id'";
        $result = false;

        if (
            $db->Iniciar() &&
            $db->Ejecutar($consulta) &&
            $registro = $db->Registro()
        ) {
            $this->cargar($id, $registro['descripcion_corta'], $registro['descripcion_larga']);
            $result = true;
        } else {
            $this->setMensajeOperacion($db->getError());
        }

        return $result;
    }

    public function insertar()
    {
        $result = false;
        $db = new BaseDatos();
        $consulta = "INSERT INTO actividad (descripcion_corta, descripcion_larga) VALUES ('$this->descripcionCorta', '$this->descripcionLarga')";

        if (
            $db->Iniciar() &&
            $id = $db->devuelveIDInsercion($consulta)
        ) {
            $this->setId($id);
            $result = true;
        } else {
            $this->setMensajeOperacion($db->getError());
        }

        return $result;
    }

    public function modificar()
    {
        $result = true;
        $db = new BaseDatos();
        $consulta = "UPDATE actividad SET descripcion_corta = '$this->descripcionCorta', descripcion_larga = '$this->descripcionLarga' WHERE id = '$this->id'";

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public function eliminar()
    {
        $db = new BaseDatos();
        $consulta = "DELETE FROM actividad WHERE id = '$this->id'";
        $result = true;

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            $this->setMensajeOperacion($db->getError());
            $result = false;
        }

        return $result;
    }

    public function __toString()
    {
        return "{ id: $this->id, descripcionCorta: $this->descripcionCorta, descripcionLarga: $this->descripcionLarga }";
    }

    public static function listar()
    {
        $db = new BaseDatos();
        $consulta = "SELECT * FROM actividad ORDER BY id";
        $arrActividades = array();

        if ($db->Iniciar() && $db->Ejecutar($consulta)) {
            while ($registro = $db->Registro()) {
                $actividad = new Actividad();
                $actividad->cargar($registro['id'], $registro['descripcion_corta'], $registro['descripcion_larga']);
                array_push($arrActividades, $actividad);
            }
        }

        return $arrActividades;
    }
}
