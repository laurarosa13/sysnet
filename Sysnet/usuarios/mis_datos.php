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
$user_datos = 1;
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;

if (!isset($_POST["accion"])) {
	$id = $_SESSION['id_usuario'];

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//levanto datos del usuario a editar
	$sql = "SELECT usuario_id,usuario_apellido,usuario_nombre,usuario_dni,usuario_tel,usuario_cel,usuario_email FROM usuarios WHERE usuario_id = '$id'";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);

	if (!$resultado["usuario_id"]) {
		header ("Location: index.php");
		exit;	
	} else {
		$apellido = $resultado["usuario_apellido"];
		$nombre = $resultado["usuario_nombre"];
		$dni = $resultado["usuario_dni"];
		$telefono = $resultado["usuario_tel"];
		$celular = $resultado["usuario_cel"];
		$email = $resultado["usuario_email"];
	}
} else {
	foreach($_POST as $k => $v) {$$k = $v;}

	include_once("../funciones/conexion.php");
	$conexion=conectar();

	//guardo en la bd
	if ($msj == 0) {
		if (($clave1 != "") AND ($clave2 != "")) {
			$clave_encriptada = md5($clave1);
			$sql = "UPDATE usuarios SET usuario_tel='$telefono',usuario_cel='$celular',usuario_email='$email',usuario_clave='$clave_encriptada' WHERE usuario_id = $id";
		} else {
			$sql = "UPDATE usuarios SET usuario_tel='$telefono',usuario_cel='$celular',usuario_email='$email' WHERE usuario_id = $id";
		}
		consulta($sql,$conexion);
		
		header ("Location: ../home/index.php?msj=69");
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
        	<div class="cuadro-titulo">Editar mis datos</div>
        </div><!-- fin cuadro encabezado --> 
        <form name="cargar" method="POST" autocomplete="off" action="mis_datos.php" onsubmit="return validarmisdatos();">
        <input type="hidden" value="1" name="accion">
        <input type="hidden" value="<?php echo $id; ?>" name="id">
		<div class="formulario">
        	<div class="campo-txt">Apellido *</div>
        	<div class="campo-txt m30">Nombres *</div>
        	<div class="campo-txt m30">Número de DNI *</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="apellido" readonly value="<?php if (isset($apellido)) { echo $apellido; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="nombre" readonly value="<?php if (isset($nombre)) { echo $nombre; } ?>" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="text" name="dni" readonly value="<?php if (isset($dni)) { echo $dni; } ?>" class="input-2" maxlength="50" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt">Teléfono</div>
        	<div class="campo-txt m30">Celular</div>
        	<div class="campo-txt m30">E-mail</div>
            <div class="clear"></div>
            <div class="campo-input"><input type="text" name="telefono" value="<?php if ((isset($telefono)) AND ($telefono != 0)) { echo $telefono; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="celular" value="<?php if ((isset($celular)) AND ($celular !=0)) { echo $celular; } ?>" class="input-2" maxlength="18" /></div>
        	<div class="campo-input m30"><input type="text" name="email" value="<?php if (isset($email)) { echo $email; } ?>" class="input-2" maxlength="80" /></div>
            <div class="clear"></div>
            <div class="sep20"></div>
        	<div class="campo-txt"></div>
        	<div class="campo-txt m30">Contraseña</div>
        	<div class="campo-txt m30">Repetir contraseña</div>
            <div class="clear"></div>
            <div class="campo-select">Si no desea modificar su contraseña deje ambos campos vacios</div>
        	<div class="campo-input m30"><input type="password" name="clave1" class="input-2" maxlength="50" /></div>
        	<div class="campo-input m30"><input type="password" name="clave2" class="input-2" maxlength="50" /></div>
            <div class="clear"></div>
            <div class="sep30"></div>
            <div class="obligatorios">* Los campos con asterisco son obligatorios</div>
			<div class="boton"><input type="image" src="../images/bt_guardar.jpg" title="Guardar" value="" /></div>
            <div class="clear-b"></div>
        </div><!-- fin formulario -->
        </form>
    </div><!-- fin cuadro-lista -->
</div><!-- fin centro -->
<?php include('../includes/comun/pie.inc.php'); ?>