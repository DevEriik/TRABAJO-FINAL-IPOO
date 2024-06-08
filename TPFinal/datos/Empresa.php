<?php

class Empresa
{

    //!ATRIBUTOS

    private $idempresa;
    private $enombre;
    private $edireccion;

    //!CONSTRUCTOR

    public function __construct($idempresa, $enombre, $edireccion)
    {
        $this->idempresa = $idempresa;
        $this->enombre = $enombre;
        $this->edireccion = $edireccion;
    }

    //! ************GETTERS*************

    public function getidempresa()
    {
        return $this->idempresa;
    }

    public function getenombre()
    {
        return $this->enombre;
    }

    public function getedireccion()
    {
        return $this->edireccion;
    }

    //! ************SETTERS*************

    public function setenombre($enombre)
    {
        $this->enombre = $enombre;
    }

    public function setedireccion($edireccion)
    {
        $this->edireccion = $edireccion;
    }

    public function setidempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    //! ************* __toString() *****************

    public function __toString()
    {
        return "ID Empresa: " . $this->getidempresa() . "\n" .
            "Nombre: " . $this->getenombre() . "\n" .
            "Dirección: " . $this->getedireccion() . "\n";
    }



    //! ************** METODOS DE MySql ***************

    /**
     * Recupera los datos de una persona por dni
     * @param int $dni
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($idempresa)
    {
        $base = new BaseDatos();
        $consultaPersona = "Select * from persona where idempresa=" . $idempresa;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setidempresa($idempresa);
                    $this->setenombre($row2['enombre']);
                    $this->setedireccion($row2['edireccion']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }



    
}
