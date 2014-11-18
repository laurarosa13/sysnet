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
if (!isset($_SESSION["id_usuario"])) {
		header("Location: ../../salir/");
		exit;
} else {
include_once("../funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT usuario_privilegio FROM usuarios WHERE usuario_id = {$_SESSION['id_usuario']} LIMIT 0,1";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);

	if ($resultado["usuario_privilegio"] != 10) {
			header("Location: ../home/");
			exit;
	}
}
?>