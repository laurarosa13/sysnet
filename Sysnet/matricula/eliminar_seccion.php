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

include_once("../funciones/conexion.php");
$conexion=conectar();

//compruebo si hay matriculados cargados en la seccion y si hay da error
$sql = "SELECT matricula_id FROM matricula WHERE matricula_seccion_id = '$id'";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);

if ($resultado["matricula_id"]) {
	header ("Location: configurar_secciones.php?msj=25");
} else {
	$sql = "DELETE FROM matricula_secciones WHERE seccion_id ='$id'";
	consulta($sql,$conexion);

	//header ("Location: configurar_secciones.php?msj=71");
	?>
		<script type="text/javascript">
		<!-- // --><![CDATA[
		parent.document.location.href = "index.php?msj2=71";
		// -->
		// ]]>
		</script>
    <?php
}
?>