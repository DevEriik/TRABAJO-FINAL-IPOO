<?php

class Viaje
{

    //!ATRIBUTOS
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;

    //!CONSTRUCTOR

    public function __construct($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte)
    {
        $this->idviaje = $idviaje;
        $this->vdestino = $vdestino;
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
        $this->idempresa = $idempresa;
        $this->rnumeroempleado = $rnumeroempleado;
        $this->vimporte = $vimporte;
    }

    //! **********GETTERS************

    public function getidviaje()
    {
        return $this->idviaje;
    }

    public function getvdestino()
    {
        return $this->vdestino;
    }

    public function getvcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getidempresa()
    {
        return $this->idempresa;
    }

    public function getrnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function getvimporte()
    {
        return $this->vimporte;
    }

    //! **********SETTERS*************

    public function setidviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    public function setvdestino($vdestino)
    {
        $this->vdestino = $vdestino;
    }

    public function setvcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function setidempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function setrnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setvimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    //! *********** __toString() ************

    public function __toString()
    {
        return "ID Viaje: " . $this->getidviaje() . "\n" .
            "Destino: " . $this->getvdestino() . "\n" .
            "Cant. Max. Pasajeros: " . $this->getvcantmaxpasajeros() . "\n" .
            "ID Empresa: " . $this->getidempresa() . "\n" .
            "ID Empleado: " . $this->getrnumeroempleado() . "\n" .
            "Importe: " . $this->getvimporte() . "\n";
    }



    //! ************** METODOS DE MySql ***************

}
