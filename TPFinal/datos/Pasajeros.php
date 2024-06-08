<?php

class Pasajero extends Persona
{
//LALALALALALALALALLALALALA
    //!ATRIBUTOS
    private $idViaje;
    private $telefono;

    //!CONSTRUCTOR
    public function __construct()
    {
        parent::__construct();
        $this->idViaje =    0;
        $this->telefono = 0;
    }

    public function cargar($NroD, $Nom, $Ape, $idViaje = null, $telefono = null){	
	    parent::cargar($NroD, $Nom, $Ape);
	    $this->setIdViaje($idViaje);
        $this->setTelefono($telefono);
    }

    //! **********GETTERS*************


    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getIdViaje()
    {
        return $this->idViaje;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    //! **********SETTERS**********


    public function setIdViaje($id)
    {
        $this->idViaje=$id;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setMensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    //! ******** __toString *********

    public function __toString()
    {
        $cadena= parent:: __toString() . "\n";
        $cadena.="ID viaje: " . $this->getIdViaje(). "\n";
        $cadena.="Teléfono: " . $this->getTelefono() . "\n";
        return $cadena;
    }

    /**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consulta="Select * from estudiante where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
				    $this->setIdViaje($row2['idviaje']);
                    $this->setTelefono($row2['ptelefono']);
					$resp= true;
				}				
		 	}else{
		 		$this->setMensajeoperacion($base->getError());
			}
		 }else{
		 	$this->setMensajeoperacion($base->getError());
		 }		
		 return $resp;
	}

    public static function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="select * from pasajero ";  //Pusimos select * from pasajero pero no sabemos si es SELECT * FROM pasajero
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by apellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row2['nrodoc']);
					array_push($arreglo,$obj);
				}
		 	}else{
		 		$this->setMensajeoperacion($base->getError());
			}
		 }else{
		 	$this->setMensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		
		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO pasajero(nroDoc, idviaje, telefono)
				VALUES (".parent::getNrodoc().",".$this->getIdViaje().",'".$this->getTelefono()."')";
		    if($base->Iniciar()){
		        if($base->Ejecutar($consultaInsertar)){
		            $resp=  true;
		        }else{
		            $this->setMensajeoperacion($base->getError());
		        }
		    }else{
		        $this->setMensajeoperacion($base->getError());
		    }
		 }
		return $resp;
	}

    /**
     * Metodo para eliminar 
     */

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM pasajero WHERE nrodoc=".parent::getNrodoc();
			if($base->Ejecutar($consultaBorra)){
				if(parent::eliminar()){
				    $resp=  true;
				}
			}else{
				$this->setMensajeoperacion($base->getError());
			}
		}else{
			$this->setMensajeoperacion($base->getError());
		}
		return $resp; 
	}
}
