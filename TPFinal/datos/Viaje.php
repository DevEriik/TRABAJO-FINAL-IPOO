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
    private $mensajeoperacion;

    //!CONSTRUCTOR

    public function __construct()
    {
        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = 0;
        $this->idempresa = 0;
        $this->rnumeroempleado = 0;
        $this->vimporte = 0;
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

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
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

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
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


    /**
     * Recupera los datos de una persona por dni
     * @param int $dni
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($idviaje)
    {
        $base = new BaseDatos();
        $consultaPersona = "Select * from persona where idviaje=" . $idviaje;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setidviaje($row2['idviaje']);
                    $this->setvdestino($row2['vdestino']);
                    $this->setvcantmaxpasajeros($row2['vcantmaxpasajeros']);
                    $this->setidempresa($row2['idempresa']);
                    $this->setrnumeroempleado($row2['rnumeroempleado']);
                    $this->setvimporte($row2['vimporte']);
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
		$base=new BaseDatos();
		$consultaViaje="Select * from persona ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by destino ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
				    $idviaje=$row2['idviaje'];
					$destino=$row2['destino'];
                    $cantMaxPasajeros=$row2['cantidad maxima'];
					$idempresa=$row2['idempresa'];
					$numeroempleado=$row2['numero empleado'];
                    $importe=$row2['importe'];
				
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
        $consultaInsertar = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
				VALUES (" . $this->getidviaje() . ",'" . $this->getvdestino() . "','" . $this->getvcantmaxpasajeros() . "','" . $this->getidempresa() . "','" . $this->getrnumeroempleado() . "','" . $this->getvimporte() . "')";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->getidviaje($id);
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
        $this->setidempresa($idempresa);
        $this->setrnumeroempleado($rnumeroempleado);
        $this->setvimporte($vimporte);
    }

}