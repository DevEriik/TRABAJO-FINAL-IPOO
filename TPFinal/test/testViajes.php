<?php
//*Incluimos los scripts. 
include_once '../datos/BaseDatos.php';
include_once '../datos/Empresa.php';
include_once '../datos/Persona.php';
include_once '../datos/ResponsableV.php';
include_once '../datos/Viaje.php';
include_once '../datos/Pasajeros.php';

/**
 * @param ****************** 
 * @return *******
 */

function menuDeOpciones()
{
    echo "           >> MENÚ DE OPCIONES                 \n";
    echo "***********************************************\n";
    echo "         1) Administrar empresas               \n";
    echo "         2) Administrar viajes                 \n";
    echo "         3) Administrar responsables           \n";
    echo "         4) Administrar pasajeros              \n";
    echo "         5)      Salir                         \n";
    echo "***********************************************\n";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

/**
 * @param ****************** 
 * @return *******
 */
function menuDeEmpresa()
{
    echo "           >> OPCIONES DE EMPRESAS             \n";
    echo "_______________________________________________\n";
    echo "         1) Ingresar una empresa               \n";
    echo "         2) Modificar una empresa              \n";
    echo "         3) Mostrar empresas cargadas          \n";
    echo "         4) Eliminar una empresa               \n";
    echo "         5)      Atrás                         \n";
    echo "_______________________________________________\n";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

function menuDeViaje()
{
    echo "           >> OPCIONES DE VIAJES               \n";
    echo "_______________________________________________\n";
    echo "         1) Ingresar un viaje                  \n";
    echo "         2) Modificar un viaje                 \n";
    echo "         3) Mostrar viajes cargados            \n";
    echo "         4) Eliminar un viaje                  \n";
    echo "         5)      Atrás                         \n";
    echo "_______________________________________________\n";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

function menuDeResponsable()
{
    echo "           >> OPCIONES DE RESPONSABLES         \n";
    echo "_______________________________________________\n";
    echo "         1) Ingresar un responsable           \n";
    echo "         2) Modificar un responsable          \n";
    echo "         3) Mostrar responsables cargados     \n";
    echo "         4) Eliminar un responsable           \n";
    echo "         5)      Atrás                         \n";
    echo "_______________________________________________\n";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

function menuDePasajero()
{
    echo "           >> OPCIONES DE PASAJEROS            \n";
    echo "_______________________________________________\n";
    echo "         1) Ingresar un pasajero              \n";
    echo "         2) Modificar un pasajero             \n";
    echo "         3) Mostrar pasajeros cargados        \n";
    echo "         4) Eliminar un pasajero              \n";
    echo "         5)      Atrás                         \n";
    echo "_______________________________________________\n";
    $opcion = trim(fgets(STDIN));
    echo "\n";
    return $opcion;
}

/**
 * @param ****************** 
 * @return *******
 */
function muestraElementos($obj, $condicion)
{
    $coleccion = [];
    if ($condicion != "") {
        $coleccion = $obj->listar($condicion); // listar(), puede tener o no condicion. Devuelve una coleccion
        foreach ($coleccion as $elemento) {
            echo "\n" . $elemento;
        }
    } else {                                  //si  no hay condicion 
        $coleccion = $obj->listar();
        foreach ($coleccion as $elemento) {
            echo "\n" . $elemento;
        }
    }
}
/**
 * @param ****************** 
 * @return *******
 */
function insertarEmpresa($objEmpresa)
{
    echo "Nombre de la empresa: ";
    $nombre = trim(fgets(STDIN));
    echo "Dirección de la empresa: ";
    $direccion = trim(fgets(STDIN));
    $objEmpresa->cargar("", $nombre, $direccion); //en insertar se setea el idEmpresa
    $objEmpresa->insertar();
    echo "Empresa insertada correctamente";
}

/**
 * 
 */

function modificarEmpresa($objEmpresa)
{
    $colEmpresas = $objEmpresa->listar();
    if (!empty($colEmpresas)) {
        echo "Empresas cargadas en la BD: ";
        muestraElementos($objEmpresa, "");

        echo "\nID de la empresa a modificar: ";
        $id = trim(fgets(STDIN));
        if ($objEmpresa->buscar($id)) {
            echo "Nuevo nombre de la empresa: ";
            $nombre = trim(fgets(STDIN));
            echo "Nueva dirección de la empresa: ";
            $direccion = trim(fgets(STDIN));
            $objEmpresa->cargar($id, $nombre, $direccion);
            $objEmpresa->modificar();
            echo "Empresa modificada correctamente. ";
        } else {
            echo "ID de empresa inválido/innexistente. ";
        }
    } else {
        echo "Sin empresas cargadas en la BD. \n";
    }
}
/**
 * Elimina cualquier registro de una empresa
 */
function eliminarEmpresa($objEmpresa, $objViaje)
{
    $colEmpresas = $objEmpresa->listar();
    if (!empty($colEmpresas)) {    //Mostrar empresas cargadas en la BD
        echo "Empresas cargadas en la BD: ";
        muestraElementos($objEmpresa, "");
        echo "\nID de la empresa a eliminar: ";
        $id = trim(fgets(STDIN));
        if ($objEmpresa->buscar($id)) {
            echo " ¡Alerta! :: Se borrarán todos los viajes vinculados a esta empresa\n ¿Continuar? (s/n): ";
            $rta = trim(fgets(STDIN));
            if ($rta == "s") {
                $objEmpresa->borrarEmpresa();
                $objViaje->borrarViaje();
                echo "Empresa eliminada correctamente. ";
            } else {
                echo "Operación cancelada. ";
            }
        } else {
            echo "ID de empresa inválido/innexistente. ";
        }
    } else {
        echo "Sin empresas cargadas en la BD. \n";
    }
}

/**
 * Inserta un viaje a la Base de datos.
 */

function insertarViaje($objEmpresa, $objViaje, $objResponsable)
{
    $colEmpresas = $objEmpresa->listar();
    if (!empty($colEmpresas)) {
        echo "\nEmpresas disponibles:";
        muestraElementos($objEmpresa, "");
        echo "\nID de la empresa que quiere administrar los viajes: ";
        $idEmpresa = trim(fgets(STDIN));

        //Verifico si existe la empresa elegida
        if ($objEmpresa->buscar($idEmpresa)) {

            //Verifico que hayan responsables registrados en la BD
            $colResponsable = $objResponsable->listar();
            if (!empty($colResponsable)) {
                echo "Nombre del destino: ";
                $destino = trim(fgets(STDIN));
                echo "Cantidad máxima de pasajeros: ";
                $cantMax = trim(fgets(STDIN));
                echo "Importe del viaje: $";
                $importe = trim(fgets(STDIN));
                echo "\nResponsables disponibles: ";
                muestraElementos($objResponsable, "");
                echo "\nSeleccione ID del empleado: ";
                $id = trim(fgets(STDIN));

                //Verifico si existe el responsable elegido
                if ($objResponsable->buscar($id)) {
                    //Si todos los datos están bien, cargo e inserto el viaje a la BD
                    $objViaje->cargar("", $destino, $cantMax, $objEmpresa, $objResponsable, $importe);
                    $objViaje->insertar();
                    echo "Viaje insertado correctamente. \n";
                } else {
                    echo "ID de responsable inválido/innexistente. \n";
                }
            } else {
                echo "Sin responsables cargados en la BD. ";
            }
        } else {
            echo "ID de empresa inválido/innexistente. ";
        }
    } else {
        echo "Sin empresas cargadas en la BD. \n";
    }
}

function modificarViaje($objViaje, $objEmpresa, $objResponsable, $objPasajero)
{
    $colViajes = $objViaje->listar();
    if (!empty($colViajes)) {
        //Verifico que haya viajes en la BD
        echo "Viajes cargados a la BD: ";
        muestraElementos($objViaje, "");

        echo "ID del viaje a modificar: ";
        $idViaje = trim(fgets(STDIN));

        if ($objViaje->buscar($idViaje)) {
            echo "Nuevo lugar de destino: ";
            $destino = trim(fgets(STDIN));
            echo "Cantidad máxima de pasajeros: ";
            $cantMax = trim(fgets(STDIN));

            //Evalúo que la cantidad máxima de pasajeros no sea
            //menor que la cantidad de pasajeros actuales
            $condicion = "idviaje =" . $idViaje;
            $colPasajeros = $objPasajero->listar($condicion);
            $n = count($colPasajeros);

            if ($cantMax < $n) {
                echo "La cantidad máxima de pasajeros no puede ser menor a la cantidad actual";
            } else {
                //Pido datos del responsable y verifico si existe
                echo "Responsables cargados a la BD: ";
                muestraElementos($objResponsable, "");
                echo "\nIngrese el ID del empleado que va a dirigir el viaje: "; //? es ID persona
                 
                $idEmpleado = trim(fgets(STDIN)) . "\n";

                //Si existe responsable, verifico que exista la empresa
                if ($objResponsable->buscar($idEmpleado)) {
                    echo "Empresas cargadas a la BD: ";
                    muestraElementos($objEmpresa, "");

                    echo "\nSeleccione ID empresa para mudar el viaje: ";
                    $idEmpresa = trim(fgets(STDIN));

                    //Si la empresa existe, pido importe nuevo y modifico el viaje
                    if ($objEmpresa->buscar($idEmpresa)) {
                        echo "Importe: ";
                        $importe = trim(fgets(STDIN));
                        $objViaje->cargar($idViaje, $destino, $cantMax, $objEmpresa, $objResponsable, $importe);
                        $objViaje->modificar();
                        echo "Viaje modificado correctamente\n";
                    } else {
                        "ID de empresa inválido/innexistente\n";
                    }
                } else {
                    echo "ID responsable inválido/innexistente\n";
                }
            }
        }
    } else {
        echo "Sin viajes cargados en la BD";
    }
}

/**
 * Elimina un viaje de la BD
 */
function eliminarViaje($objViaje)
{
    $colViajes = $objViaje->listar();
    if (!empty($colViajes)) {
        echo "\nViajes cargados a la BD: ";
        muestraElementos($objViaje, "");

        echo "\nID del viaje a eliminar: ";
        $idViaje = trim(fgets(STDIN));

        if ($objViaje->buscar($idViaje)) {
            $objViaje->borrarViaje();
            echo "Viaje eliminado correctamente. ";
        } else {
            echo "ID de viaje inválido/innexistente. ";
        }
    } else {
        echo "Sin viajes cargados en la BD. \n";
    }
}


/**
 * Inserta un responsable a la BD
 */
function insertarResponsable($objResponsable)
{
    echo "Numero de documento del responsable: ";
    $nrodocumento = trim(fgets(STDIN));
    echo "Nombre del responsable: ";
    $nombre = trim(fgets(STDIN));
    echo "Apellido del responsable: ";
    $apellido = trim(fgets(STDIN));
    echo "Telefono del responsable: ";
    $telefono = trim(fgets(STDIN));
    echo "Número de licencia: ";
    $nroLicencia = trim(fgets(STDIN));

    $objResponsable->cargar("", $nrodocumento,  $nombre, $apellido, $telefono, "" ,$nroLicencia);
    

    if ($objResponsable->insertar()) {

        echo "Responsable insertadado correctamente";
    } else {
        echo "No se pudo insertar al responsable correctamente";
    }
}


/**
 * Modifica un responsable de la BD
 */
function modificarResponsable($objResponsable)
{
    $colResponsables = $objResponsable->listar();

    //Verifico si hay responsables cargados
    if (empty($colResponsables)) {
        echo "Sin responsables cargados en la BD. \n";
    } else {
        //Muestro listado de responsables disponibles para modificar
        echo "Responsables cargados a la BD: \n";
        muestraElementos($objResponsable, "");

        echo "\nN° de empleado del responsable a modificar: ";
        $idEmpleado = trim(fgets(STDIN));

        //Verifico que exista algún empleado con ese ID
        if ($objResponsable->buscar($idEmpleado)) {
            echo $objResponsable . "\n";
            echo "Nuevo nombre del responsable: ";
            $nombre = trim(fgets(STDIN));
            echo "Nuevo apellido del responsable: ";
            $apellido = trim(fgets(STDIN));
            echo "Nuevo N° del responsable: ";
            $nroLicencia = trim(fgets(STDIN));
            echo "Nuevo Nº de telefono";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese el N° de documento: ";
            $nroDoc =  trim(fgets(STDIN));

            $objResponsable->cargar($objResponsable->getIdPersona(), $nroDoc,  $nombre, $apellido, $telefono, $objResponsable->getRnumeroEmpleado() ,$nroLicencia);
            $objResponsable->modificar();
            echo "Responsable modificado correctamente. ";
        } else {
            echo "ID responsable inválido/inválido. ";
        }
    }
}

/**
 * Elimina un Responsable.
 */
function eliminarResponsable($objResponsable, $objPasajero)
{
    $colResponsable = $objResponsable->listar();
    if (!empty($colResponsable)) {
        echo "Responsables disponibles: ";
        muestraElementos($objResponsable, "");

        echo "\nID del responsable a eliminar: ";
        $id = trim(fgets(STDIN));

        if ($objResponsable->buscar($id)) {
            echo " ¡Alerta! :: Se borrarán los viajes vinculados a este responsable\n ¿Continuar? (s/n): ";
            $rta = trim(fgets(STDIN));
            if ($rta == "s") {
                $objResponsable->eliminar(); //! NO NOS DEJA ELIMINAR EL RESPONSABLE CUANDO UN VIAJE TIENE PASAJEROS.
                echo "Responsable eliminado correctamente. \n";
            }
        } else {
            echo "ID de responsable inválido/innexistente. \n";
        }
    } else {
        echo "Sin responsables cargados en la BD. \n";
    }
}

/**
 * Inserta un pasajero a la BD
 */
function insertarPasajero()
{
    $objPasajero = new Pasajero();
    $objViaje = new Viaje();
    $colViajes = $objViaje->listar();
    if (!empty($colViajes)) {
        echo "Viajes disponibles: ";
        muestraElementos($objViaje, "");

        echo "\nID del viaje a incluirse: ";
        $idViaje = trim(fgets(STDIN));

        //Compruebo si este viaje existe
        if ($objViaje->buscar($idViaje)) {
            $condicion = "idviaje= " . $idViaje;
            // $colPasajeros = $objPasajero->listar($condicion);
            $colPasajeros = $objViaje->getcolPasajeros();
            $cantActual = count($colPasajeros);
            $max = $objViaje->getvcantmaxpasajeros();
            $asientosDisponibles = $max - $cantActual;

            //Evalúo que no se exceda el límite de pasajeros máximos
            if ($max == $cantActual) {
                echo "Límite de asientos máximos alcanzado. \n";
            } elseif ($asientosDisponibles > 0) {
                echo "¡Asiento disponible!\nNúmero de documento: ";
                $dni = trim(fgets(STDIN));
                if ($objPasajero->buscar($dni)) {
                    echo "Error, el DNI ya existe. ";
                } else {
                    echo "Ingrese el nombre del pasajero: ";
                    $nombre = trim(fgets(STDIN));
                    echo "Ingrese el apellido del pasajero: ";
                    $apellido = trim(fgets(STDIN));
                    echo "Ingrese el telefono del pasajero: ";
                    $telefono = trim(fgets(STDIN));
                    $pasajero = new Pasajero;
                    $pasajero->cargar($pasajero->getIdPersona(),$dni, $nombre, $apellido, $telefono, $objViaje, $pasajero->getIdPasajero());
                    $pasajero->insertar();
                    echo "Pasajero insertado correctamente. \n";
                }
            }
        } else {
            echo "ID de viaje inválido/innexistente. \n";
        }
    } else {
        echo "Sin viajes cargados en la BD. ";
    }
}

/**
 * Modifica un pasajero de la BD
 */
function modificarPasajero($objViaje, $objPasajero)
{
    $colPasajeros = $objPasajero->listar();

    //Verificamos si hay pasajeros cargados
    if (empty($colPasajeros)) {
        echo "Sin pasajeros cargados en la BD. \n";
    } else {
        //Mostramos listado de pasajeros disponibles para modificar
        echo "Pasajeros cargados a la BD: ";
        muestraElementos($objPasajero, "");

        echo "\nDNI del pasajero a modificar: ";
        $dni = trim(fgets(STDIN));

        //Verificamos que exista algún pasajero con ese dni
        if ($objPasajero->buscar($dni)) {
            echo "Nuevo nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            echo "Nuevo apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            echo "Nuevo n° de teléfono: ";
            $telefono = trim(fgets(STDIN));

            //Mostramos colección de viajes
            echo "Viajes cargados a la BD: ";
            muestraElementos($objViaje, "");
            echo "\nID del viaje a incorporarse: ";
            $idViaje = trim(fgets(STDIN));

            //Comprobamos si el viaje existe
            if ($objViaje->buscar($idViaje)) {
                $condicion = "idviaje= " . $idViaje;
                $colPasajeros = $objPasajero->listar($condicion);
                $cantActual = count($colPasajeros);
                $max = $objViaje->getvcantmaxpasajeros();
                $asientosDisponibles = $max - $cantActual;

                //Evaluamos que no se exceda el límite de pasajeros máximos
                if ($max == $cantActual) {
                    echo "Límite máximo alcanzado. ";
                } elseif ($asientosDisponibles > 0) {

                    $objPasajero->cargar($dni, $nombre, $apellido, $telefono, $idViaje);
                    $objPasajero->modificar();
                    echo "Pasajero modificado correctamente. ";
                }
            } else {
                echo "ID de viaje inválido/innexistente. ";
            }
        } else {
            echo "DNI de pasajero inválido/innexistente. ";
        }
    }
}


/**
 * Elimina un pasajero de la BD
 */
function eliminarPasajero($objPasajero)
{
    //Verifico si hay pasajeros cargados en la BD
    $colPasajeros = $objPasajero->listar();
    if (!empty($colPasajeros)) {
        echo "Pasajeros disponibles: ";
        muestraElementos($objPasajero, "");

        echo "\nID del pasajero a eliminar: ";
        $id = trim(fgets(STDIN));

        if ($objPasajero->buscar($id)) {
            $objPasajero->eliminar();
            echo "Pasajero eliminado correctamente. \n";
        } else {
            echo "DNI de pasajero inválido/innexistente. \n";
        }
    } else {
        echo "Sin pasajeros cargados en la BD. \n";
    }
}



//! ********************* MENU ************************

$objEmpresa = new Empresa;
$objViaje = new Viaje;
$objPersona = new Persona;
$objResponsable = new ResponsableV;
$objPasajero = new Pasajero;
echo "**************************";
echo "\nPROGRAMA INICIADO\n";
echo "**************************\n";
$opcionMenu = menuDeOpciones();
while ($opcionMenu != 5) {
    switch ($opcionMenu) {
        case 1:
            //Opciones de empresa
            $opcionEmpresa = menuDeEmpresa();
            while ($opcionEmpresa != 5) {
                switch ($opcionEmpresa) {
                    case 1:
                        //Insertar una empresa
                        insertarEmpresa($objEmpresa);
                        break;
                    case 2:
                        //Modificar una empresa
                        modificarEmpresa($objEmpresa);
                        break;
                    case 3:
                        //Mostrar empresas
                        if (empty($objEmpresa->listar())) {
                            echo "Actualmente no hay empresas cargadas en la BD\n";
                        } else {
                            muestraElementos($objEmpresa, "");
                        }
                        break;
                    case 4:
                        //Eliminar una empresa
                        eliminarEmpresa($objEmpresa, $objViaje);
                        break;
                }
                $opcionEmpresa = menuDeEmpresa();
            }
            break;
        case 2:
            //Opciones de viajes
            $opcionViajes = menuDeViaje();
            while ($opcionViajes != 5) {
                switch ($opcionViajes) {
                    case 1:
                        //Insertar un viaje
                        insertarViaje($objEmpresa, $objViaje, $objResponsable);
                        break;
                    case 2:
                        //Modificar un viaje
                        modificarViaje($objViaje, $objEmpresa, $objResponsable, $objPasajero);
                        break;
                    case 3:
                        //Mostrar viajes
                        if (empty($objViaje->listar())) {
                            echo "Actualmente no hay viajes cargados en la BD\n";
                        } else {
                            muestraElementos($objViaje, "");
                        }
                        break;
                    case 4:
                        //Eliminar un viaje
                        eliminarViaje($objViaje);
                        break;
                }
                $opcionViajes = menuDeViaje();
            }
            break;
        case 3:
            //Opciones de responsable
            $opcionResponsable = menuDeResponsable();
            while ($opcionResponsable != 5) {
                switch ($opcionResponsable) {
                    case 1:
                        //Insertar un responsable;
                        insertarResponsable($objResponsable);
                        break;
                    case 2:
                        //Modificar un responsable
                        // echo $objResponsable . "\n";
                        modificarResponsable($objResponsable);
                        break;
                    case 3:
                        //Mostrar responsables
                        if (empty($objResponsable->listar())) {
                            echo "Actualmente no hay responsables cargados en la BD\n";
                        } else {
                            muestraElementos($objResponsable, "");
                        }
                        break;
                    case 4:
                        //Eliminar un responsable
                        eliminarResponsable($objResponsable, $objPasajero);
                        break;
                }
                $opcionResponsable = menuDeResponsable();
            }
            break;
        case 4:
            //Opciones de pasajero
            $opcionPasajero = menuDePasajero();
            while ($opcionPasajero != 5) {
                switch ($opcionPasajero) {
                    case 1:
                        //Insertar un pasajero
                        insertarPasajero($objViaje, $objPasajero);
                        break;
                    case 2:
                        //Modificar un pasajero
                        modificarPasajero($objViaje, $objPasajero);
                        break;
                    case 3:
                        //Mostrar pasajeros
                        if (empty($objPasajero->listar())) {
                            echo "Actualmente no hay pasajeros cargados en la BD\n";
                        } else {
                            muestraElementos($objPasajero, "");
                        }
                        break;
                    case 4:
                        //Eliminar un pasajero
                        eliminarPasajero($objPasajero);
                        break;
                }
                $opcionPasajero = menuDePasajero();
            }
    }
    $opcionMenu = menuDeOpciones();
}
