<?php

class Empresa
{

    //!ATRIBUTOS

    private $idempresa;
    private $enombre;
    private $edireccion;

    //!CONSTRUCTOR

    public function __construct()
    {
        $this->idempresa = 0;
        $this->enombre = "";
        $this->edireccion = "";
    }

    public function cargar($IdEmpresa, $ENombre, $EDireccion)
    {
        $this->setidempresa($IdEmpresa);
        $this->setenombre($ENombre);
        $this->setedireccion($EDireccion);
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


    public function listar($condicion = "")
    {
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresa = "Select * from empresa ";
        if ($condicion != "") {
            $consultaEmpresa = $consultaEmpresa . ' where ' . $condicion;
        }
        $consultaEmpresa .= " order by apellido "; //!NOSE QUE VA EN ESTA PARTE DEL apellido PERO EN EMPRESA (EL enombre?)
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresa)) {
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {
                    $IdEmpresa = $row2['idempresa'];
                    $ENombre = $row2['enombre'];
                    $EDireccion = $row2['edireccion'];

                    $empre = new Empresa();
                    $empre->cargar($IdEmpresa, $ENombre, $EDireccion);
                    array_push($arregloEmpresa, $empre);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloEmpresa;
    }


    
}
