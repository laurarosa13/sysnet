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
        <title>Configurar Secciones</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/configurar-seccion.css" rel="stylesheet" type="text/css" />
        <script src='../js/funciones.js' type='text/javascript'></script>
		<script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="../js/thickbox.js" type="text/javascript"></script>
	</head>
    <body>
    <?php	
	$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
	include('../includes/comun/mensajes.inc.php');
	?>
    <div id="contenedor">
    	<div class="sep10"></div>
        <div class="msj"><?php if ($msj != 0) {?><div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div><?php } else {?>Solo se deben agregar, editar o eliminar las secciones de alumnos regulares<?php }?></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="../images/cerrar.jpg" width="14" height="15" /></a></div>
        <div class="clear"></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Configurar secciones</div>
        		<div class="filtro-ver">
                	<div class="boton-cargar"><a href="cargar_seccion.php"><img src="../images/bt_cargar_seccion.jpg" width="140" height="20" alt="Cargar nueva sección"></a></div>
 				</div>	
                <div class="clear-b"></div>
        	</div><!-- fin cuadro encabezado -->
            <?php
			$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;
			
			include('../funciones/funciones.php'); 
			include_once("../funciones/conexion.php");
			$conexion=conectar();

			$sql= "SELECT seccion_id,seccion_nombre FROM matricula_secciones WHERE seccion_tipo = 1 ORDER BY seccion_orden Asc";
			$consulta = consulta($sql,$conexion);
			$total_usuarios = filas($consulta);
			$i = 0;
		
			if ($total_usuarios == 0) { ?>
				<div class="nohay">No se encontraron secciones de alumnos regulares cargadas en el sistema</div>
			<?php } else { ?>
            <form name="form2" method="POST">
	        <div class="cuadro-detalles">
    	        <ul class="lista-detalles">
    	        	<li class="w480">Sección</li>
    	        	<li class="w64">Acciones</li>
    	        </ul>
        	    <div class="clear"></div>
        	</div><!-- fin cuadro detalles -->
            <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
			?>
            <div class="<?php if ((esPar($i))!=1) { echo "check-all"; } else { echo "check-all-gris"; } ?>"></div>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w480"><?php echo $resultado["seccion_nombre"];?></li>
            	<li class="w64">
                	<div class="ico_editar"><a href="editar_seccion.php?id=<?php echo $resultado["seccion_id"];?>" title="Editar">Editar</a></div>
                	<div class="ico_eliminar"><a href="eliminar_seccion.php?id=<?php echo $resultado["seccion_id"];?>" title="Eliminar" onclick="return confirm('¿Esta seguro que desea eliminar la sección <?php echo $resultado['seccion_nombre']; ?>?');">Eliminar</a></div>
                </li>
            </ul>
            <div class="clear"></div>
            <?php } ?>
			<!-- fin repetir -->
            <div class="sep10"></div>
            </div><!-- fin cuadro-resultados -->
        	</form>
            <?php } ?>
       	</div><!-- fin cuadro-lista -->
        <div class="clear"></div>
        <div class="sep20"></div>
    </div><!-- fin contenedor -->
    <script type="text/javascript">
	<!-- // --><![CDATA[
	$(document).ready(function(){
        $('.lista-resultados').hover(function(){
            if($(this).hasClass('fgris')){
           $(this).find('li').css({'background-color':'#F0EFF5'});}else{
           $(this).find('li').css({'background-color':'#FBFBFB'});
           }
        },function(){
            if($(this).hasClass('fgris')){
           $(this).find('li').css({'background-color':'#F6F6F6'});}else{
           $(this).find('li').css({'background-color':'#FFF'});
           }
    	});  
	}); 
	// -->
	// ]]>
	</script>
    </body>
</html>