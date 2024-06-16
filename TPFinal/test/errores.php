/*
? 1) Al modificar un responsable, el nuevo número de teléfono queda pegado al número cuando lo pongo
todo: (SOLUCIONADO)


? 2) Cantidad de pasajeros en los viajes, puede ser negativo
ID Viaje: 1
Destino: Lans
Cant. Max. Pasajeros: 0
ID Empresa: 2
Numero Empleado: 2
Importe: 1000000

ID Viaje: 3
Destino: Tucuman
Cant. Max. Pasajeros: -1
ID Empresa: 1
Numero Empleado: 6
Importe: 1222

**********************************************************

Si pongo letras como cantidad de pasajeros, me da que van 0 pasajeros.
Si pongo letras como importe, me da

ID de la empresa que quiere administrar los viajes: 2
Nombre del destino: Ecuador
Cantidad máxima de pasajeros: jajaja
Importe del viaje: $jajaja

ID Viaje: 4
Destino: Ecuador
Cant. Max. Pasajeros: 0
ID Empresa: 2
Numero Empleado: 3
Importe: 0


? 3) Al mostrar pasajeros, las letras con acentos no aparecen
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
ID: 8
Nombre: Pepe
Apellido:Pepn
DNI: 11111
Telefono: 111111

ID viaje: 2

*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
ID: 9
Nombre: Viviana
Apellido:Snchez
DNI: 22222
Telefono: 222222



? 4) Si quiero agregar pasajeros en un viaje con cantidad de asientos disponibles menor a cero, no aparece el mensaje que dice "Límite de asientos máximos alcanzado."
ID Viaje: 3
Destino: Tucuman
Cant. Max. Pasajeros: -1
ID Empresa: 1
Numero Empleado: 6
Importe: 1222

ID del viaje a incluirse: 3
           >> OPCIONES DE PASAJEROS

? 5) Al modificar un pasajero pide el DNI del pasajero a modificar, debería pedir el ID, ya que si meto el DNI, me dice que es inexistente/inválido
Pasajeros cargados a la BD:
*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
ID: 8
Nombre: Pepe
Apellido:Pepn
DNI: 11111
Telefono: 111111

ID viaje: 2

*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
ID: 9
Nombre: Viviana
Apellido:Snchez
DNI: 22222
Telefono: 222222

ID viaje: 2

DNI del pasajero a modificar: 8


? 6) Si tengo un viaje con la cantidad máxima de pasjeros y quiero modificar un pasajero de ese viaje, no me lo permite, dice "Límite máximo alcanzado.". No quiero agregar un pasajero, quiero modificar uno.



? 7) Si quiero modificar un pasajero
PHP Fatal error:  Uncaught Error: Call to a member function getidviaje() on null in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php:188
Stack trace:
#0 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(517): Pasajero->modificar()
#1 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(669): modificarPasajero(Object(Viaje), Object(Pasajero))
#2 {main}
  thrown in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php on 
line 188

Fatal error: Uncaught Error: Call to a member function getidviaje() on null in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php:188
Stack trace:
#0 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(517): Pasajero->modificar()
#1 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(669): modificarPasajero(Object(Viaje), Object(Pasajero))
#2 {main}
  thrown in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php on 
line 188


? 8) Validación id empresa en "Insertar viaje" 
todo: (SOLUCIONADO)


? 9) Validación de documento en "Ingresar pasajero"
todo: (SOLUCIONADO)


? 10) Si quiero modificar un pasajero en un viaje donde hay muchos asientos disponibles
ID del viaje a incorporarse: 5
PHP Fatal error:  Uncaught Error: Call to a member function getidviaje() on null in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php:188
Stack trace:
#0 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(517): Pasajero->modificar()
#1 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(669): modificarPasajero(Object(Viaje), Object(Pasajero))
#2 {main}
  thrown in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php on 
line 188

Fatal error: Uncaught Error: Call to a member function getidviaje() on null in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php:188
Stack trace:
#0 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(517): Pasajero->modificar()
#1 C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\test\testViajes.php(669): modificarPasajero(Object(Viaje), Object(Pasajero))
#2 {main}
  thrown in C:\Users\Dario\Desktop\Dario\TUDW\02-1er-anio-2do cuat\IPOO\2024\TP\TP-Final\MiTPFinal\TPFinal2024\GRUPO\TRABAJO-FINAL-IPOO\TPFinal\datos\Pasajeros.php on 
line 188


? 11) Validación de telefono en "Insertar pasajero"
todo: (SOLUCIONADO)


? 12) Validación del importe en "Insertar viaje"
todo: (SOLUCIONADO)


? 13) Validación del id responsable en "Insertar viaje"
todo: (SOLUCIONADO)


? 13) Validación del cantidad maxima de pasajeros en "Insertar viaje"
todo: (SOLUCIONADO)


? 13) Validación del id empresa de pasajeros en "Insertar viaje"
todo: (SOLUCIONADO)
*/