<?php
require_once __DIR__ . "/BaseDatos.php";
require_once __DIR__ . "/Modulo.php";

class ModuloEnLinea extends Modulo
{
    private $link;
    private $bonificacion;

    public function __construct()
    {
        parent::__construct();
        $this->link = "";
        $this->bonificacion = 0.0;
    }

    public function cargarr(
        $id,
        $idActividad,
        $descripcion,
        $topeInscripciones,
        $costo,
        $horarioInicio,
        $horarioCierre,
        $link,
        $bonificacion
    ) {
        parent::cargar($id, $idActividad, $descripcion, $topeInscripciones, $costo, $horarioInicio, $horarioCierre);
        $this->link = $link;
        $this->bonificacion = $bonificacion;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getBonificacion()
    {
        return $this->bonificacion;
    }

    public function setBonificacion($bonificacion)
    {
        $this->bonificacion = $bonificacion;
    }

    public function darCostoMódulo() {
        return $this->costo * (1 - ($this->bonificacion / 100));
    }

    public function __toString()
    {
        return 
        "{\n id: $this->id,\n idActividad: $this->idActividad,\n descripcion: $this->descripcion,\n topeInscripciones: $this->topeInscripciones,\n costo: $this->costo,\n horarioInicio: $this->horarioInicio,\n horarioCierre: $this->horarioCierre,\n link: $this->link,\n bonificacion: $this->bonificacion\n}";
    }

    public function buscar($id)
    {
        $db = new BaseDatos();
        $consulta = "SELECT m.*, ml.link, ml.bonificacion 
                     FROM modulo_en_linea AS ml 
                     INNER JOIN modulo AS m ON ml.id = m.id 
                     WHERE m.id = '$id'";

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

        $this->cargarr(
            $id,
            $registro['id_actividad'],
            $registro['descripcion'],
            $registro['tope_inscripciones'],
            $registro['costo'],
            $registro['horario_inicio'],
            $registro['horario_cierre'],
            $registro['link'],
            $registro['bonificacion']
        );
        return true;
    }

    public function insertar()
    {
        if (parent::insertar()) {
            $db = new BaseDatos();
            $consulta = "INSERT INTO modulo_en_linea (id, link, bonificacion) 
                     VALUES ('$this->id', '$this->link', '$this->bonificacion')";

            if (!$db->Iniciar()) {
                $this->setMensajeOperacion($db->getError());
                return false;
            }

            $db->devuelveIDInsercion($consulta);
            // no setea el id devuelto porque la hace la funcion del padre
            return true;
        } else {
            return false;
        }
    }

    public function modificar()
    {
        if (parent::modificar()) {
            $db = new BaseDatos();
            $consulta = "UPDATE modulo_en_linea SET 
                         link = '$this->link', 
                         bonificacion = '$this->bonificacion'
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
        } else {
            return false;
        }
        
    }

    public function eliminar()
    {
        return parent::eliminar();
    }

    public static function listar()
    {
        $db = new BaseDatos();
        $consulta = "SELECT m.*, ml.link, ml.bonificacion 
                     FROM modulo_en_linea AS ml 
                     INNER JOIN modulo AS m ON ml.id = m.id 
                     ORDER BY m.id";
        $arrModulos = array();

        if (!$db->Iniciar() || !$db->Ejecutar($consulta)) {
            // $this->setMensajeOperacion($db->getError());
            return $arrModulos;
        }

        while ($registro = $db->Registro()) {
            $modulo = new ModuloEnLinea();
            $modulo->cargarr(
                $registro['id'],
                $registro['id_actividad'],
                $registro['descripcion'],
                $registro['tope_inscripciones'],
                $registro['costo'],
                $registro['horario_inicio'],
                $registro['horario_cierre'],
                $registro['link'],
                $registro['bonificacion']
            );
            array_push($arrModulos, $modulo);
        }

        return $arrModulos;
    }
}
