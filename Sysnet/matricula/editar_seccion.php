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
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();
	
if (!isset($_POST["accion"])) {
	//levanto los datos de la seccion
	$sql = "SELECT seccion_nombre FROM matricula_secciones WHERE seccion_id = {$id}";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);
	$nombre = $resultado['seccion_nombre'];
} else {
	foreach($_POST as $k => $v) {$$k = $v;}
	
	//compruebo que no haya seccion con el mismo nombre
	$sql = "SELECT seccion_nombre FROM matricula_secciones WHERE seccion_nombre = '$nombre' AND seccion_id != '$id' LIMIT 0,1";
	$consulta = consulta($sql,$conexion);
	if (filas($consulta)) { $msj = 26; } 

	//actualizo en la bd
	if ($msj == 0) {
		$nombre = strtr(strtolower($nombre),"AEIOUÇÑÄËÏÖÜ","áéíóúçñäëïöü");
		$nombre = mb_convert_case($nombre, MB_CASE_TITLE);
		
		$sql = "UPDATE matricula_secciones SET seccion_nombre='$nombre' WHERE seccion_id = $id";
		consulta($sql,$conexion);

		//refrescar pagina principal
    	?>
		<script type="text/javascript">
		<!-- // --><![CDATA[
		parent.document.location.href = "index.php?msj2=72";
		// -->
		// ]]>
		</script>
    	<?php
		//header ("Location: configurar_secciones.php?msj=72");
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
        <title>Editar Sección</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/configurar-seccion.css" rel="stylesheet" type="text/css" />
        <script src='../js/funciones.js' type='text/javascript'></script>
	</head>
    <body>
    <div id="contenedor">
    	<div class="sep10"></div>
        <div class="msj"><?php if ($msj != 0) {?><div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div><?php } ?></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="../images/cerrar.jpg" width="14" height="15" /></a></div>
        <div class="clear"></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Editar sección</div>
        	</div><!-- fin cuadro encabezado -->
    		<div class="sep10"></div>
	        <div class="cuadro-form">
    	    <form name="cargar_seccion" method="POST" autocomplete="off" action="editar_seccion.php" onSubmit="return validarseccion();">
            <input type="hidden" value="<?php echo $id; ?>" name="id">
        	<input type="hidden" value="1" name="accion">
            <div class="campo-txt">Nombre de la sección</div>
			<div class="campo-input"><input type="text" name="nombre" value="<?php if (isset($nombre)) { echo $nombre; } ?>" class="input-2" maxlength="20" /></div>
            <div class="sep20"></div>
            <div class="boton p10"><input type="image" src="../images/bt_guardar.jpg" title="Guardar" value="" /></div>
 			<div class="boton"><a href="configurar_secciones.php"><img src="../images/bt_volver.jpg" width="100"  height="26" alt="" /></a></div>
 			<div class="clear-b"></div>
            </form>
           </div><!-- fin cuadro form -->
           <div class="sep10"></div>
       	</div><!-- fin cuadro-lista -->
        <div class="clear"></div>
        <div class="sep20"></div>
    </div><!-- fin contenedor -->
    </body>
</html>