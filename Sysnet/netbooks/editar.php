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
<?php $menu_posicion = 3; ?>
<?php
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
$estado_listado = isset($_GET["estado"]) ? (is_numeric($_GET["estado"]) ? $_GET["estado"] : 0) : 0;
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
$estado_accion = 1;
include_once("../funciones/conexion.php");
$conexion=conectar();

if (!isset($_POST["accion"])) {
	$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;

	//levanto datos de la netbook a editar
	$sql = "SELECT * FROM netbooks WHERE netbook_id = '$id'";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);

	if (!$resultado["netbook_id"]) {
		header ("Location: index.php?estado={$estado_listado}&p={$pag}");
		exit;	
	} else {
		$matricula_id = $resultado["netbook_matricula_id"];
		$estado_id = $resultado["netbook_estado_id"];
		$marca_id = $resultado["netbook_marca_id"];
		$codigo = $resultado["netbook_codigo"];
		$modelo = $resultado["netbook_modelo"];
		$serie = $resultado["netbook_num_serie"];
		$win = $resultado["netbook_num_win"];
		$office = $resultado["netbook_num_office"];
		$macaddress = $resultado["netbook_macaddress"];
		$contrato = $resultado["netbook_contrato"];
		$observaciones = $resultado["netbook_observaciones"];
		

		$sql = "SELECT matricula_apellido,matricula_nombre FROM matricula WHERE matricula_id = {$matricula_id}";
		$consulta = consulta($sql,$conexion);
		$resultado = resultado($consulta);
		$matricula = $resultado["matricula_apellido"]." ".$resultado["matricula_nombre"];
	}
} else {
	foreach($_POST as $k => $v) {$$k = $v;}

	//compruebo que no este asignada a otro
	if ($matricula_id != 0) {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_matricula_id = '$matricula_id' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 15; }
	}
	
	//compruebo que no haya netbook con ese macaddress
	if ($macaddress != "") {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_macaddress = '$macaddress' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 14; }
	}
	
	//compruebo que no haya netbook con ese num office
	if ($office != "") {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_num_office = '$office' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 13; }
	}

	//compruebo que no haya netbook con ese num win
	if ($win != "") {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_num_win = '$win' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 12; }
	}

	//compruebo que no haya netbook con ese num serie
	if ($serie != "") {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_num_serie = '$serie' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 11; }
	}

	//compruebo que no haya netbook con ese codigo
	if ($codigo != "") {
	$sql = "SELECT netbook_id FROM netbooks WHERE netbook_codigo = '$codigo' AND netbook_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 10; }
	}
	
	
	//guardo en la bd
	if ($msj == 0) {
		$codigo = strtr(strtoupper($codigo),"áéíóúÁÉÍÓÚçñäëïöü","AEIOUAEIOUÇÑÄËÏÖÜ");
		$observaciones = addslashes($observaciones);
						
		$sql = "UPDATE netbooks SET netbook_matricula_id = '$matricula_id',netbook_marca_id='$marca_id',netbook_codigo='$codigo',netbook_modelo='$modelo',netbook_num_serie='$serie',netbook_num_win='$win',netbook_num_office='$office',netbook_macaddress='$macaddress',netbook_contrato='$contrato',netbook_observaciones='$observaciones' WHERE netbook_id = $id";
		consulta($sql,$conexion);
		
		if (isset($estado_id) AND ($estado_id != 0)) {
			$sql = "UPDATE netbooks SET netbook_estado_id='$estado_id' WHERE netbook_id = $id";
			consulta($sql,$conexion);
		}
		
		header ("Location: index.php?estado={$estado_listado}&p={$pag}&msj=58");
		exit;
	}
}
$sql = "SELECT soporte_estado_id FROM soporte WHERE soporte_netbook_id = '$id'";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);
$estado_soporte = $resultado["soporte_estado_id"];
if (isset($estado_soporte) AND ($estado_soporte != 4)) {
	$estado_accion = 0;
}
?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<script src="../js/thickbox.js" type="text/javascript"></script>
<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    $(document).ready(function(){
         $('.sel-resp').click(function (event){
            event.preventDefault();
			seleccionado = document.cargar.matricula_id.value;
            tb_show('','seleccionar_matriculado.php?id='+seleccionado+'&amp;KeepThis=true&amp;TB_iframe=true&amp;height=418&amp;width=569');
        });
    });
    // ]]>
</script>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Editar netbook</div>
        </div><!-- fin cuadro encabezado --> 
        <form name="cargar" method="POST" autocomplete="off" action="editar.php?estado=<?php echo $estado_listado;?>&p=<?php echo $pag; ?>" onsubmit="return validarnetbook();">
        <input type="hidden" value="1" name="accion">
        <input type="hidden" value="<?php echo $matricula_id; ?>" name="matricula_id">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
		<div class="formulario">
        	<div class="campo-txt">Codigo *</div>
        	<div class="campo-txt m30">Marca *</div>
        	<div class="campo-txt m30">Modelo *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="codigo" value="<?php if (isset($codigo)) { echo $codigo; } ?>" class="input-2" maxlength="50" /></div>
            <div class="campo-select m30">
            	<select name="marca_id" class="select-3">
            	<option value="0" selected>Seleccionar...</option>
				<?php 
				$sql = "SELECT marca_id, marca_nombre FROM netbooks_marcas ORDER BY marca_nombre Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($marca_id == $resultado["marca_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["marca_id"]."'>".$resultado["marca_nombre"]."</option>\n";
				}
				?>
            	</select>
            </div>
        	<div class="campo-input m30"><input type="text" name="modelo" value="<?php if (isset($modelo)) { echo $modelo; } ?>" class="input-2" maxlength="50" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Número de Serie *</div>
        	<div class="campo-txt m30">Clave de producto de Windows</div>
        	<div class="campo-txt m30">Clave de producto de Office</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="serie" value="<?php if (isset($serie)) { echo $serie; } ?>" class="input-2" maxlength="90" /></div>
        	<div class="campo-input m30"><input type="text" name="win" value="<?php if (isset($win)) { echo $win; } ?>" class="input-2" maxlength="90" /></div>
        	<div class="campo-input m30"><input type="text" name="office" value="<?php if (isset($office)) { echo $office; } ?>" class="input-2" maxlength="90" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Mac Address *</div>
            <div class="campo-txt m30">Estado *</div>
            <div class="campo-txt m30">Firma del contrato *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="macaddress" value="<?php if (isset($macaddress)) { echo $macaddress; } ?>" class="input-2" maxlength="17" /></div>
            <div class="campo-select m30">
            	<select name="estado_id" class="select-3" <?php if ($estado_accion == 0) { echo "disabled"; }?>>
            	<option value="0" selected>Seleccionar...</option>
				<?php 
				$sql = "SELECT estado_id, estado_nombre FROM netbooks_estados ORDER BY estado_id Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($estado_id == $resultado["estado_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["estado_id"]."'>".$resultado["estado_nombre"]."</option>\n";
				}
				?>
            	</select>
            </div>
            <div class="campo-txt m30"><input type="radio" value="1" name="contrato" id="si" <?php if ($contrato == 1) { echo "checked";}?>>&nbsp;&nbsp;<label for="si">SI</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="contrato" id="no" <?php if (($contrato == 0) OR ($contrato == 100)) { echo "checked";}?>>&nbsp;&nbsp;<label for="no">NO</label></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Matriculado (dejar vacio si no fue asignada)</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="matricula" value="<?php if (isset($matricula)) { echo $matricula; } ?>" class="input-2" maxlength="100" readonly="readonly" /></div>
            <div class="ico_eliminar m5 p5"><a href="javascript:borrar_matricula();" title="Desvincular matriculado">Desvincular matriculado</a></div>
        	<div class="campo-seleccionar p5"><a href="" class="sel-resp">> Asignar matriculado</a></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Observaciones</div>
            <div class="clear"></div>
            <div class="campo-textarea"><textarea name="observaciones" class="textarea-1"><?php if (isset($observaciones)) { echo $observaciones; } ?></textarea></div>
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