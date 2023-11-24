<?php
abstract class ORM {
    private $mensajeOperacion;

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    abstract public function buscar($id);

    abstract public function insertar();

    abstract public function modificar();

    abstract public function eliminar();

    abstract public static function listar();
}