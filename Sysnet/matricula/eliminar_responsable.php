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
include("../includes/comun/session.php"); ?>
<?php
$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;
$pg = isset($_GET["pg"]) ? (is_numeric($_GET["pg"]) ? $_GET["pg"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();

//levanto datos del responsable a borrar
$sql = "SELECT responsable_id FROM matricula_responsables WHERE responsable_id = '$id'";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);

if ($resultado["responsable_id"]) {
		$sql = "SELECT matricula_id FROM matricula WHERE matricula_responsable_id = '$id' LIMIT 0,1";
		$consulta = consulta($sql,$conexion);
		if (filas($consulta)) {
			header ("Location: seleccionar_responsable.php?msj=6&pg={$pg}");
		} else {	
			$sql = "DELETE FROM matricula_responsables WHERE responsable_id ='$id'";
			consulta($sql,$conexion);

			header ("Location: seleccionar_responsable.php?msj=55&pg={$pg}&borroid={$id}");
		}
} else {
	header ("Location: seleccionar_responsable.php?pg={$pg}");
}
?>