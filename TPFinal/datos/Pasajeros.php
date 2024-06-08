<?php
/*
TODO: N° de linea aproximado --> Falla que veo --> Linea original para saber cual es si es que no esta en la misma linea

? Lineas 45 y 64 --> Error con getter y setter de mensajeOperacion

? Linea 107 --> No se bien si eso está bien --> @param STRING $condicion

? Linea 115 --> Esta duda la teniamos que consultar --> $consulta = "select * from pasajero "; //Pusimos select * from pasajero pero no sabemos si es SELECT * FROM pasajero 

? Linea 138 --> Está para probar supongo, cuando no se necesite mas hay que sacarlo --> //echo $consultaPersonas;

? Lineas 91, 136, 174, 200  --> Comentarios que no estoy 100% seguro de que sea eso lo que hace --> //Si se conecta a la base de datos

? Lineas 94, 139, 177, 203 --> Comentarios que no estoy 100% seguro de que sea eso lo que hace --> //Si se ejecuta la consulta


? Linea 215 --> Falta el metodo modificar
*/

//! ******** CREO LA CLASE ******** 
class Pasajero extends Persona
{

	//! ******** ATRIBUTOS ******** 
    private $idViaje;
    private $telefono;

    //! ******** CONSTRUCTOR ******** 
    public function __construct()
    {
        parent::__construct();
        $this->idViaje = 0;
        $this->telefono = 0;
    }

	//! ******** Creo la funcion cargar ******** 
    public function cargar($NroD, $Nom, $Ape, $idViaje = null, $telefono = null){	
		parent::cargar($NroD, $Nom, $Ape);
		$this->setIdViaje($idViaje);
        $this->setTelefono($telefono);
    }


    //! ********** SETTERS **********
    //Setea el valor de idViaje
    public function setIdViaje($id)
    {
        $this->idViaje = $id;
    }

    //Setea el valor de telefono
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    //Setea el valor de mensajeOperacion
    public function setMensajeOperacion($mensajeOperacion){
		$this->mensajeOperacion = $mensajeOperacion;
	}


    //! ********** GETTERS *************
	//Obtiene el valor de telefono
    public function getTelefono()
    {
        return $this->telefono;
    }

	//Obtiene el valor de idViaje
    public function getIdViaje()
    {
        return $this->idViaje;
    }

    //Obtiene el valor de mensajeOperacion
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }


    //! ******** __toString *********
    public function __toString()
    {
        $cadena= parent:: __toString() . "\n";
        $cadena.="ID viaje: " . $this->getIdViaje(). "\n";
        $cadena.="Teléfono: " . $this->getTelefono() . "\n";
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
		$consulta = "Select * from estudiante where nrodoc = ".$dni;
		$resp = false;

		//Si se conecta a la base de datos
		if($base->Iniciar()){

			//Si se ejecuta la consulta
			if($base->Ejecutar($consulta)){

				//
				if($row2 = $base->Registro()){	
					parent::Buscar($dni);
					$this->setIdViaje($row2['idviaje']);
                    $this->setTelefono($row2['ptelefono']);
					$resp = true;
				}	

			}else{ //Si no se ejecuta la consulta
				$this->setMensajeOperacion($base->getError());
			}

		}else{ //Si no se conecta a la base de datos
			$this->setMensajeOperacion($base->getError());
		}		
		return $resp;
	}


    //! ******** LISTAR ******** 
    /**
	 * Lista los datos de todos los pasajeros por medio de una consulta ingresada como parametro.
	 * Retorna un array con los datos obtenidos.
	 * @param STRING $condicion
	 * @return ARRAY $arreglo 
	 */		
	public static function listar($condicion = ""){
		//Inicializo variables
		$arreglo = null;
		$base = new BaseDatos();

		//Asigno valor a la consulta y la trabajo con la condicional if
		$consulta = "select * from pasajero ";
		/*
		TODO: Pusimos select * from pasajero pero no sabemos si es SELECT * FROM pasajero 
		*/

		if ($condicion != ""){
			$consulta = $consulta.' where '.$condicion;
		}

		//
		$consulta .= " order by apellido ";

		//echo $consultaPersonas;
		//Si se conecta a la base de datos
		if($base->Iniciar()){

			//Si se ejecuta la consulta
			if($base->Ejecutar($consulta)){				
				$arreglo = array();

				//
				while($row2 = $base->Registro()){
					$obj = new Pasajero();
					$obj->Buscar($row2['nrodoc']);
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
			$consultaInsertar="INSERT INTO pasajero(nroDoc, idviaje, telefono)
				VALUES (".parent::getNrodoc().", ".$this->getIdViaje().", '".$this->getTelefono()."')";

			//Si se conecta a la base de datos
			if($base->Iniciar()){

				//Si se ejecuta la consulta
				if($base->Ejecutar($consultaInsertar)){
					$resp=  true;

				}else{ //Si no puede ejecutar la consulta
					$this->setMensajeOperacion($base->getError());
				}

			}else{ //Si no puede conectarse a la base de datos
				$this->setMensajeOperacion($base->getError());
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