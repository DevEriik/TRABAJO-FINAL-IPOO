<?php

class ResponsableV extends Persona
{

    //!ATRIBUTOS

    private $rnumeroempleado;
    private $rnumerolicencia;

    //!CONSTRUCTOR

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroempleado = 0;
        $this->rnumerolicencia = 0;
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



    //! ************SETTERS**************

    public function setrnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setrnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;
    }


    //! ************ __toString() ************

    public function __toString()
    {
        return "Numero de Empleado: " . $this->getrnumeroempleado() . "\n" .
            "Numero de Licencia: " . $this->getrnumerolicencia() . "\n" ;
    }
}
