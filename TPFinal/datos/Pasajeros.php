<?php

//! ******** CREO LA CLASE ******** 
class Pasajero extends Persona
{

	//! ******** ATRIBUTOS ******** 
	private $idPasajero;
    private $idViaje;
	private $mensajeoperacion;


    //!CONSTRUCTOR
    public function __construct()
    {
        parent::__construct();
		$this->idPasajero =    0;
        $this->idViaje =    0;
    }

	//! ******** Creo la funcion cargar ******** 
    public function cargar($idPerso = null ,$NroD, $Nom, $Ape, $telefono, $idViaje = null,$idPasajero = null){	
		parent::cargar($idPerso,$NroD, $Nom, $Ape, $telefono);
		$this->setIdPasajero($idPasajero);
		$this->setIdViaje($idViaje);
    }

    //! **********GETTERS*************
    public function getIdViaje()
    {
        return $this->idViaje;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
	public function getIPasajero()
    {
        return $this->idPasajero;
    }

    //! **********SETTERS**********
    public function setIdViaje($id)
    {
        $this->idViaje=$id;
    }

	public function setIdPasajero($id){
		$this->idPasajero=$id;
	}


    public function setMensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    //! ******** __toString *********
    public function __toString()
    {
        $cadena= parent:: __toString() . "\n";
        $cadena.="ID viaje: " . $this->getIdViaje(). "\n";
        return $cadena;
    }


	//! ********* BUSCAR *********
    /**
	 * Recupera los datos de un Pasajero por medio de su numero de dni que se ingresa como parametro.
	 * Retorna true en caso de encontrar los datos, false en caso contrario.
	 * @param INT $dni
	 * @return BOOLEAN $resp 
	 */		
    public function Buscar($dni){
		$base = new BaseDatos();
		$consulta = "SELECT * from pasajero where nrodocumento = ".$dni;
		$resp = false;

		//Si se conecta a la base de datos
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){	
				    parent::Buscar($dni);
					
				    $this->setIdViaje($row2['idviaje']);
					$resp= true;
				}				
		 	}else{ //Si no se ejecuta la consulta
		 		$this->setMensajeoperacion($base->getError());
			}

		}else{ //Si no se conecta a la base de datos
			$this->setMensajeOperacion($base->getError());
		}		
		return $resp;
	}


    //! ******** LISTAR ******** 
    /**
	 * Lista los datos de todos los pasajeros por medio de una consulta ingresada como parametro.
	 * Retorna un array con los datos obtenidos, si no encuentra nada retorna un array vacio.
	 * @param STRING $condicion
	 * @return ARRAY $arreglo 
	 */		
	public function listar($condicion = ""){
		//Inicializo variables
		$arreglo = null;
		$base = new BaseDatos();

		//Asigno valor a la consulta y la trabajo con la condicional if
		$consulta = "select * from pasajero ";

		if ($condicion != ""){
			$consulta = $consulta.' where '.$condicion;
		}

		//
		$consulta .= " order by idpasajero ";

		//echo $consultaPersonas;
		//Si se conecta a la base de datos
		if($base->Iniciar()){

			//Si se ejecuta la consulta
			if($base->Ejecutar($consulta)){				
				$arreglo = array();

				//
				while($row2 = $base->Registro()){
					$obj = new Pasajero();
					$obj->Buscar($row2['idpersona']);
					//Agrego el pasajero al array
					array_push($arreglo,$obj);
				}

			}else{ //Si no se ejecuta la consulta
				$this->setMensajeOperacion($base->getError());
			}

		}else{ //Si no se conecta a la base de datos
			$this->setMensajeOperacion($base->getError());
		}
		return $arreglo;
	}


    //! ******** INSERTAR ******** 
    /**
	 * Inserta un nuevo pasajero a la coleccion de pasajeros.
	 * Retorna true si pudo insertarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
	public function insertar(){
		//Inicializo variables
		$base = new BaseDatos();
		$resp = false;
		
		//
		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO pasajero(nroDoc, idviaje)
				VALUES (".parent::getNrodoc().",".$this->getIdViaje().",')";
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


    //! ******** MODIFICAR ******** 
	/**
	 * Modifica un pasajero de la coleccion de pasajeros.
	 * Retorna true si pudo modificarla y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE pasajero SET apellido = '" . parent::getApellido() . "', nombre = '" . parent::getNombre() . "', nrodoc = " . parent::getNrodoc(). ", telefono = " . parent::getTelefono() . ", ID Viaje = ".$this->getIdViaje()." WHERE nrodoc = " . parent::getNrodoc(); //! Ver esto

        //Si se conecta a la base de datos 
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;

            }else{ //Si no se ejecuta la consulta 
                $this->setmensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setmensajeOperacion($base->getError());
        }
        return $resp;
	}


	//! ******** ELIMINAR ******** 
    /**
	 * Elimina un pasajero a la coleccion de pasajeros.
	 * Retorna true si pudo eliminarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function eliminar(){
		//Inicializo variables
		$base = new BaseDatos();
		$resp = false;

		//Si se conecta a la base de datos
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM pasajero WHERE nrodoc = ".parent::getNrodoc();

			//Si se ejecuta la consulta
			if($base->Ejecutar($consultaBorra)){
				if(parent::eliminar()){
					$resp = true;
				}

			}else{ //Si no puede ejecutar la consulta
				$this->setMensajeOperacion($base->getError());
			}

		}else{ //Si no puede conectarse a la base de datos
			$this->setMensajeOperacion($base->getError());
		}
		return $resp; 
	}
}