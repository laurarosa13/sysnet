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
include("../includes/comun/session.php");  ?>
<?php include("../includes/comun/privilegio.php"); ?>
<?php
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
$filtro = isset($_GET["filtro"]) ? (is_numeric($_GET["filtro"]) ? $_GET["filtro"] : 0) : 0;
$pag = isset($_GET["pg"]) ? (is_numeric($_GET["pg"]) ? $_GET["pg"] : 0) : 0;

if (!isset($_POST["accion"])) {
	$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//levanto datos del usuario a editar
	$sql = "SELECT usuario_id,usuario_apellido,usuario_nombre,usuario_dni,usuario_tel,usuario_cel,usuario_email,usuario_privilegio FROM usuarios WHERE usuario_id = '$id'";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);
	if (!$resultado["usuario_id"]) {
		header ("Location: index.php?filtro={$filtro}&p={$pag}");
		exit;	
	} else {
		$apellido = $resultado["usuario_apellido"];
		$nombre = $resultado["usuario_nombre"];
		$dni = $resultado["usuario_dni"];
		$telefono = $resultado["usuario_tel"];
		$celular = $resultado["usuario_cel"];
		$email = $resultado["usuario_email"];
		$privilegio = $resultado["usuario_privilegio"];
	}
} else {
	foreach($_POST as $k => $v) {$$k = $v;}

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//compruebo que no haya usuario con ese dni
	$sql = "SELECT usuario_id FROM usuarios WHERE usuario_dni = '$dni' AND usuario_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 20; } 

	//guardo en la bd
	if ($msj == 0) {
		$apellido = strtr(strtoupper($apellido),"������������","AEIOU�������");
		$nombre = strtr(strtolower($nombre),"AEIOU�������","������������");
		$nombre = mb_convert_case($nombre, MB_CASE_TITLE);
		
		if (($clave1 != "") AND ($clave2 != "")) {
			$clave_encriptada = md5($clave1);
			$sql = "UPDATE usuarios SET usuario_apellido='$apellido',usuario_nombre='$nombre',usuario_dni='$dni',usuario_tel='$telefono',usuario_cel='$celular',usuario_email='$email',usuario_privilegio='$privilegio',usuario_clave='$clave_encriptada' WHERE usuario_id = $id";
		} else {
			$sql = "UPDATE usuarios SET usuario_apellido='$apellido',usuario_nombre='$nombre',usuario_dni='$dni',usuario_tel='$telefono',usuario_cel='$celular',usuario_email='$email',usuario_privilegio='$privilegio' WHERE usuario_id = $id";
		}
		consulta($sql,$conexion);
		header ("Location: index.php?filtro={$filtro}&p={$pag}&msj=66");
		exit;
	}
}
?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Editar usuario</div>
        </div><!-- fin cuadro encabezado --> 
        <form name="cargar" method="POST" autocomplete="off" action="editar.php?filtro=<?php echo $filtro;?>&p=<?php echo $pag;?>" onsubmit="return validarusuario();">
        <input type="hidden" value="1" name="accion">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <?php if ($_SESSION["id_usuario"] == $id) {?>
        <input type="hidden" value="10" name="privilegio">
        <?php } ?>
		<div class="formulario">
        	<div class="campo-txt">Apellido *</div>
        	<div class="campo-txt m30">Nombres *</div>
        	<div class="campo-txt m30">N�mero de DNI *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="apellido" value="<?php if (isset($apellido)) { echo $apellido; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="nombre" value="<?php if (isset($nombre)) { echo $nombre; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="dni" value="<?php if (isset($dni)) { echo $dni; } ?>" class="input-2" maxlength="8" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Tel�fono</div>
        	<div class="campo-txt m30">Celular</div>
        	<div class="campo-txt m30">E-mail</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="telefono" value="<?php if ((isset($telefono)) AND ($telefono != 0)) { echo $telefono; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="celular" value="<?php if ((isset($celular)) AND ($celular !=0)) { echo $celular; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" class="input-2" maxlength="80" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Privilegio *</div>
        	<div class="campo-txt m30">Contrase�a</div>
        	<div class="campo-txt m30">Repetir contrase�a</div>
            <div class="clear"></div>
            <div class="campo-select">
            	<select name="privilegio" <?php if ($_SESSION["id_usuario"] == $id) { echo "disabled='disabled'"; } ?> class="select-3">
            	<option value="0" selected>Seleccionar...</option>
            	<option value="10" <?php if ((isset($privilegio)) AND ($privilegio == 10)) { echo "selected"; } ?>>Administrador</option>
            	<option value="1" <?php if ((isset($privilegio)) AND ($privilegio == 1)) { echo "selected"; } ?>>Operador</option>
            	</select>
            </div>
        	<div class="campo-input m30"><input type="password" name="clave1" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="password" name="clave2" class="input-2" maxlength="50" /></div>
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