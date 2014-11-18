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
$seccion_listado = isset($_GET["seccion"]) ? (is_numeric($_GET["seccion"]) ? $_GET["seccion"] : 0) : 0;
$mover = isset($_GET["mover"]) ? (is_numeric($_GET["mover"]) ? $_GET["mover"] : 0) : 0;
$ides = $_POST["idborrar"];
$ids = explode(",",$ides);
$cantidad = count($ids)-1;

if ($cantidad >= 1) {
	include_once("../funciones/conexion.php");
	$conexion=conectar();

	for ($a=0;$a<$cantidad;$a++) {
				$sql = "UPDATE matricula SET matricula_seccion_id = {$mover} WHERE matricula_id = '{$ids[$a]}'";
				consulta($sql,$conexion);
	}

	header ("Location: seccion.php?msj=54&seccion={$seccion_listado}");
	exit;
} else {
	header ("Location: seccion.php?seccion={$seccion_listado}");
	exit;
}
?>