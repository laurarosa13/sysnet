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
include_once("funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT usuario_id FROM usuarios LIMIT 0,1";
$consulta = consulta($sql,$conexion);
if (filas($consulta)) { 
		header ("Location: index.php");
		exit;
} elseif (isset($_POST["accion"])) {
	foreach($_POST as $k => $v) {$$k = $v;}

	//guardo en la bd
	$apellido = strtr(strtoupper($apellido),"áéíóúçñäëïöü","AEIOUÇÑÄËÏÖÜ");
	$nombre = strtr(strtolower($nombre),"AEIOUÇÑÄËÏÖÜ","áéíóúçñäëïöü");
	$nombre = mb_convert_case($nombre, MB_CASE_TITLE);
		
	$clave_encriptada = md5($clave1);
	$sql = "INSERT INTO usuarios (usuario_apellido,usuario_nombre,usuario_dni,usuario_privilegio,usuario_clave) VALUES ('$apellido','$nombre','$dni','10','$clave_encriptada')";
	consulta($sql,$conexion);
?>	
	<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    window.top.tb_remove()
	// ]]>
	</script>
<?php
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Bienvenid@</title>
        <link href="estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="estilos/configurar-seccion.css" rel="stylesheet" type="text/css" />
        <script src='js/funciones.js' type='text/javascript'></script>
	</head>
    <body>
    <div id="contenedor">
    	<div class="sep10"></div>
        <div class="logosys"><img src="images/loguito.jpg" width="200" height="79" alt=""></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="images/cerrar.jpg" width="14" height="15" /></a></div>
        <div class="clear"></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Bienvenid@ a Sysnet</div>
        	</div><!-- fin cuadro encabezado -->
    		<div class="sep10"></div>
 	        <div class="cuadro-form">
    	    <form name="cargar" method="POST" autocomplete="off" action="bienvenida.php" onSubmit="return validaradmin();">
        	<input type="hidden" value="1" name="accion">
			<div class="bienvenida-txt">Configure los datos del usuario administrador para poder ingresar a <b>Sysnet</b></div>
            <div class="sep10"></div>
            <div class="campo-dato">Apellido</div>
            <div class="sep20h"></div>
            <div class="campo-dato">Nombre</div>
            <div class="clear"></div>
			<div class="campo-inp"><input type="text" name="apellido" value="<?php if (isset($apellido)) { echo $apellido; } ?>" class="input-3" maxlength="50" /></div>
            <div class="sep20h"></div>
			<div class="campo-inp"><input type="text" name="nombre" value="<?php if (isset($nombre)) { echo $nombre; } ?>" class="input-3" maxlength="50" /></div>
            <div class="clear"></div>
            <div class="sep10"></div>
            <div class="campo-dato">DNI</div>
            <div class="clear"></div>
			<div class="campo-inp"><input type="text" name="dni" value="<?php if (isset($dni)) { echo $dni; } ?>" class="input-3" maxlength="8" /></div>
            <div class="clear"></div> 
            <div class="sep10"></div>
            <div class="campo-dato">Contraseña</div>
            <div class="sep20h"></div>
            <div class="campo-dato">Repetir contraseña</div>
            <div class="clear"></div>
			<div class="campo-inp"><input type="password" name="clave1" class="input-3" maxlength="50" /></div>
            <div class="sep20h"></div>
			<div class="campo-inp"><input type="password" name="clave2" class="input-3" maxlength="50" /></div>
            <div class="clear"></div>
            
            <div class="sep20"></div>
 			<div class="acepto">
            	<div class="ck"><input type="checkbox" id="lei" name="acepto" class="check" /></div>
            	<div class="txt-acepto"><label for="lei">Entiendo que si no recuerdo los datos no podre acceder a Sysnet</label></div>
                <div class="clear"></div>
            </div>
            <div class="boton p10"><input type="image" src="images/bt_guardar.jpg" title="Guardar" value="" /></div>
 			<div class="clear"></div>
            </form>
           </div><!-- fin cuadro form -->
           <div class="sep10"></div>
       	</div><!-- fin cuadro-lista -->
        <div class="clear"></div>
        <div class="sep20"></div>
    </div><!-- fin contenedor -->
    </body>
</html>