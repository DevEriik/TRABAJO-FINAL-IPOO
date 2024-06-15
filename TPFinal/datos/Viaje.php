<?php
/*
! HACER FUNCION MOSTRAR PASAJERO
*/

class Viaje
{

    //!ATRIBUTOS
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objIdEmpresa;
    private $objResponsableV;
    private $vimporte;
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
    }


    //! ******** CARGAR ******** 
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


    //! **********GETTERS************

    //Obtiene los datos de idviaje
    public function getidviaje()
    {
        return $this->idviaje;
    }

    //Obtiene los datos de vdestino
    public function getvdestino()
    {
        return $this->vdestino;
    }

    //Obtiene los datos de vcantmaxpasajeros
    public function getvcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    //Obtiene los datos de objIdEmpresa
    public function getobjIdEmpresa()
    {
        return $this->objIdEmpresa;
    }

    //Obtiene los datos de objResponsableV
    public function getobjResponsableV()
    {
        return $this->objResponsableV;
    }

    //Obtiene los datos de vimporte
    public function getvimporte()
    {
        return $this->vimporte;
    }

    //Obtiene los datos de mensajeoperacion
    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }


    //! **********SETTERS*************
    //Setea los datos de idviaje
    public function setidviaje($idviaje)
    {
        $this->idviaje = $idviaje;
    }

    //Setea los datos de vdestino
    public function setvdestino($vdestino)
    {
        $this->vdestino = $vdestino;
    }

    //Setea los datos de vcantmaxpasajeros
    public function setvcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    //Setea los datos de objIdEmpresa
    public function setobjIdEmpresa($objIdEmpresa)
    {
        $this->objIdEmpresa = $objIdEmpresa;
    }

    //Setea los datos de objResponsableV
    public function setobjResponsableV($objResponsableV)
    {
        $this->objResponsableV = $objResponsableV;
    }

    //Setea los datos de vimporte
    public function setvimporte($vimporte)
    {
        $this->vimporte = $vimporte;
    }

    //Setea los datos de mensajeoperacion
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
            "ID Empresa: " . $this->getobjIdEmpresa() . "\n" .
            "Numero Empleado: " . $this->getobjResponsableV() . "\n" .
            "Importe: " . $this->getvimporte() . "\n";
    }



    //! ************** METODOS DE MySql ***************


    //! ******** BUSCAR ******** 
    /**
     * Recupera los datos de un viaje por medio del $idViaje ingresado como parametro.
     * Retorna true en caso de encontrar los datos, false en caso contrario.
     * @param INT $idviaje
     * @return BOOLEAN $resp
     */
    public function Buscar($idviaje)
    {
        //Inicializo variables
        $base = new BaseDatos();
        $consultaIdViajeIngresado = "Select * from viaje where idviaje=" . $idviaje;
        $resp = false;

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
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
                    $newObjResponsableV->Buscar($row2['numeroEmpleado']);
                    $this->setobjResponsableV($newObjResponsableV);
                    $this->setvimporte($row2['vimporte']);
                    $resp = true;
                }
            } else { //Si no se ejecuta la consulta
                $this->setmensajeoperacion($base->getError());
            }
        } else { //Si no se conecta a la base de datos
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    //! ******** LISTAR ******** 
    /**
     * Lista grupo de registros.
     * Retorna la colección de ellos o un array vacio en caso de no encontrar nada.
     * @param STRING $condicion
     * @return ARRAY $arregloEmpresa
     */
    public function listar($condicion = "")
    {
        //Inicializo variables
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje ";
        if ($condicion != "") {
            $consultaViaje = $consultaViaje . ' where ' . $condicion;
        }
        $consultaViaje .= " order by idviaje ";

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaViaje)) {
                $arregloViaje = array();
                while ($row2 = $base->Registro()) {
                    $idviaje = $row2['idviaje'];
                    $destino = $row2['vdestino'];
                    $cantMaxPasajeros = $row2['vcantmaxpasajeros'];
                    $idempresa = $row2['idempresa'];
                    $numeroempleado = $row2['numeroEmpleado'];
                    $importe = $row2['vimporte'];

                    $viaj = new Viaje();
                    $viaj->cargar($idviaje, $destino, $cantMaxPasajeros, $idempresa, $numeroempleado, $importe);
                    array_push($arregloViaje, $viaj);
                }
            } else { //Si no se ejecuta la consulta
                $this->setmensajeoperacion($base->getError());
            }
        } else { //Si no se conecta a la base de datos
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloViaje;
    }


    //! ******** INSERTAR ******** 
    /**
     * Inserta datos de un viaje a la base de datos.
     * Retorna true si la inserción fue exitosa, false en caso contrario.
     * @return BOOLEAN $resp
     */
    public function insertar()
    {
        //Inicializo variables
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, numeroEmpleado, vimporte)
				VALUES ('" . $this->getvdestino() . "','" . $this->getvcantmaxpasajeros() . "','" . $this->getobjIdEmpresa()->getIdEmpresa() . "','" . $this->getobjResponsableV()->getrnumeroempleado() . "','" . $this->getvimporte() . "')";

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setidviaje($id);
                $resp = true;
            } else { //Si no se ejecuta la consulta
                $this->setmensajeoperacion($base->getError());
            }
        } else { //Si no se conecta a la base de datos
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    //! ******** MODIFICAR ******** 
    /**
     * Modifica un viaje de la coleccion de viajes.
     * Retorna true si pudo modificarla y false en caso contrario.
     * @return BOOLEAN $resp 
     */
    public function modificar()
    {
        //Inicializo variables
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje SET vdestino = '" . $this->getvdestino() . "',vcantmaxpasajeros = '" . $this->getvcantmaxpasajeros() . "',idempresa = " . $this->getobjIdEmpresa()->getidempresa() . ",numeroEmpleado = " . $this->getobjResponsableV()->getrnumeroempleado() . ",vimporte = ". $this->getvimporte() ." WHERE idviaje = " . $this->getidviaje();

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {

            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else { //Si no se ejecuta la consulta
                $this->setmensajeoperacion($base->getError());
            }
        } else { //Si no se conecta a la base de datos
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    //! ******** ELIMINAR ******** 
    /**
     * Elimina el registro de un viaje de la coleccion de viajes.
     * Retorna true si pudo eliminarlo y false en caso contrario.
     * @return BOOLEAN $resp 
     */
    public function eliminar()
    {
        //Inicializo variables
        $base = new BaseDatos();
        $resp = false;

        //Si se conecta a la base de datos
        if ($base->Iniciar()) {
            $consultaBorraPasajeros = "DELETE FROM pasajero WHERE idviaje = " . $this->getidviaje();
        
            //Si se ejecuta la consulta
            if ($base->Ejecutar($consultaBorraPasajeros)) {
                $consultaBorra = "DELETE FROM viaje WHERE idviaje = " . $this->getidviaje();
                
                if ($base->Ejecutar($consultaBorra)) {
                    $resp = true;
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            } else { //Si no se ejecuta la consulta
                $this->setmensajeoperacion($base->getError());
            }
        } else { //Si no se conecta a la base de datos
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    /**
     * Elimina pasajeros relacionados al viaje y despues se elimina asi misma 
     */

    public function borrarViaje()
    {
        $pasajeros = new Pasajero;
        $condicion = "idviaje = " . $this->getidviaje();
        
        $colPasajeros = $pasajeros->listar($condicion);

        foreach ($colPasajeros as $pasajero) {
            $pasajero->eliminar();
        }

        $this->eliminar();
    }

    /**
     * Retorna una cadena de caracteres
     */

     public function retornaCadena($coleccion){
        $cadena=" ";
        foreach($coleccion as $elemento){
            $cadena=$cadena." ".$elemento."\n";
    
        }
        return $cadena;
    }
}
