<?php 
/*~ 
.---------------------------------------------------------------------------.
|   Software: Sysnet     						                            |
|   Copyright 2015 Laura Rosa laurarosa13@gmail.com							|
|   Version: 1.0									                    	|
| ------------------------------------------------------------------------- |
| This program is free software; you can redistribute it and/or modify it	|
| under the terms of the GNU General Public License as published by the		|
| Free Software Foundation; either version 2 of the License, or (at your	|
| option) any later version. This program is distributed in the hope that	| 
| it will be useful, but WITHOUT ANY WARRANTY; without even the implied		|
| warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 	| 
| GNU General Public License for more details. 								|
| You should have received a copy of the GNU General Public License along	|
| with this program; if not, write to the Free Software Foundation, Inc.,	|
| 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.".     			|
'---------------------------------------------------------------------------'
 */
include("../includes/comun/session.php"); 
?>
<?php
if ($msj!= 0) {
	//mensajes de error < de 50
	$mensaje[1] = "Ya existe un matriculado con el DNI ingresado";
	$mensaje[2] = "Ya existe un matriculado con el CUIL ingresado";
	$mensaje[3] = "Ya existe un matriculado con el E-mail ingresado";
	$mensaje[4] = "No se puede eliminar un matriculado que posee una netbook asignada";
	$mensaje[5] = "No se ha eliminado ningún matriculado ya que uno de los seleccionados posee una netbook asignada";
	$mensaje[6] = "No puede eliminar un responsable que tiene matriculados a cargo";
	$mensaje[7] = "Ya existe un responsable con el DNI ingresado";
	$mensaje[8] = "Ya existe un responsable con el CUIL ingresado";
	$mensaje[9] = "Ya existe un responsable con el E-mail ingresado";
	$mensaje[10] = "Ya existe una netbook con el código ingresado";
	$mensaje[11] = "Ya existe una netbook con el número de serie ingresado";
	$mensaje[12] = "Ya existe una netbook con el número de producto de windows ingresado";
	$mensaje[13] = "Ya existe una netbook con el número de producto de office ingresado";
	$mensaje[14] = "Ya existe una netbook con la mac address ingresada";
	$mensaje[15] = "El matriculado seleccionado ya tiene una netbook asignada";
	$mensaje[16] = "No se puede eliminar una netbook que se encuentra actualmente asignada";
	$mensaje[17] = "No se ha eliminado ninguna netbook ya que una de las seleccionadas se encuentra asignada";
	$mensaje[18] = "Ya existe una solicitud de soporte con el número de caso ingresado";
	$mensaje[19] = "Ya existe una solicitud de soporte para la netbook seleccionada";
	$mensaje[20] = "Ya existe un usuario con el DNI ingresado";
	$mensaje[21] = "Ya existe un usuario con el E-mail ingresado";
	$mensaje[22] = "El archivo que intenta subir no corresponde a un archivo de base de datos compatible";
	$mensaje[23] = "No fue posible subir el archivo al sistema. Es posible que el mismo sea muy grande";
	$mensaje[24] = "La base de datos que intenta restaurar no corresponde a este sistema o se encuentra dañada";
	$mensaje[25] = "No puede eliminar una sección que contenga matriculados";
	$mensaje[26] = "Ya existe una sección con el nombre ingresado";
	$mensaje[27] = "No ha ingresado la clave de acceso del usuario";

	//mensajes de exito > a 50
	$mensaje[50] = "El matriculado ha sido cargado en el sistema";
	$mensaje[51] = "Los datos del matriculado han sido modificados";
	$mensaje[52] = "El matriculado ha sido eliminado del sistema";
	$mensaje[53] = "Los matriculados seleccionados han sido eliminados del sistema";
	$mensaje[54] = "Los matriculados seleccionados han sido movidos de sección";
	$mensaje[55] = "El responsable ha sido eliminado del sistema";
	$mensaje[56] = "Los datos del responsable han sido modificados";
	$mensaje[57] = "La netbook ha sido cargada en el sistema";
	$mensaje[58] = "Los datos de la netbook han sido modificados";
	$mensaje[59] = "La netbook ha sido eliminada del sistema";
	$mensaje[60] = "Las netbooks han sido eliminadas del sistema";
	$mensaje[61] = "La solicitud de soporte ha sido cargada en el sistema";
	$mensaje[62] = "Los datos de la solicitud de soporte han sido modificados";
	$mensaje[63] = "La solicitud de soporte ha sido eliminada del sistema";
	$mensaje[64] = "Las solicitudes de soporte seleccionadas han sido eliminadas del sistema";
	$mensaje[65] = "El usuario ha sido cargado en el sistema";
	$mensaje[66] = "Los datos del usuario han sido modificados";
	$mensaje[67] = "El usuario ha sido eliminado del sistema";		
	$mensaje[68] = "Los usuarios seleccionados han sido eliminados del sistema";
	$mensaje[69] = "Sus datos han sido modificados correctamente";
	$mensaje[70] = "La copia de respaldo ha sido restaurada correctamente";
	$mensaje[71] = "La sección ha sido eliminada del sistema";	
	$mensaje[72] = "El nombre de la sección ha sido guardado";	
	$mensaje[73] = "La nueva sección ha sigo cargada en el sistema";	
			
	if ($msj <= 49) {
		$muestro = "<span>ERROR:</span> ".$mensaje[$msj];
	    $clase = "error";
	} else {
		$muestro = "<span>EXITO:</span> ".$mensaje[$msj];
	    $clase = "exito";
	}
}
?>