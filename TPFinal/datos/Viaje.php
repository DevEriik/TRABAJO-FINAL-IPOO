<?php


class Viaje
{

    //!ATRIBUTOS
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objIdEmpresa;
    private $objResponsableV;
    private $vimporte;
    private $colPasajeros; //!AGREGUE ESTE ATRIBUTO, TENEMOS QUE AGREGARLO EN LOS METODOS REALIZADOS.
    private $mensajeoperacion;

    //!CONSTRUCTOR

    public function __construct()
    {
        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = 0;
        $this->objIdEmpresa = new Empresa(); 
        $this->objResponsableV = new ResponsableV(); 
        $this->vimporte = 0;
        $this->colPasajeros = [];
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

    public function getobjIdEmpresa()
    {
        return $this->objIdEmpresa;
    }

    public function getobjResponsableV()
    {
        return $this->objResponsableV;
    }

    public function getvimporte()
    {
        return $this->vimporte;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function getcolPasajeros()
    {
        return $this->colPasajeros;
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

    public function setobjIdEmpresa($objIdEmpresa)
    {
        $this->objIdEmpresa = $objIdEmpresa;
    }

    public function setobjResponsableV($objResponsableV)
    {
        $this->objResponsableV = $objResponsableV;
    }

    public function setvimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function setcolPasajeros($colPasajeros)
    {
        $this->colPasajeros = $colPasajeros;
    }

    //! *********** __toString() ************

    public function __toString()
    {
        return "ID Viaje: " . $this->getidviaje() . "\n" .
            "Destino: " . $this->getvdestino() . "\n" .
            "Cant. Max. Pasajeros: " . $this->getvcantmaxpasajeros() . "\n" .
            "ID Empresa: " . $this->getobjIdEmpresa() . "\n" .
            "ID Empleado: " . $this->getobjResponsableV() . "\n" .
            "Importe: " . $this->getvimporte() . "\n" . 
            "Pasajeros: " . $this->getcolPasajeros() . "\n";
    }



    //! ************** METODOS DE MySql ***************


    /**
     * Recupera los datos de una persona por dni
     * @param int $dni
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($idviaje)
    {
        $base = new BaseDatos();
        $consultaIdViajeIngresado = "Select * from viaje where idviaje=" . $idviaje;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaIdViajeIngresado)) {
                if ($row2 = $base->Registro()) {

                    //*Listo el viaje
                    $this->setidviaje($idviaje);
                    $this->setvdestino($row2['vdestino']);
                    $this->setvcantmaxpasajeros($row2['vcantmaxpasajeros']);
                    //*Listo la Empresa
                    $newObjEmpresa = new Empresa();
                    $newObjEmpresa->Buscar($row2['idempresa']);
                    $this->setobjIdEmpresa($newObjEmpresa);
                    //*Listo el responsableV
                    $newObjResponsableV = new ResponsableV();
                    $newObjResponsableV->Buscar($row2['rnumeroempleado']);
                    $this->setobjResponsableV($newObjResponsableV);
                    $this->setvimporte($row2['vimporte']);
                    //*Listo el pasajero
                    $newObjPasajero = new Pasajero();
                    $arregloPasajero = $newObjPasajero->listar("idviaje=" . $idviaje);
                    $this->setcolPasajeros($arregloPasajero);
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

    public static function listar($condicion=""){
	    $arregloViaje = null;
		$base = new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
				    $idviaje=$row2['idviaje'];
					$destino=$row2['vdestino'];
                    $cantMaxPasajeros=$row2['vcantmaxpasajeros'];
					$idempresa=$row2['idempresa'];
					$numeroempleado=$row2['rnumeroempleado'];
                    $importe=$row2['vimporte'];
				
					$viaj=new Viaje();
					$viaj->cargar($idviaje,$destino,$cantMaxPasajeros,$idempresa,$numeroempleado,$importe);
					array_push($arregloViaje,$viaj);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}	


    /**
     * Metodo insertar
     */

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
				VALUES (" . $this->getvdestino() . "','" . $this->getvcantmaxpasajeros() . "','" . $this->getobjIdEmpresa() . "','" . $this->getobjResponsableV() . "','" . $this->getvimporte() . "');";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setidviaje($id);
                $resp = true;

            } else {
                $this->setmensajeoperacion($base->getError());

            }

        } else {
            $this->setmensajeoperacion($base->getError());

        }
        return $resp;
    }


    //! ******** MODIFICAR ******** 
    /**
	 * Modifica una persona de la coleccion de personas.
	 * Retorna true si pudo modificarla y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getvdestino() . "',vcantmaxpasajeros='" . $this->getvcantmaxpasajeros() . "',idempresa=" . $this->getobjIdEmpresa()->getidempresa(). ",rnumeroempleado=" . $this->getobjResponsableV()->getrnumeroempleado() . " WHERE idviaje=" . $this->getidviaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /** 
     * Metodo para Eliminar
     */
    
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getidviaje();
            if ($base->Ejecutar($consultaBorra)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());

            }
        } else {
            $this->setmensajeoperacion($base->getError());

        }
        return $resp;
    }

    /**
     * Metodo para cargar viaje
     */
    public function cargar($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte)
    {
        $this->setidviaje($idviaje);
        $this->setvdestino($vdestino);
        $this->setvcantmaxpasajeros($vcantmaxpasajeros);
        $this->setobjIdEmpresa($idempresa);
        $this->setobjResponsableV($rnumeroempleado);
        $this->setvimporte($vimporte);
    }

}