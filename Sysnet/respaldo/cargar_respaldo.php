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
include('../includes/comun/privilegio.php');
header( "Content-type: text/html; charset=UTF-8" );
set_time_limit(0);
$archivo = $_FILES["archivobd"]["tmp_name"]; 
$tipo_archivo = $_FILES['archivobd']['type']; 
$tamano_archivo = $_FILES['archivobd']['size']; 

if ($tipo_archivo == 'application/octet-stream') {

	$fecha = date('Y-m-d');
	$archivo_name = $fecha."-respaldo.sql";
	
	$file_delete = '../backups/'.$archivo_name;
	if (file_exists($file_delete)) { @unlink($file_delete); }

	if (move_uploaded_file($archivo, "../backups/backups_respaldados/".$archivo_name)) {
		
		include_once("../funciones/conexion.php");
		$conexion=conectar();
		
		$texto = file_get_contents("../backups/backups_respaldados/".$archivo_name);

		$tablita[1] = "localidades";
		$tablita[2] = "matricula";
		$tablita[3] = "matricula_responsables";
		$tablita[4] = "matricula_secciones";
		$tablita[5] = "netbooks";
		$tablita[6] = "netbooks_estados";
		$tablita[7] = "netbooks_marcas";
		$tablita[8] = "provincias";
		$tablita[9] = "soporte";
		$tablita[10] = "soporte_estados";
		$tablita[11] = "usuarios";
												
		$realizar = 0;
		for($a=1;$a<=11;$a++) {
			$patron1 = "CREATE TABLE `{$tablita[$a]}`";
			$buscar_cadena = strpos($texto, $patron1);
			if($buscar_cadena != FALSE){ $realizar = $realizar+1; }
		}
		
		if ($realizar == 11) {
			$sentencia = explode(";", $texto);
			for($i = 0; $i < (count($sentencia)-1); $i++){
				consulta($sentencia[$i],$conexion);
			}
			header ("Location: cargar.php?msj=70");
		} else {
			header ("Location: cargar.php?msj=24");		
		}
	} else {
		header ("Location: cargar.php?msj=23");
	}
} else {
	header ("Location: cargar.php?msj=22");
}
?>