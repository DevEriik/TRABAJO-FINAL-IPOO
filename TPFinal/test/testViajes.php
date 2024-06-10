<?php 
//*Incluimos los scripts. 
include_once './TPFinal/datos/BaseDatos.php';
include_once './TPFinal/datos/Empresa.php';
include_once './TPFinal/datos/Persona.php';
include_once './TPFinal/datos/ResponsableV.php';
include_once './TPFinal/datos/Viaje.php';
include_once './TPFinal/datos/Pasajeros.php';

/**
 * @param ****************** 
 * @return *******
 */

function menuDeOpciones(){
    echo "           >> MENÚ DE OPCIONES                 \n";
    echo "***********************************************\n";
    echo "         1) Administrar empresas               \n";
    echo "         2) Administrar viajes                 \n";
    echo "         3) Administrar responsables           \n";
    echo "         4) Administrar pasajeros              \n";
    echo "         5)      Salir                         \n";
    echo "***********************************************\n";
    $opcion= trim(fgets(STDIN));
    echo "\n";
    return $opcion;
} 

 /**
 * @param ****************** 
 * @return *******
 */

 function menuDeEmpresa(){
    echo "           >> OPCIONES DE EMPRESAS             \n";
    echo "_______________________________________________\n";
    echo "         1) Ingresar una empresa               \n";
    echo "         2) Modificar una empresa              \n";
    echo "         3) Mostrar empresas cargadas          \n";
    echo "         4) Eliminar una empresa               \n";
    echo "         5)      Atrás                         \n";
    echo "_______________________________________________\n";
    $opcion= trim(fgets(STDIN));
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
    if ($condicion != ""){
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
 function insertarEmpresa($objEmpresa){
    echo "Nombre de la empresa: ";
    $nombre = trim(fgets(STDIN));
    echo "Dirección de la empresa: ";
    $direccion = trim(fgets(STDIN));
    $objEmpresa->cargar("", $nombre, $direccion); //en insertar se setea el idEmpresa
    $objEmpresa->insertar();
    echo "Empresa insertada correctamente";
}
 /**
 * @param ****************** 
 * @return *******
 */
 function nombrefunction(){}

 /**
 * @param ****************** 
 * @return *******
 */

 function nombrefunction(){}







?>