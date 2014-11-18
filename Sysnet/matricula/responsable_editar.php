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
$provincia = 0;
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
$buscar = isset($_GET["buscar"]) ? htmlspecialchars($_GET["buscar"]) : "";
$pag = isset($_GET["pg"]) ? (is_numeric($_GET["pg"]) ? $_GET["pg"] : 0) : 0;
$cerrar = isset($_GET["cerrar"]) ? (is_numeric($_GET["cerrar"]) ? $_GET["cerrar"] : 0) : 0;
$idseleccionado = isset($_GET["idseleccionado"]) ? (is_numeric($_GET["idseleccionado"]) ? $_GET["idseleccionado"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();
	
if (!isset($_POST["accion"])) {
	$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;
	
	//levanto datos del responsable a editar
	$sql = "SELECT responsable_id,responsable_localidad_id,responsable_nombre,responsable_apellido,responsable_dni,responsable_cuil,responsable_calle,responsable_nro,responsable_depto,responsable_cp,responsable_tel,responsable_cel,responsable_email FROM matricula_responsables WHERE responsable_id = '$id'";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);

	if (!$resultado["responsable_id"]) {
		header ("Location: seleccionar_responsable.php?pg={$pag}&buscar={$buscar}");
		exit;	
	} else {
		$localidad_id = $resultado["responsable_localidad_id"];;
		$nombre = $resultado["responsable_nombre"];
		$apellido = $resultado["responsable_apellido"];
		$dni = $resultado["responsable_dni"];
		$cuil = $resultado["responsable_cuil"];
		$calle = $resultado["responsable_calle"];
		$nro = $resultado["responsable_nro"];
		$depto = $resultado["responsable_depto"];
		$cp = $resultado["responsable_cp"];
		$telefono = $resultado["responsable_tel"];
		$celular = $resultado["responsable_cel"];
		$email = $resultado["responsable_email"];
		
		$sql = "SELECT localidad_provincia_id FROM localidades WHERE localidad_id = {$localidad_id}";
		$consulta = consulta($sql,$conexion);
		$resultado = resultado($consulta);
		$provincia = $resultado["localidad_provincia_id"];
	}
} else {
	foreach($_POST as $k => $v) {$$k = $v;}
	
	//compruebo que no haya responsable con ese email
	if ($email != "") {
	$sql = "SELECT responsable_id FROM matricula_responsables WHERE responsable_email = '$email' AND responsable_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 9; }
	}
	
	//compruebo que no haya responsable con ese cuil
	$sql = "SELECT responsable_id FROM matricula_responsables WHERE responsable_cuil = '$cuil' AND responsable_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 8; } 
	
	//compruebo que no haya responsable con ese dni
	$sql = "SELECT responsable_id FROM matricula_responsables WHERE responsable_dni = '$dni' AND responsable_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 7; } 

	//actualizo en la bd
	if ($msj == 0) {
		$apellido = strtr(strtoupper($apellido),"áéíóúçñäëïöü","AEIOUÇÑÄËÏÖÜ");
		$nombre = strtr(strtolower($nombre),"AEIOUÇÑÄËÏÖÜ","áéíóúçñäëïöü");
		$nombre = mb_convert_case($nombre, MB_CASE_TITLE);
		
		$sql = "UPDATE matricula_responsables SET responsable_localidad_id='$localidad_id',responsable_nombre='$nombre',responsable_apellido='$apellido',responsable_dni='$dni',responsable_cuil='$cuil',responsable_calle='$calle',responsable_nro='$nro',responsable_depto='$depto',responsable_cp='$cp',responsable_tel='$telefono',responsable_cel='$celular',responsable_email='$email' WHERE responsable_id = $id";
		consulta($sql,$conexion);
		
		if ($buscar != "") { $buscar = $dni; }
		
		if ($cerrar == 0) {
		?>
		<script>
		window.top.tb_remove2('seleccionar_responsable.php?pg=<?php echo $pag; ?>&buscar=<?php echo $buscar; ?>&id=<?php echo $idseleccionado; ?>&msj=56&KeepThis=true&TB_iframe=true&height=418&width=569');
		</script>
		<?php
		} else { ?>
   		<script>
		ape = '<?php echo $apellido." ".$nombre; ?>';
		parent.document.cargar.responsable.value = ape;
       	window.top.tb_remove();
		</script>
		<?php }
		exit;
	}
}
?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Editar Responsable</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/responsable.css" rel="stylesheet" type="text/css" />
        <script src='../js/funciones.js' type='text/javascript'></script>
		<script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
	</head>
    <body>
    <div id="contenedor">
    	<div class="sep10"></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="../images/cerrar.jpg" width="14" height="15" /></a></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Editar responsable</div>
        	</div><!-- fin cuadro encabezado -->
            <form name="cargar_resp" method="POST" autocomplete="off" action="responsable_editar.php?pg=<?php echo $pag;?>&buscar=<?php echo $buscar;?>" onSubmit="return validarresponsable();">
            <input type="hidden" value="<?php echo $id; ?>" name="id">
        	<input type="hidden" value="1" name="accion">
        	<input type="hidden" value="<?php echo $cerrar; ?>" name="cerrar">
        	<input type="hidden" value="<?php echo $idseleccionado; ?>" name="idseleccionado">
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
        	<div class="campo-input2 m30"><input type="text" name="nro" value="<?php if (isset($nro) && ($nro != 0)) { echo $nro; } ?>" class="input-3" maxlength="15" /></div>
        	<div class="campo-input2 m11"><input type="text" name="depto" value="<?php if (isset($depto)) { echo $depto; } ?>" class="input-3" maxlength="15" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Provincia *</div>
        	<div class="campo-txt m30">Localidad *</div>
        	<div class="campo-txt m30">Codigo Postal</div>
            <div class="clear"></div>
            <div class="campo-select">
            	<select name="provincia" onChange="htmlData('localidades.php', 'id='+this.value)" class="select-3">
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
            <div class="campo-input"><input type="text" name="telefono" value="<?php if (isset($telefono) && ($telefono != 0)) { echo $telefono; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="celular" value="<?php if (isset($celular) && ($celular != 0)) { echo $celular; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" class="input-2" maxlength="80" /></div>
            <div class="clear"></div>
            <div class="sep30"></div>
            <div class="obligatorios">* Los campos con asterisco son obligatorios</div>
            <div class="error"><?php if ($msj != 0) {?><?php echo $muestro; ?><?php } ?></div>
			<div class="boton p10"><input type="image" src="../images/bt_guardar.jpg" title="Guardar" value="" /></div>
			<?php if ($cerrar == 0) { ?><div class="boton"><a href="javascript:window.top.tb_remove2('seleccionar_responsable.php?pg=<?php echo $pag; ?>&buscar=<?php echo $buscar; ?>&id=<?php echo $idseleccionado; ?>&KeepThis=true&TB_iframe=true&height=418&width=569');"><img src="../images/bt_volver.jpg" width="100"  height="26" alt="" /></a></div><?php } ?>
            <div class="clear-b"></div>
        </div><!-- fin formulario -->
        </form> 
       	</div><!-- fin cuadro-lista -->
    </div><!-- fin contenedor -->
    <script type="text/javascript">
	<!-- // --><![CDATA[
	$(document).ready(function(){
		$("input").focus();
	}); 
	// -->
	// ]]>
	</script>
    </body>
</html>