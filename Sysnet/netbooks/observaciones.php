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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Observaciones</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/observaciones.css" rel="stylesheet" type="text/css" />
	</head>
    <body>
    <?php	
	$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? htmlspecialchars($_GET["id"]) : 0) : 0;
	
	include_once("../funciones/conexion.php");
	$conexion=conectar();
	
	$sql = "SELECT netbook_codigo,netbook_matricula_id,netbook_observaciones FROM netbooks WHERE netbook_id = {$id}";
	$consulta = consulta($sql,$conexion);
	$resultado = resultado($consulta);
	$codigo = $resultado["netbook_codigo"];
	$matricula_id = $resultado["netbook_matricula_id"];
	$observaciones = str_replace(chr(13), "<br />", $resultado["netbook_observaciones"]);
	
	if ($matricula_id == 0) {
		$pertenece = "LIBRE";
	} else {
		$sql = "SELECT matricula_nombre,matricula_apellido FROM matricula WHERE matricula_id = {$matricula_id}";
		$consulta = consulta($sql,$conexion);
		$resultado = resultado($consulta);
		$pertenece = $resultado["matricula_apellido"]." ".$resultado["matricula_nombre"];	
	}
	?>
    <div id="contenedor">
  	<div class="sep10"></div>
        <div class="msj"></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="../images/cerrar.jpg" width="14" height="15" /></a></div>
        <div class="clear"></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Observaciones</div>
        	</div><!-- fin cuadro encabezado -->
    		<div class="sep10"></div>
            <div class="cuadro-detalles">
            	<div class="dato1">Netbook: <b><?php echo $codigo; ?></b></div>
            	<div class="dato2">Asignada: <b><?php echo $pertenece; ?></b></div>
        		<div class="clear"></div>
    			<div class="sep10"></div>
                <div>Observaciones:</div>
    			<div class="sep5"></div>
                <div><?php echo $observaciones; ?></div>
            </div><!-- fin cuadro detalles -->
            <div class="sep10"></div>
        </div><!-- fin cuadro-lista -->
        <div class="sep10"></div>
    </div><!-- fin contenedor -->
    </body>
</html>