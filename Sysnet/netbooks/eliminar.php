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
$estado_listado = isset($_GET["estado"]) ? (is_numeric($_GET["estado"]) ? $_GET["estado"] : 0) : 0;
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();

//levanto datos de la netbook a borrar
$sql = "SELECT netbook_id,netbook_matricula_id FROM netbooks WHERE netbook_id = '$id'";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);

if ($resultado["netbook_id"]) {
		$matricula_id = $resultado["netbook_matricula_id"];
		if ($matricula_id != 0) {
			header ("Location: index.php?msj=16&p={$pag}&estado={$estado_listado}");
		} else {	
			$sql = "DELETE FROM soporte WHERE soporte_netbook_id = '$id'";
			consulta($sql,$conexion);
						
			$sql = "DELETE FROM netbooks WHERE netbook_id ='$id'";
			consulta($sql,$conexion);

			header ("Location: index.php?msj=59&estado={$estado_listado}");
		}
} else {
	header ("Location: index.php?p={$pag}&estado={$estado_listado}");
}
?>