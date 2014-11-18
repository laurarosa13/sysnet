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
function conectar($host='', $user='', $pass='', $dbname=''){

if ($dbname == '') {
			$host= "localhost";
 			$user= "root";
 			$pass= "";
 			$dbname= "sysnetbd";
}


if (!($conexion=mysql_connect($host,$user,$pass)))
{
	echo "Error conectando a la base de datos.";
	exit();
}
if (!mysql_select_db($dbname,$conexion))
{
	echo "Error seleccionando la base de datos.";
	exit();
}
return $conexion;
}

function cerrar($conexion){
	mysql_close($conexion);
}

//realiza la consulta a la bd
function consulta($sql,$conexion){
	return mysql_query($sql,$conexion);
}

//devuelve la cantidad de filas de la consulta realizada
function filas($resultado) {
	return @mysql_num_rows($resultado);
}

//devuelve el resultado de la consulta
function resultado($consulta){
	return mysql_fetch_assoc($consulta);
}
?>
