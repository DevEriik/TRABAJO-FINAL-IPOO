<?php

class Empresa
{

    //! ************* ATRIBUTOS *************

    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    private $mensajeOperacion;


    //! ************ CONSTRUCTOR *************
    public function __construct()
    {
        $this->idEmpresa = 0;
        $this->eNombre = "";
        $this->eDireccion = "";
    }


    //! ************ CARGAR *************
    public function cargar($IdEmpresa, $ENombre, $EDireccion)
    {
        $this->setIdEmpresa($IdEmpresa);
        $this->setENombre($ENombre);
        $this->setEDireccion($EDireccion);
    }

    //! ************ GETTERS *************
    //Obtiene los datos de idEmpresa
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    //Obtiene los datos de eNombre
    public function getENombre()
    {
        return $this->eNombre;
    }

    //Obtiene los datos de eDireccion
    public function getEDireccion()
    {
        return $this->eDireccion;
    }

    //Obtiene los datos de mensajeOperacion
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }


    //! ************SETTERS*************
    //Setea los datos de idEmpresa
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    //Setea los datos de eNombre
    public function setENombre($eNombre)
    {
        $this->eNombre = $eNombre;
    }

    //Setea los datos de eDireccion
    public function setEDireccion($eDireccion)
    {
        $this->eDireccion = $eDireccion;
    }

    //Setea los datos de mensajeOperacion
    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }


    //! ************* __toString() *****************

    public function __toString()
    {
        $msjToString = "ID Empresa: " . $this->getIdEmpresa() . "\n" .
            "Nombre: " . $this->getENombre() . "\n" .
            "Dirección: " . $this->getEDireccion() . "\n";
        return $msjToString;
    }



    //! ************** BUSCAR - METODOS DE MySql ***************

    /**
     * Recupera datos de una empresa por id.
     * Retorna true en caso de encontrar los datos, false en caso contrario.
     * @param INT $idEmpresa
     * @return BOOLEAN $resp
     */
    public function Buscar($idEmpresa)
    {
        $base = new BaseDatos();
        $consultaPersona = "Select * from persona where idEmpresa = " . $idEmpresa;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdEmpresa($idEmpresa);
                    $this->setENombre($row2['eNombre']);
                    $this->setEDireccion($row2['eDireccion']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }


    /**
     * Lista grupo de registros, retorna colección de ellos
     * Retorna array vacio en caso de no encontrar nada.
     * @param STRING $consulta
     * @return ARRAY $arregloEmpresa
     */
    public function listar($condicion = "")
    {
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresa = "Select * from empresa ";
        if ($condicion != "") {
            $consultaEmpresa = $consultaEmpresa . ' where ' . $condicion;
        }
        $consultaEmpresa .= " order by enombre ";
        
        //Si se conecta a la base de datos
        if ($base->Iniciar()){

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaEmpresa)) {
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {
                    $IdEmpresa = $row2['idEmpresa'];
                    $ENombre = $row2['eNombre'];
                    $EDireccion = $row2['eDireccion'];

                    $empre = new Empresa();
                    $empre->cargar($IdEmpresa, $ENombre, $EDireccion);
                    array_push($arregloEmpresa, $empre);
                }

            }else{ //Si no se ejecuta la consulta 
                $this->setMensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloEmpresa;
    }


    /**
     * Inserta datos de una empresa a la base de datos.
     * Retorna true si la inserción fue exitosa, false en caso contrario.
     * @return BOOLEAN $resp
     */
    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa(idEmpresa, eNombre, eDireccion)
				VALUES (" . $this->getIdEmpresa() . ",'" . $this->getENombre() . "' . '" . $this->getEDireccion() . "')";

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdEmpresa($id);
                $resp = true;

            }else{ //Si no se ejecuta la consulta 
                $this->setMensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }


	//! ******** MODIFICAR ******** 
    /**
     * Modifica datos de algún registro
     * Retorna true en caso de que la actualización haya sido exitosa, false en caso contrario
     * @return BOOLEAN $resp
     */
    public function modificar()
    {
        //Inicializo variables
        $resp = false;
        $base = new BaseDatos();

        $consultaModifica = "UPDATE empresa SET idEmpresa = '" . $this->getIdEmpresa() . "', eNombre = '" . $this->getENombre() . "', eDireccion = " . $this->getEDireccion() . " WHERE idEmpresa = " . $this->getIdEmpresa();

        //Si se conecta a la base de datos
        if ($base->Iniciar()){

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaModifica)){
                $resp = true;

            }else{ //Si no se ejecuta la consulta 
                $this->setMensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }


	//! ******** ELIMINAR ******** 
    /**
	 * Elimina el registro de una empresa de la coleccion de empresas.
	 * Retorna true si pudo eliminarlo y false en caso contrario.
	 * @return BOOLEAN $resp 
	 */		
    public function eliminar()
    {
        //Inicializo variables
        $base = new BaseDatos();
        $resp = false;

        //Si se conecta a la base de datos
        if ($base->Iniciar()){
            $consultaBorra = "DELETE FROM empresa WHERE idEmpresa = " . $this->getIdEmpresa();

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaBorra)) {
                $resp = true;

            }else{ //Si no se ejecuta la consulta 
                $this->setMensajeOperacion($base->getError());
            }

        }else{ //Si no se conecta a la base de datos
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }
}
