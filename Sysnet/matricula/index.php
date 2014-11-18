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
<?php $menu_posicion = 2; ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<?php include('../funciones/funciones.php'); ?>
<?php
$r1 = isset($_GET["r1"]) ? (is_numeric($_GET["r1"]) ? $_GET["r1"] : 1) : 1;
$buscar = isset($_GET["buscar"]) ? $_GET["buscar"] : "";
$msj2 = isset($_GET["msj2"]) ? (is_numeric($_GET["msj2"]) ? $_GET["msj2"] : 0) : 0;
?>
<script src="../js/thickbox.js" type="text/javascript"></script>
<script language='javascript' type="text/javascript">
    <!-- // --><![CDATA[
    $(document).ready(function(){
         $('.conf-seccion').click(function (event){
            event.preventDefault();
            tb_show('','configurar_secciones.php?KeepThis=true&amp;TB_iframe=true&amp;height=448&amp;width=569');
        });
	<?php if ($msj2 != 0) { ?>
            tb_show('','configurar_secciones.php?msj=<?php echo $msj2; ?>&amp;KeepThis=true&amp;TB_iframe=true&amp;height=448&amp;width=569');
			history.replaceState('','','index.php');
    <?php } ?>
	});
	window.onpopstate = function() {
		if (window.history.state !== null) {
			window.location.reload();
		}
	}
    // ]]>
</script>
<div id="centro">
    <div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        <div class="cuadro-titulo">Consultar matrícula</div>
    	</div>
        <form name="consultar" method="GET" action="seccion.php" onsubmit="return buscarnet();">
        <div class="buscar-net">
        	<div class="b-txt">Buscar por:</div>
        	<div class="b-radio"><input type="radio" name="r1" value="1" id="codigo" <?php if ((isset($r1)) AND ($r1 == 1)) { echo "checked"; } ?> /></div>
            <div class="b-txt"><label for="codigo">Número de DNI</label></div>
        	<div class="b-radio"><input type="radio" name="r1" value="2" id="serie" <?php if ((isset($r1)) AND ($r1 == 2)) { echo "checked"; } ?> /></div>
            <div class="b-txt"><label for="serie">Apellido</label></div>
        	<div class="sep19h"></div>
            <div class="campo-input"><input type="text" name="buscar" class="input-2" maxlength="80" value="<?php if (isset($buscar)) { echo $buscar; } ?>" /></div>
			<div class="bt-buscar"><input class="submit" title="Buscar" type="image" value="" src="../images/ico_lupa.jpg"/></div>
            <?php if ($buscar != "") {?><div class="b-txt"><a href="index.php">> Mostrar el listado completo de netbooks</a></div><?php } ?>
        	<div class="clear"></div>
        </div>
        </form>
    </div>
    <div class="sep15"></div>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Matricula > Secciones</div>
            <div class="filtro-ver">
            	<div class="boton-configurar"><a href="" class="conf-seccion"><img src="../images/bt_configurar_secciones.jpg" width="140" height="20" alt="Configurar secciones"></a></div>
            </div>
            <div class="clear-b"></div>
        </div><!-- fin cuadro encabezado -->
            <?php
			include_once("../funciones/conexion.php");
			$conexion=conectar();

			$sql= "SELECT seccion_id,seccion_nombre,seccion_orden FROM matricula_secciones ORDER BY seccion_orden Asc";
			$consulta = consulta($sql,$conexion);
			$total_secciones = filas($consulta);
				
			$i = 0;
		
			if ($total_secciones == 0) { ?>
				<div class="nohay">No se encontraron secciones cargadas en la matricula</div>
			<?php } else { ?>
        <form name="listado" method="POST" action="">
        <div class="cuadro-detalles">
            <ul class="lista-detalles">
            	<li class="w756 sinseparador">Sección</li>
            	<li class="w87" style="text-align:center;padding-left:0px">Cantidad</li>
            	<li class="w87">Acciones</li>
            </ul>
            <div class="clear"></div>
        </div><!-- fin cuadro detalles -->
        <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
				
				//consulto cantidad de matriculados en la seccion
				$sql2= "SELECT matricula_id FROM matricula WHERE matricula_seccion_id = {$resultado['seccion_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$total_matriculados = filas($consulta2);
			?>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w756"><a href="seccion.php?seccion=<?php echo $resultado["seccion_id"];?>" title="Ingresar"><?php echo $resultado["seccion_nombre"];?></a></li>
            	<li class="w87" style="text-align:center;padding-left:0px"><?php echo $total_matriculados;?></li>
            	<li class="w87">
                	<div class="ico_subir"><a href="subir.php?id=<?php echo $resultado["seccion_id"];?>" title="Subir">Subir</a></div>
                	<div class="ico_bajar"><a href="bajar.php?id=<?php echo $resultado["seccion_id"];?>" title="Bajar">Bajar</a></div>
                	<div class="ico_ingresar"><a href="seccion.php?seccion=<?php echo $resultado["seccion_id"];?>" title="Ingresar">Ingresar</a></div>
                </li>
            </ul>
            <div class="clear"></div>
            <?php } ?>
			<!-- fin repetir -->
            <div class="sep10"></div>
            
            <?php } ?><!-- fin del if si no hay usuarios -->
            <div class="sep10"></div>
        </div><!-- fin cuadro resultados -->
        </form>
    </div><!-- fin cuadro-lista -->
</div><!-- fin centro -->
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
	function buscarnet() {
	if ((document.consultar.r1[0].checked == false) && (document.consultar.r1[1].checked == false))  {
		alert("Error\nNo ha seleccionado como desea filtrar la búsqueda");
		return false;
	}
	if ((document.consultar.buscar.value == "") && (document.consultar.r1[0].checked == true)) {
		alert("Error\nNo ha ingresado el número de DNI del matriculado");
		document.consultar.buscar.focus();
		return false;
	}
	if ((document.consultar.buscar.value == "") && (document.consultar.r1[1].checked == true)) {
		alert("Error\nNo ha ingresado el Apellido del matriculado");
		document.consultar.buscar.focus();
		return false;
	}
	return true;
}
// -->
// ]]>
</script>
<?php include('../includes/comun/pie.inc.php'); ?>