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
include("../includes/session.php"); ?>
<?php
$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;

if ($id != 0) {
	include_once("../funciones/conexion.php");
	$conexion=conectar();
	
	$sql= "SELECT seccion_orden FROM matricula_secciones WHERE seccion_id = '$id'";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);
	$orden = $resultado["seccion_orden"];	
	
	
	$sql = "SELECT MIN(seccion_orden) AS orden FROM matricula_secciones";
	$consulta = consulta($sql,$conexion);
	if ($resultado = resultado($consulta)) {
		$min_orden = $resultado["orden"];
	} else {
		$min_orden = 0;
	}

	if (($orden != $min_orden) AND ($min_orden < $orden)) {
		//lo subo
		
		$sql2 = "SELECT * FROM matricula_secciones WHERE seccion_orden < $orden ORDER BY seccion_orden Desc LIMIT 0,1";
		$consulta2 = consulta($sql2,$conexion);
		$resultado2 = resultado($consulta2);
		$orden_anterior = $resultado2["seccion_orden"];
		$id_anterior = $resultado2["seccion_id"];
		
		//guardo en el actual el anterior
		$sql3 = "UPDATE matricula_secciones SET seccion_orden = $orden_anterior WHERE seccion_id = $id";	
		consulta($sql3,$conexion);
			
		//guardo en el anterior el actual
		$sql3 = "UPDATE matricula_secciones SET seccion_orden = $orden WHERE seccion_id = $id_anterior";	
		consulta($sql3,$conexion);
			
		header ("Location: ../matricula/index.php");
	} else {
		//no hago nada
		header ("Location: ../matricula/index.php");
	}
	//echo $orden;
	//echo $min_orden;

	
} else {
	header ("Location: ../matricula/index.php");
}
?>