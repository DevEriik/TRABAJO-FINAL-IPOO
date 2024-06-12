<?php

class ResponsableV extends Persona
{

    //!ATRIBUTOS

    private $rnumeroEmpleado;
    private $rnumeroLicencia;

    //!CONSTRUCTOR

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroEmpleado = 0;
        $this->rnumeroLicencia = 0;
    }

	//! ******** Creo la funcion cargar ******** 
    public function cargar($NroD, $Nom, $Ape, $telefono, $rnumeroEmpleado = null, $rnumeroLicencia = null){	
		parent::cargar($NroD, $Nom, $Ape, $telefono);
		$this->setRnumeroEmpleado($rnumeroEmpleado);
		$this->setRnumeroLicencia($rnumeroLicencia);
    }

    //! ************GETTERS**************
    //Obtiene el valor de rnumeroEmpleado
    public function getRnumeroEmpleado()
    {
        return $this->rnumeroEmpleado;
    }

    //Obtiene el valor de rnumeroEmpleado
    public function getRnumeroLicencia()
    {
        return $this->rnumeroLicencia;
    }


    //! ************SETTERS**************
    //Setea el valor de rnumeroEmpleado
    public function setRnumeroEmpleado($rnumeroEmpleado)
    {
        $this->rnumeroEmpleado = $rnumeroEmpleado;
    }

    //Setea el valor de rnumeroLicencia
    public function setRnumeroLicencia($rnumeroLicencia)
    {
        $this->rnumeroLicencia = $rnumeroLicencia;
    }


    //! ************ __toString() ************

    public function __toString()
    {
        $msjToString = parent:: __toString();
        $msjToString .= "Número de Empleado: " . $this->getRnumeroEmpleado() . "\n" .
            "Número de Licencia: " . $this->getRnumeroLicencia() . "\n";
            return $msjToString;
    }


	//! ********* BUSCAR *********
    /**
	 * Recupera los datos de un Responsable por medio de su numero de empleado que se ingresa como parametro.
	 * Retorna true en caso de encontrar los datos, false en caso contrario.
	 * @param INT $nroEmpleado
	 * @return BOOLEAN $resp 
	 */		
    public function Buscar($dni){
		$base = new BaseDatos();
		$consulta = "Select * from responsable where nrodoc = ".$dni;
		$resp = false;

		//Si se conecta a la base de datos
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){
				if($row2 = $base->Registro()){	
				    parent::Buscar($dni);
				    parent::setNrodoc($row2['nrodoc']);
					$resp= true;
				}				
		 	}else{
		 		$this->setMensajeoperacion($base->getError());
			}

		}else{ //Si no se conecta a la base de datos
			$this->setMensajeOperacion($base->getError());
		}		
		return $resp;
    }


    //! ******** LISTAR ******** 
    /**
	 * Lista los datos de todos los empleados por medio de una consulta ingresada como parametro.
	 * Retorna un array con los datos obtenidos, si no encuentra nada retorna un array vacio.
	 * @param STRING $condicion
	 * @return ARRAY $arreglo 
	 */		
	public function listar($condicion = ""){
		//Inicializo variables
		$arreglo = null;
		$base = new BaseDatos();

		//Asigno valor a la consulta y la trabajo con la condicional if
		$consulta = "SELECT * FROM responsable ";		//! Pusimos select * from pasajero pero no sabemos si es SELECT * FROM pasajero 

		if ($condicion != ""){
			$consulta = $consulta.' where '.$condicion;
		}

		//
		$consulta .= " order by numeroEmpleado "; //! COMO LO ORDENAMOS? 

		//Si se conecta a la base de datos
		if($base->Iniciar()){

			//Si se ejecuta la consulta
			if($base->Ejecutar($consulta)){				
				$arreglo = array();

				//
				while($row2 = $base->Registro()){
					$obj = new ResponsableV();
					$obj->Buscar($row2['rnumeroempleado']); //! No entiendo esta linea
					//Agrego el responsable al array
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
	 * Inserta un nuevo empleado a la coleccion de empleados.
	 * Retorna true si pudo insertarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
	public function insertar(){
		//Inicializo variables
		$base = new BaseDatos();
		$resp = false;
		
		//
		if(parent::insertar()){
		    $consultaInsertar="INSERT INTO responsable (numerolicencia, nrodocumento)
				VALUES ('".$this->getRnumeroLicencia()."','".$this->getNrodoc()."')";

		//Si se conecta a la base de datos
        if($base->Iniciar()){

			//Si se ejecuta la consulta
		        if($base->Ejecutar($consultaInsertar)){
		            $resp=  true;

		        }else{ //Si no se ejecuta la consulta 
		            $this->setMensajeoperacion($base->getError());
		        }

		    }else{ //Si no se conecta a la base de datos
		        $this->setMensajeoperacion($base->getError());
		    }
		}
		return $resp;
    }


    //! ******** MODIFICAR ******** 
	/**
	 * Modifica un empleado de la coleccion de empleados.
	 * Retorna true si pudo modificarla y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE responsable SET apellido = '" . parent::getApellido() . "', nombre = '" . parent::getNombre() . "',nrodoc = " . parent::getNrodoc(). ", telefono = " . parent::getTelefono() . ", N° de empleado = ".$this->getRnumeroEmpleado().", rnumerolicencia = ".$this->getRnumeroLicencia()." WHERE nrodoc = " . parent::getNrodoc(); //! Ver esto con los nombres de las columnas de la tabla********************

        //Si se conecta a la base de datos 
        if ($base->Iniciar()){

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
	 * Elimina un empleado a la coleccion de empleados.
	 * Retorna true si pudo eliminarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function eliminar()
    {
		//Inicializo variables
		$base = new BaseDatos();
		$resp = false;

		//Si se conecta a la base de datos
		if($base->Iniciar()){
			$consultaBorra = "DELETE FROM responsable WHERE rnumeroEmpleado = ".$this->getRnumeroEmpleado();

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
