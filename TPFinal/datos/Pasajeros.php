<?php

class Pasajero
{

    //!ATRIBUTOS
    private $nombre;
    private $apellido;
    private $nrodoc;
    private $telefono;

    //!CONSTRUCTOR
    public function __construct($nombre, $apellido, $nrodoc, $telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nrodoc = $nrodoc;
        $this->telefono = $telefono;
    }

    //! **********GETTERS*************

    public function getnombre()
    {
        return $this->nombre;
    }

    public function getapellido()
    {
        return $this->apellido;
    }

    public function getnrodoc()
    {
        return $this->nrodoc;
    }

    public function gettelefono()
    {
        return $this->telefono;
    }

    //! **********SETTERS**********

    public function setnombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setapellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setnrodoc($nrodoc)
    {
        $this->nrodoc = $nrodoc;
    }

    public function settelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    //! ******** __toString *********

    public function __toString()
    {

        return "Nombre: " . $this->getnombre() . "\n" .
            "Apellido: " . $this->getapellido() . "\n" .
            "DNI: " . $this->getnrodoc() . "\n" .
            "Teléfono: " . $this->gettelefono() . "\n";
    }
}
