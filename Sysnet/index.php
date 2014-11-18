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
session_cache_limiter('nochache,private');
session_start();
$msjerror = 0;

include("funciones/conexion.php");
$conexion=conectar();
	
if (isset($_POST["dni"]) AND isset($_POST["clave"])) {

	$dni = mysql_real_escape_string(trim(strtoupper($_POST['dni'])));
	$clave = mysql_real_escape_string($_POST['clave']);
	$clave_encriptada = md5($clave);
	
	$sql = "SELECT usuario_id,usuario_privilegio,usuario_nombre,usuario_apellido FROM usuarios WHERE usuario_dni='$dni' AND usuario_clave = '$clave_encriptada' LIMIT 0,1";

	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);

	if (filas($consulta)) {
			$_SESSION["id_usuario"] = $resultado["usuario_id"];
			$_SESSION["nombre_usuario"] = $resultado["usuario_nombre"];
			$_SESSION["apellido_usuario"] = $resultado["usuario_apellido"];
			cerrar($conexion);
			header ("Location: home/"); 
			exit;
	} else {
		mysql_free_result($consulta);
		unset($dni,$clave,$_POST["action"]);
		session_destroy();
        $msjerror = 1;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="no" />
	<title>Sysnet - Sistema de Administración de Netbooks</title>
	<meta name="ROBOTS" content="NOODP" />
	<meta name="KEYWORDS" content="" />
	<meta name="DESCRIPTION" content="" />
	<meta name="robots" content="index,follow" />
	<meta name="author" content="Laura Rosa" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link href="estilos/reset.css" rel="stylesheet" type="text/css" />
	<link href="estilos/estilos-ingreso.css" rel="stylesheet" type="text/css" />
	<link href="estilos/thickbox.css" rel="stylesheet" type="text/css" />
	<script src='js/funciones.js' type='text/javascript'></script>
</head>
<body>
<?php 
//programacion de pantalla de bienvenida en caso que no haya usuarios del sistema
$sql = "SELECT usuario_id FROM usuarios LIMIT 0,1";
$consulta = consulta($sql,$conexion);
if (!filas($consulta)) {
	?>
	<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="js/thickbox.js" type="text/javascript"></script>
	<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    $(document).ready(function(){
		tb_show('','bienvenida.php?KeepThis=true&amp;TB_iframe=true&amp;height=395&amp;width=569');
	});
    // ]]>
	</script>
<?php } ?>
<div id="contenedor">  
	<div id="encabezado">
    	<div id="logo"><a href="index.php"><img src="images/logo.jpg" title="Ingreso" alt="Ingreso" /></a></div>
        <div id="conectar"><a href="http://www.conectarigualdad.gob.ar/" target="_blank" title="Conectar Igualdad"><img src="images/logo_conectar.jpg" width="167" height="102" alt="Conectar Igualdad" /></a></div>
		<div class="clear-b"></div>
    </div>
	<div class="sep10"></div>
	<div id="centro">
    	<div id="ingreso-top"></div>
    	<div id="ingreso-centro">
        	<form name="ingreso" autocomplete="on" action="index.php" method="POST" onSubmit="return validaringreso();">
        	<div id="ingreso-form">
            	<div class="txt-campo">DNI</div>
                <div class="input-campo"><input type="text" value="<?php if (isset($_POST["dni"])) { echo $_POST["dni"]; }?>" name="dni" class="input-1" maxlength="8" /></div>
				<div class="sep20"></div>
            	<div class="txt-campo">Contraseña</div>
                <div class="input-campo"><input type="password" name="clave" class="input-1" maxlength="50" /></div>
				<div class="sep20"></div>
                <div class="incorrectos-campo"><?php if($msjerror == 1) { echo "Datos de ingreso incorrectos"; } ?></div>
                <div class="ingresar-campo"><input type="image" value="" title="Ingresar" src="images/bt_ingresar.jpg" /></div>
				<div class="clear"></div>
				<div class="sep20"></div>
            </div>
            </form>
            <div class="linea"></div>
            <div class="txt-recuperar">Sysnet v1.0 - ©2015 Laura Rosa</div>
        </div>
    	<div id="ingreso-pie"></div>
    </div>
	<div class="clear"></div>
	<div class="sep20"></div>
</div><!--fin contenedor-->
</body>
</html>