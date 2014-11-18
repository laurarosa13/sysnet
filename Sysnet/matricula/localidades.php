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
<?php $id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0; ?>
<select name="localidad_id" id="localidad" class="select-3" <?php if ($id == 0) { echo "disabled='disabled'"; } ?>>
	<option value="0" <?php if ($id == 0) { echo "disabled='disabled'"; } ?> selected="selected" >Seleccionar...</option>
    <?php 
	include_once("../funciones/conexion.php");
	$conexion=conectar();
	$sql = "SELECT localidad_id, localidad_nombre FROM localidades WHERE localidad_provincia_id = '$id' ORDER BY localidad_nombre Asc";
	$consulta = consulta($sql,$conexion);
	while ($resultado = resultado($consulta)) {
		$localidad_nombre = utf8_encode($resultado["localidad_nombre"]); 
	//$check = ($localidad_id == $resultado["localidad_id"]) ? "selected" : "";
	echo "<option value='".$resultado["localidad_id"]."'>".$localidad_nombre."</option>\n";
	}
	?>
</select>
