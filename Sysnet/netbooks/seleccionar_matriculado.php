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
        <title>Seleccionar Matriculado</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/responsable-seleccion.css" rel="stylesheet" type="text/css" />
        <script src='../js/funciones.js' type='text/javascript'></script>
		<script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="../js/thickbox.js" type="text/javascript"></script>
	</head>
    <body>
    <?php	
	$buscar = isset($_GET["buscar"]) ? htmlspecialchars($_GET["buscar"]) : ""; 
	$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0; 
	$borroid = isset($_GET["borroid"]) ? (is_numeric($_GET["borroid"]) ? $_GET["borroid"] : 0) : 0; 
	?>
    <div id="contenedor">
    	<div class="sep10"></div>
        <div class="msj"><?php if ($buscar != "") {?><div class="exito"><span>BUSQUEDA:</span> Resultados encontrados con <b><?php echo $buscar; ?></b></div><?php } ?></div>
        <div class="cerrar"><a href="javascript:window.top.tb_remove()" title="Cerrar"><img src="../images/cerrar.jpg" width="14" height="15" /></a></div>
        <div class="clear"></div>
    	<div class="sep10"></div>
		<div class="cuadro-lista">
    		<div class="cuadro-encabezado">
        		<div class="cuadro-titulo">Seleccionar matriculado</div>
        	</div><!-- fin cuadro encabezado -->
            <?php
			$id = isset($_GET["id"]) ? (is_numeric($_GET["id"]) ? $_GET["id"] : 0) : 0;
			
			include('../funciones/funciones.php'); 
			include_once("../funciones/conexion.php");
			$conexion=conectar();

			$pag = isset($_GET["pg"]) ? (is_numeric($_GET["pg"]) ? $_GET["pg"] : 0) : 0;

			if ($buscar != "") { 
				//busqueda excata
				//$sql= "SELECT matricula_id,matricula_seccion_id,matricula_apellido,matricula_nombre,matricula_dni FROM matricula WHERE (matricula_dni = '{$buscar}' OR matricula_apellido = '{$buscar}') AND matricula_id NOT IN (SELECT netbook_matricula_id FROM netbooks)";

				//busqueda de la cadena
				$sql= "SELECT matricula_id,matricula_seccion_id,matricula_apellido,matricula_nombre,matricula_dni FROM matricula WHERE (matricula_dni like '%{$buscar}%' OR matricula_apellido like '%{$buscar}%') AND matricula_id NOT IN (SELECT netbook_matricula_id FROM netbooks)";

			} else {
				//$sql= "SELECT matricula_id,matricula_seccion_id,matricula_apellido,matricula_nombre,matricula_dni FROM matricula ORDER BY matricula_apellido Asc";
				$sql = "SELECT matricula_id,matricula_seccion_id,matricula_apellido,matricula_nombre,matricula_dni FROM matricula WHERE matricula_id NOT IN (SELECT netbook_matricula_id FROM netbooks) ORDER BY matricula_apellido Asc";
			}
			$cantidad = 10;
			$consulta = consulta($sql,$conexion);

			$total_usuarios = filas($consulta);
			$total = ceil($total_usuarios / $cantidad);

			$pagg = $pag * $cantidad;
			$pagsig = (($pag + 1) > $total) ? $total : ($pag + 1);
			$pagant = (($pag - 1) < 0) ? 0 : ($pag - 1);
			
			$sql.= " LIMIT $pagg,$cantidad";
			$consulta = consulta($sql,$conexion);
				
			$i = 0;
		
			if ($total_usuarios == 0) { ?>
				<div class="nohay">No se encontraron matriculados que no posean netbooks asignadas</div>
			<?php } else { ?>
            <form name="form2" method="POST">
	        <div class="cuadro-detalles">
    	        <ul class="lista-detalles">
    	        	<li class="w300">Apellido y Nombres</li>
    	        	<li class="w120">DNI</li>
    	        	<li class="w117">Secci�n</li>
    	        </ul>
        	    <div class="clear"></div>
        	</div><!-- fin cuadro detalles -->
            <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
				$sql2= "SELECT seccion_nombre FROM matricula_secciones WHERE seccion_id = {$resultado['matricula_seccion_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$seccion_nombre = $resultado2["seccion_nombre"];
			?>
            <input type="hidden" name="datos" value="<?php echo $resultado["matricula_apellido"]." ".$resultado["matricula_nombre"];?>" />
            <div class="<?php if ((esPar($i))!=1) { echo "check-all"; } else { echo "check-all-gris"; } ?>"><input type="radio" value="<?php echo $resultado["matricula_id"]; ?>" name="user" id="<?php echo $resultado["matricula_id"]?>" <?php if ($resultado["matricula_id"] == $id) { echo "checked"; }?> /></div>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w290"><label for="<?php echo $resultado["matricula_id"]?>"><?php echo $resultado["matricula_apellido"];?> <?php echo $resultado["matricula_nombre"];?></label></li>
            	<li class="w120"><?php echo $resultado["matricula_dni"];?></li>
            	<li class="w117"><?php echo $seccion_nombre;?></li>
            </ul>
            <div class="clear"></div>
            <?php } ?>
			<!-- fin repetir -->
            <div class="sep10"></div>
            <div class="cuadro-opciones">
                <?php if ($total > 1) { ?>
                <div class="botonera">
                	<div class="anterior"><?php if ($pagant<>$pag) { ?><a href="?pg=<?php echo $pagant;?>&id=<?php echo $id; ?>" title="Anterior">Anterior</a><?php } ?></div><!-- saco el a href si no hay anterior -->
                    <div class="pagina">P�gina&nbsp; <select name="pagina" class="select-2" onchange="document.location.href='?id=<?php echo $id; ?>&pg='+this.value;">
                		<?php for($a=1;$a<=$total;$a++){ ?>
						<option <?php if ($pag == ($a-1)) { echo "selected='selected'"; } ?> value="<?php echo ($a-1)?>"><?php echo $a?></option>
						<?php } ?>
                        </select>&nbsp; de <?php echo $total; ?></div>
                    <div class="siguiente"><?php if ($pagsig<>$total) { ?><a href="?pg=<?php echo $pagsig;?>&id=<?php echo $id; ?>" title="Siguiente">Siguiente</a><?php } ?></div><!-- saco el a href si no hay siguiente -->
                </div><!-- fin botonera -->
                <?php } ?>
                <div class="mostrando">Items <?php echo $pagg+1; ?>-<?php echo $pagg+$i; ?> de <?php echo $total_usuarios; ?></div>
                <div class="clear-b"></div>
            </div><!-- fin opciones -->
            </div><!-- fin cuadro-resultados -->
        	</form>
            <?php } ?>
       	</div><!-- fin cuadro-lista -->
        <div class="sep10"></div>
        <form name="buscador" method="get" action="seleccionar_matriculado.php" onsubmit="return buscardni();">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <div class="buscar">
        	<div class="txt-buscar">DNI o Apellido del matriculado</div>
            <div class="input-buscar"><input type="text" name="buscar" class="input-busc" maxlength="20" /></div>
            <div class="bt-buscar"><input class="submit" title="Buscar" type="image" value="" src="../images/ico_lupa.jpg"/></div>
            <?php if ($buscar != "") { ?>
            <div class="volver"><a href="seleccionar_matriculado.php?id=<?php echo $id; ?>">Volver al listado</a></div>
            <?php } ?>
        </div>
        </form>
        <?php if ($total_usuarios != 0) { ?>
        <div class="asignar"><a href="javascript:asignar();"><img src="../images/bt_asignar.jpg" width="140" height="26" alt="" /></a></div>
        <?php } ?>
        <div class="clear"></div>
        <div class="sep10"></div>
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
	function asignar(){
	var i;
	var rela;
	var datos;
	var total = document.form2.user.length;

    for (i=0;i<total;i++){ 
       if (document.form2.user[i].checked==true) { 
	   		rela = document.form2.user[i].value;
    		datos = document.form2.datos[i].value;
       		break; 
	   }
    } 

	if(typeof total=="undefined") {
		if(document.form2.user.checked==true) {
    		rela = document.form2.user.value;
    		datos = document.form2.datos.value;
		}
	} 

	if(typeof rela=="undefined") {
			alert('Error\nNo ha seleccionado ning�n responsable');
		} else {
			parent.document.cargar.matricula_id.value = rela;
			parent.document.cargar.matricula.value = datos;
			window.top.tb_remove();
		}
	}
	
	function buscardni() {
        if (document.buscador.buscar.value == "") {
            alert("Error\nNo ha ingresado el Apellido o DNI a buscar");
            document.buscador.buscar.focus();
            return false;
        }
        return true;
    }
	
	<?php if (($msj == 1) && ($borroid != 0)) { ?>
	if (parent.document.cargar.matricula_id.value == "<?php echo $borroid?>") {
		parent.document.cargar.matricula_id.value = "0";
		parent.document.cargar.matricula.value = "";
	}
	<?php } ?>
	// -->
	// ]]>
	</script>
    </body>
</html>