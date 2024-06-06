<?php

class ResponsableV
{

    //!ATRIBUTOS

    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;

    //!CONSTRUCTOR

    public function __construct($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido)
    {
        $this->rnumeroempleado = $rnumeroempleado;
        $this->rnumerolicencia = $rnumerolicencia;
        $this->rnombre = $rnombre;
        $this->rapellido = $rapellido;
    }

    //! ************GETTERS**************

    public function getrnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function getrnumerolicencia()
    {
        return $this->rnumerolicencia;
    }

    public function getrnombre()
    {
        return $this->rnombre;
    }

    public function getrapellido()
    {
        return $this->rapellido;
    }


    //! ************SETTERS**************

    public function setrnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setrnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;
    }

    public function setrnombre($rnombre)
    {
        $this->rnombre = $rnombre;
    }

    public function setrapellido($rapellido)
    {
        $this->rapellido = $rapellido;
    }

    //! ************ __toString() ************

    public function __toString()
    {
        return "Numero de Empleado: " . $this->getrnumeroempleado() . "\n" .
            "Numero de Licencia: " . $this->getrnumerolicencia() . "\n" .
            "Nombre: " . $this->getrnombre() . "\n" .
            "Apellido: " . $this->getrapellido() . "\n";
    }
}
