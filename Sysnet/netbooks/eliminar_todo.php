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
$estado_listado = isset($_GET["estado"]) ? (is_numeric($_GET["estado"]) ? $_GET["estado"] : 0) : 0;
$ides = $_POST["idborrar"];
$ids = explode(",",$ides);
$cantidad = count($ids)-1;

if ($cantidad >= 1) {
	include_once("../funciones/conexion.php");
	$conexion=conectar();
	for ($a=0;$a<$cantidad;$a++) {
			//veo que ninguna net este asignada
			$sql = "SELECT netbook_matricula_id FROM netbooks WHERE netbook_id = '$ids[$a]' LIMIT 0,1";
			$consulta = consulta($sql,$conexion);
			$resultado = resultado($consulta);
			$matricula_id = $resultado["netbook_matricula_id"];
			if ($matricula_id != 0) {
				header ("Location: index.php?msj=17&estado={$estado_listado}");
				exit;
			}
	}
	for ($a=0;$a<$cantidad;$a++) {
				$sql = "DELETE FROM soporte WHERE soporte_netbook_id = '{$ids[$a]}'";
				consulta($sql,$conexion);
	
				$sql = "DELETE FROM netbooks WHERE netbook_id ='{$ids[$a]}'";
				consulta($sql,$conexion);
	}
	header ("Location: index.php?msj=60&estado={$estado_listado}");
	exit;
} else {
	header ("Location: index.php?estado={$estado_listado}");
	exit;
}
?>