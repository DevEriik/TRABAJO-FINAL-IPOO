<?php

class Persona
{

    private $nrodoc;
    private $nombre;
    private $apellido;
    private $telefono;
    private $mensajeoperacion;

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

    public function setNrodoc($NroDNI)
    {
        $this->nrodoc = $NroDNI;
    }
    public function setNombre($Nom)
    {
        $this->nombre = $Nom;
    }
    public function setApellido($Ape)
    {
        $this->apellido = $Ape;
    }


    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }


    public function setTelefono($Tel)
    {
        $this->telefono = $Tel;
    }

    public function getNrodoc()
    {
        return $this->nrodoc;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }


    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
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
        $consultaPersona = "Select * from persona where nrodoc=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
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

    public function listar($condicion = "")
    {
        $arregloPersona = null;
        $base = new BaseDatos();
        $consultaPersonas = "Select * from persona ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' where ' . $condicion;
        }
        $consultaPersonas .= " order by apellido ";
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arregloPersona = array();
                while ($row2 = $base->Registro()) {
                    $NroDoc = $row2['nrodoc'];
                    $Nombre = $row2['nombre'];
                    $Apellido = $row2['apellido'];
                    $Telefono = $row2['telefono']; //!VER COMO SE AGREGO EN LA BASE DE DATOS EL NOMBRE DE LA COLUMNA.

                    $perso = new Persona();
                    $perso->cargar($NroDoc, $Nombre, $Apellido, $Telefono);
                    array_push($arregloPersona, $perso);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloPersona;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO persona(nrodoc, apellido, nombre, telefono)
				VALUES (" . $this->getNrodoc() . ",'" . $this->getApellido() . "' . '" . $this->getNombre() . "'," . $this->getTelefono() . "')";

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

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM persona WHERE nrodoc=" . $this->getNrodoc();
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

    public function __toString()
    {
        return "\nNombre: " . $this->getNombre() . "\n Apellido:" . $this->getApellido() . "\n DNI: " . $this->getNrodoc() . "\n" . "Telefono: " . $this->getTelefono();
    }
}
