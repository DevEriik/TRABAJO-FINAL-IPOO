<?php
/*
? Mismos cambios que en pasajeros

? funcion cargar --> me molestan las variables que comienzan con mayusculas, hay que consultar, porque estaban así en lo que mandaron de ejemplo. Ademas, se usan con mayusculas en los setter pero no en el __construct ni en los getters
*/
//! ******** CREO LA CLASE ******** 
class Persona
{
	//! ******** ATRIBUTOS ******** 
    private $nrodoc;
    private $nombre;
    private $apellido;
    private $telefono;
    private $mensajeoperacion;

    //! ******** CONSTRUCTOR ******** 
    public function __construct()
    {
        $this->nrodoc = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = 0;
        $this->mensajeoperacion = "";
    }

    public function cargar($NroD, $Nom, $Ape, $Tel)
    {
        $this->setNrodoc($NroD);
        $this->setNombre($Nom);
        $this->setApellido($Ape);
        $this->setTelefono($Tel);
    }


    //! ********** SETTERS *************
	//Setea el valor de NroDNI
    public function setNrodoc($NroDNI)
    {
        $this->nrodoc = $NroDNI;
    }

	//Setea el valor de Nom
    public function setNombre($Nom)
    {
        $this->nombre = $Nom;
    }

	//Setea el valor de Ape
    public function setApellido($Ape)
    {
        $this->apellido = $Ape;
    }

	//Setea el valor de mensajeOperacion
    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function setTelefono($Tel)
    {
        $this->telefono = $Tel;
    }

    public function getNrodoc()
    {
        return $this->nrodoc;
    }

	//Obtiene el valor de nombre
    public function getNombre()
    {
        return $this->nombre;
    }

	//Obtiene el valor de apellido
    public function getApellido()
    {
        return $this->apellido;
    }

	//Obtiene el valor de mensajeOperacion
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }



    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Recupera los datos de una persona por dni
     * @param int $dni
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($dni)
    {
        $base = new BaseDatos();
        $consultaPersona = "Select * from persona where nrodoc = " . $dni;
        $resp = false;

        //Si se conecta a la base de datos
        if ($base->Iniciar()){

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaPersona)){

                //
                if ($row2 = $base->Registro()) {
                    $this->setNrodoc($dni);
                    $this->setNombre($row2['nombre']);
                    $this->setApellido($row2['apellido']);
                    $this->setTelefono($row2['telefono']); //!VER COMO SE AGREGO EN LA BASE DE DATOS EL NOMBRE DE LA COLUMNA.
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


    //! ******** LISTAR ******** 
    /**
	 * Lista los datos de todas las personas por medio de una consulta ingresada como parametro.
	 * Retorna un array con los datos obtenidos.
	 * @param STRING $condicion
	 * @return ARRAY $arregloPersona 
	 */		
    public function listar($condicion = "")
    {
        //Inicializo variables
        $arregloPersona = null;
        $base = new BaseDatos();

        //Asigno valor a la consulta y la trabajo con la condicional if
        $consultaPersonas = "Select * from persona ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' where ' . $condicion;
        }

        //
        $consultaPersonas .= " order by apellido ";

        //echo $consultaPersonas;
        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaPersonas)) {
                $arregloPersona = array();

                //
                while ($row2 = $base->Registro()) {
                    $NroDoc = $row2['nrodoc'];
                    $Nombre = $row2['nombre'];
                    $Apellido = $row2['apellido'];
                    $Telefono = $row2['telefono']; //!VER COMO SE AGREGO EN LA BASE DE DATOS EL NOMBRE DE LA COLUMNA.

                    $perso = new Persona();
                    $perso->cargar($NroDoc, $Nombre, $Apellido, $Telefono);
                    array_push($arregloPersona, $perso);
                }

            }else{ //Si no se ejecuta la consulta
                $this->setMensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPersona;
    }


    //! ******** INSERTAR ******** 
    /**
	 * Inserta una nueva persona a la coleccion de personas.
	 * Retorna true si pudo insertarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function insertar()
    {
        //Inicializo variables
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO persona(nrodoc, apellido, nombre, telefono)
				VALUES (" . $this->getNrodoc() . ",'" . $this->getApellido() . "' . '" . $this->getNombre() . "'," . $this->getTelefono() . "')";

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdPersona($id);  //TODO: ACA DEBERIA DE IR NRODOC?
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
        $consultaModifica = "UPDATE persona SET apellido='" . $this->getApellido() . "',nombre='" . $this->getNombre() . "',nrodoc=" . $this->getNrodoc(). ",telefono=" . $this->getTelefono() . " WHERE nrodoc=" . $this->getNrodoc();
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


    //! ******** ELIMINAR ******** 
    /**
	 * Elimina una persona a la coleccion de personas.
	 * Retorna true si pudo eliminarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;

        //Si se conecta a la base de datos
        if ($base->Iniciar()){
            $consultaBorra = "DELETE FROM persona WHERE nrodoc=" . $this->getNrodoc();

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaBorra)){
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function __toString()
    {
        return "\nNombre: " . $this->getNombre() . "\n Apellido:" . $this->getApellido() . "\n DNI: " . $this->getNrodoc() . "\n" . "Telefono: " . $this->getTelefono();
    }
}
