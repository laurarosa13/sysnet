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
$seccion_listado = isset($_GET["seccion"]) ? (is_numeric($_GET["seccion"]) ? $_GET["seccion"] : 0) : 0;
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();

//levanto datos del matriculado a borrar
$sql = "SELECT matricula_id,matricula_seccion_id FROM matricula WHERE matricula_id = '$id'";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);
$seccion_id = $resultado['matricula_seccion_id'];
if ($seccion_listado == 0) { $seccion_listado = $seccion_id; }

if ($resultado["matricula_id"]) {
		$sql = "SELECT netbook_id FROM netbooks WHERE netbook_matricula_id = '$id' LIMIT 0,1";
		$consulta = consulta($sql,$conexion);
		if (filas($consulta)) {
			header ("Location: seccion.php?msj=4&p={$pag}&seccion={$seccion_listado}");
		} else {	
			$sql = "DELETE FROM matricula WHERE matricula_id ='$id'";
			consulta($sql,$conexion);

			header ("Location: seccion.php?msj=52&seccion={$seccion_listado}");
		}
} else {
	header ("Location: seccion.php?p={$pag}&seccion={$seccion_listado}");
}
?>