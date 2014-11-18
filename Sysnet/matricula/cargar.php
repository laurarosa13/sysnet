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
<?php $menu_posicion = 2; ?>
<?php
$provincia = 0;
$responsable_id = 0;
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
if (isset($_POST["accion"])) {
	foreach($_POST as $k => $v) {$$k = $v;}

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//compruebo que no haya matriculado con ese email
	if ($email != "") {
	$sql = "SELECT matricula_id FROM matricula WHERE matricula_email = '$email' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 3; }
	}
	
	//compruebo que no haya matriculado con ese cuil
	$sql = "SELECT matricula_id FROM matricula WHERE matricula_cuil = '$cuil' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 2; } 
	
	//compruebo que no haya matriculado con ese dni
	$sql = "SELECT matricula_id FROM matricula WHERE matricula_dni = '$dni' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 1; } 

	//guardo en la bd
	if ($msj == 0) {
		$apellido = strtr(strtoupper($apellido),"áéíóúçñäëïöü","AEIOUÇÑÄËÏÖÜ");
		$nombre = strtr(strtolower($nombre),"AEIOUÇÑÄËÏÖÜ","áéíóúçñäëïöü");
		$nombre = mb_convert_case($nombre, MB_CASE_TITLE);
		
		$sql = "INSERT INTO matricula (matricula_responsable_id,matricula_seccion_id,matricula_localidad_id,matricula_nombre,matricula_apellido,matricula_dni,matricula_cuil,matricula_calle,matricula_nro,matricula_depto,matricula_cp,matricula_tel,matricula_cel,matricula_email) VALUES ('$responsable_id','$seccion','$localidad_id','$nombre','$apellido','$dni','$cuil','$calle','$nro','$depto','$cp','$telefono','$celular','$email')";
		consulta($sql,$conexion);
		
		header ("Location: seccion.php?seccion={$seccion}&msj=50");
		exit;
	}
}
?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<script src="../js/thickbox.js" type="text/javascript"></script>
<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    $(document).ready(function(){
         $('.resp').click(function (event){
            event.preventDefault();
            tb_show('','responsable.php?p=1&amp;KeepThis=true&amp;TB_iframe=true&amp;height=405&amp;width=952');
        });
         $('.sel-resp').click(function (event){
            event.preventDefault();
			seleccionado = document.cargar.responsable_id.value;
            tb_show('','seleccionar_responsable.php?p=1&amp;id='+seleccionado+'&amp;KeepThis=true&amp;TB_iframe=true&amp;height=418&amp;width=569');
        });
         $('.edit-resp').click(function (event){
            event.preventDefault();
			seleccionado = document.cargar.responsable_id.value;
			if (seleccionado != 0) {
            tb_show('','responsable_editar.php?p=1&amp;id='+seleccionado+'&amp;cerrar=1&amp;KeepThis=true&amp;TB_iframe=true&amp;height=405&amp;width=952');
			} else {
				alert('Error:\nNo existe ningun responsable seleccionado');
			}
        });
    });
	function lanzar2(url){
        tb_show('',url);
    }
    // ]]>
</script>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Cargar matricula</div>
        </div><!-- fin cuadro encabezado --> 
        <form name="cargar" method="POST" autocomplete="off" action="cargar.php" onsubmit="return validarmatricula();">
        <input type="hidden" value="1" name="accion">
        <input type="hidden" value="<?php echo $responsable_id; ?>" name="responsable_id">
		<div class="formulario">
        	<div class="campo-txt">Apellido *</div>
        	<div class="campo-txt m30">Nombres *</div>
        	<div class="campo-txt m30">Número de DNI *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="apellido" value="<?php if (isset($apellido)) { echo $apellido; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="nombre" value="<?php if (isset($nombre)) { echo $nombre; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="dni" value="<?php if (isset($dni)) { echo $dni; } ?>" class="input-2" maxlength="8" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
            <div class="campo-txt">Número de CUIL *</div>
        	<div class="campo-txt m30">Calle *</div>
        	<div class="campo-txt2 m30">Nro</div>
        	<div class="campo-txt2 m11">Depto</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="cuil" value="<?php if (isset($cuil)) { echo $cuil; } ?>" class="input-2" maxlength="11" /></div>
        	<div class="campo-input m30"><input type="text" name="calle" value="<?php if (isset($calle)) { echo $calle; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input2 m30"><input type="text" name="nro" value="<?php if (isset($nro)) { echo $nro; } ?>" class="input-3" maxlength="15" /></div>
        	<div class="campo-input2 m11"><input type="text" name="depto" value="<?php if (isset($depto)) { echo $depto; } ?>" class="input-3" maxlength="15" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Provincia *</div>
        	<div class="campo-txt m30">Localidad *</div>
        	<div class="campo-txt m30">Codigo Postal</div>
            <div class="clear"></div>
            <div class="campo-select">
            	<select name="provincia" onchange="htmlData('localidades.php', 'id='+this.value)" class="select-3">
            	<option value="0" selected>Seleccionar...</option>
				<?php 
				$sql = "SELECT provincia_id, provincia_nombre FROM provincias ORDER BY provincia_nombre Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($provincia == $resultado["provincia_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["provincia_id"]."'>".$resultado["provincia_nombre"]."</option>\n";
				}
				?>
            	</select>
            </div>
             <div class="campo-select m30">
            	<span id="localidades"><select name="localidad_id" <?php if ($provincia == 0) { echo "disabled='disabled'"; } ?> class="select-3">
            	<option value="0" selected>Seleccionar...</option>
 				<?php 
				if ($provincia != 0) {
					$sql = "SELECT localidad_id, localidad_nombre FROM localidades WHERE localidad_provincia_id = $provincia ORDER BY localidad_nombre Asc";
					$consulta = consulta($sql,$conexion);
					while ($resultado = resultado($consulta)) {
					$check = ($localidad_id == $resultado["localidad_id"]) ? "selected" : "";
					echo "<option {$check} value='".$resultado["localidad_id"]."'>".$resultado["localidad_nombre"]."</option>\n";
					}
				}
				?>
            	</select></span>
            </div>
        	<div class="campo-input m30"><input type="text" name="cp" value="<?php if (isset($cp)) { echo $cp; } ?>" class="input-2" maxlength="15" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Teléfono</div>
        	<div class="campo-txt m30">Celular</div>
        	<div class="campo-txt m30">E-mail</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="telefono" value="<?php if (isset($telefono)) { echo $telefono; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="celular" value="<?php if (isset($celular)) { echo $celular; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" class="input-2" maxlength="80" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Sección *</div>
        	<div class="campo-txt m30">Responsable (solo para menores de 18 años)</div>
        	<div class="campo-txt m30"></div>
            <div class="clear"></div>
            <div class="campo-select">
            	<select name="seccion" class="select-3">
            	<option value="0" selected>Seleccionar...</option>
				<?php 
				$sql = "SELECT seccion_id, seccion_nombre FROM matricula_secciones ORDER BY seccion_orden Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($seccion == $resultado["seccion_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["seccion_id"]."'>".$resultado["seccion_nombre"]."</option>\n";
				}
				?>
            	</select>
            </div>
        	<div class="campo-input m30"><input type="text" name="responsable" value="<?php if (isset($responsable)) { echo $responsable; } ?>" class="input-2" maxlength="50" readonly="readonly" /></div>
            <div class="ico_editar2 m5 p5"><a href="" class="edit-resp" title="Editar responsable">Editar responsable</a></div>
            <div class="ico_eliminar2 p5"><a href="javascript:borrar_responsable();" title="Desvincular Responsable">Desvincular Responsable</a></div>
        	<div class="campo-seleccionar p5"><a href="" class="sel-resp">> Seleccionar responsable</a> <a href="" class="resp" title="">> Cargar nuevo</a></div>
            <div class="clear"></div>
            <div class="sep30"></div>
            <div class="obligatorios">* Los campos con asterisco son obligatorios</div>
			<div class="boton p10"><input type="image" src="../images/bt_guardar.jpg" title="Guardar" value="" /></div>
			<div class="boton"><a href="javascript:history.go(-1);"><img src="../images/bt_volver.jpg" width="100"  height="26" alt="" /></a></div>
            <div class="clear-b"></div>
        </div><!-- fin formulario -->
        </form>
    </div><!-- fin cuadro-lista -->
</div><!-- fin centro -->
<?php include('../includes/comun/pie.inc.php'); ?>