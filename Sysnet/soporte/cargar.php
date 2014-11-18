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
<?php $menu_posicion = 4; ?>
<?php
$netbook_id = 0;
$estado_id = 0;
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;

if (isset($_POST["accion"])) {
	foreach($_POST as $k => $v) {$$k = $v;}

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//compruebo que no haya otra solicitud para esta netbook
	if ($netbook_id != 0) {
	$sql = "SELECT soporte_id FROM soporte WHERE soporte_netbook_id = '$netbook_id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 19; }
	}
	

	//compruebo que no haya soporte con ese numero de caso
	if ($caso != "") {
	$sql = "SELECT soporte_id FROM soporte WHERE soporte_nro_caso = '$caso' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 18; }
	}
	
	//paso fecha a formato para el js
	$dia1 = date('d');
	$mes1 = date('m');
	$ano1 = date('Y');
	

	//calculo timestamp de hoy
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	$timestamp2 = strtotime($fecha);
		
	//resto a una fecha la otra 
	$segundos_diferencia = $timestamp2 - $timestamp1; 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
	$fecha = floor($dias_diferencia);

	//guardo en la bd
	if ($msj == 0) {

		$descripcion = addslashes($descripcion);
		$reclamo = addslashes($reclamo);		
		$sql = "INSERT INTO soporte (soporte_nro_caso,soporte_netbook_id,soporte_estado_id,soporte_fecha_solicitud,soporte_descripcion,soporte_reclamo) VALUES ('$caso','$netbook_id','$estado_id','$timestamp2','$descripcion','$reclamo')";
		consulta($sql,$conexion);
		
		//cambio el estado de la netbook al estado que corresponda si estado soporte es 2 o 3 pongo en reparacion
		//si es 1 pongo en espera
		//si es 4 pongo en normal solo si el estado esta en 5 o 6
		if ($estado_id == 1) {
			$sql = "UPDATE netbooks SET netbook_estado_id = '5' WHERE netbook_id = $netbook_id";
			consulta($sql,$conexion);
		}
		if (($estado_id == 2) OR ($estado_id == 3)) {
			$sql = "UPDATE netbooks SET netbook_estado_id = '6' WHERE netbook_id = $netbook_id";
			consulta($sql,$conexion);
		}
		if ($estado_id == 4) {
			$sql = "UPDATE netbooks SET netbook_estado_id = '1' WHERE netbook_id = $netbook_id";
			consulta($sql,$conexion);
		}
		
		header ("Location: index.php?msj=61");
		exit;
	}
}
?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<script src="../js/jquery.tools.min.js" type="text/javascript"></script>
<script src="../js/thickbox.js" type="text/javascript"></script>
<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    $(document).ready(function(){
         $('.sel-resp').click(function (event){
            event.preventDefault();
			seleccionado = document.cargar.netbook_id.value;
            tb_show('','seleccionar_netbook.php?id='+seleccionado+'&amp;KeepThis=true&amp;TB_iframe=true&amp;height=418&amp;width=569');
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
        	<div class="cuadro-titulo">Cargar solicitud de soporte</div>
        </div><!-- fin cuadro encabezado --> 
        <form name="cargar" method="POST" autocomplete="off" action="cargar.php" onsubmit="return validarsoporte();">
        <input type="hidden" value="1" name="accion">
        <input type="hidden" value="<?php echo $netbook_id; ?>" name="netbook_id">
		<div class="formulario">
        	<div class="campo-txt">Nro de Caso *</div>
        	<div class="campo-txt m30">Estado *</div>
        	<div class="campo-txt m30">Fecha de Solicitud *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="caso" value="<?php if (isset($caso)) { echo $caso; } ?>" class="input-2" maxlength="50" /></div>
            <div class="campo-select m30">
            	<select name="estado_id" class="select-3" onchange="divreclamo(this.value);">
            	<option value="0" selected>Seleccionar...</option>
				<?php 
				$sql = "SELECT estado_id, estado_nombre FROM soporte_estados ORDER BY estado_id Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($estado_id == $resultado["estado_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["estado_id"]."'>".$resultado["estado_nombre"]."</option>\n";
				}
				?>
            	</select>
            </div>
        	<div class="campo-input m30"><input type="date" name="fecha" value="<?php if (isset($fecha)) { echo $fecha; } ?>" class="input-2 dati" maxlength="50" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Netbook *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="netbook" value="<?php if (isset($netbook)) { echo $netbook; } ?>" class="input-2" maxlength="50" readonly="readonly" /></div>
            <div class="ico_eliminar m5 p5"><a href="javascript:borrar_netbook();" title="Desvincular netbook">Desvincular netbook</a></div>
        	<div class="campo-seleccionar p5"><a href="" class="sel-resp">> Seleccionar netbook</a></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Descripción del Problema *</div>
            <div class="clear"></div>
            <div class="campo-textarea"><textarea name="descripcion" class="textarea-1"><?php if (isset($descripcion)) { echo $descripcion; } ?></textarea></div>
            <div class="clear"></div>
            <div id="flotante" style="display:<?php if ($estado_id == 3) { echo "display"; } else { echo "none";} ?>"> 
            <div class="sep20"></div>
        	<div class="campo-txt">Detalles de Reclamo</div>
            <div class="clear"></div>
            <div class="campo-textarea"><textarea name="reclamo" class="textarea-1"><?php if (isset($reclamo)) { echo $reclamo; } ?></textarea></div>
			</div><!-- fin div flotante  -->
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
<script type="text/javascript">
<!-- // --><![CDATA[
    $.tools.dateinput.localize("es",  {
        months:        'enero,febrero,marzo,abril,mayo,junio,julio,' +
            'agosto,septiembre,octubre,noviembre,diciembre',
        shortMonths:   'ene,feb,mar,abr,may,jun,jul,' +
            'ago,sep,oct,nov,dic',
        days:          'domingo,lunes,martes,miercoles,jueves,viernes,sabado',
        shortDays:     'dom,lun,mar,mie,jue,vie,sab'
    });
	$(".dati").dateinput({lang:'es',format: 'dd-mm-yyyy'});
// -->
// ]]>
</script>
<?php include('../includes/comun/pie.inc.php'); ?>