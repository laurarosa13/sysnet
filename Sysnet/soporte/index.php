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
<?php $menu_posicion = 4; ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php
include('../funciones/funciones.php');
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
include('../includes/comun/mensajes.inc.php');
$estado = isset($_GET["estado"]) ? (is_numeric($_GET["estado"]) ? $_GET["estado"] : 0) : 0;

$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
$cantidad = 30;
			
$r1 = isset($_GET["r1"]) ? (is_numeric($_GET["r1"]) ? $_GET["r1"] : 1) : 1;
$buscar = isset($_GET["buscar"]) ? $_GET["buscar"] : "";

include_once("../funciones/conexion.php");
$conexion=conectar();
?>
<?php include('../includes/comun/top.inc.php'); ?>
<script src="../js/thickbox.js" type="text/javascript"></script>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>
    <div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        <div class="cuadro-titulo">Consultar solicitudes de soporte técnico</div>
    	</div>
        <form name="consultar" method="GET" action="index.php" onsubmit="return buscarnet();">
        <div class="buscar-net">
        	<div class="b-txt">Buscar por:</div>
        	<div class="b-radio"><input type="radio" name="r1" value="1" id="codigo" <?php if ((isset($r1)) AND ($r1 == 1)) { echo "checked"; } ?> /></div>
            <div class="b-txt"><label for="codigo">Código</label></div>
        	<div class="b-radio"><input type="radio" name="r1" value="2" id="serie" <?php if ((isset($r1)) AND ($r1 == 2)) { echo "checked"; } ?> /></div>
            <div class="b-txt"><label for="serie">Número de Caso</label></div>
        	<div class="b-radio"><input type="radio" name="r1" value="3" id="numser" <?php if ((isset($r1)) AND ($r1 == 3)) { echo "checked"; } ?> /></div>
            <div class="b-txt"><label for="numser">Número de Serie</label></div>
        	<div class="sep19h"></div>
            <div class="campo-input"><input type="text" name="buscar" class="input-2" maxlength="80" value="<?php if (isset($buscar)) { echo $buscar; } ?>" /></div>
			<div class="bt-buscar"><input class="submit" title="Buscar" type="image" value="" src="../images/ico_lupa.jpg"/></div>
            <?php if ($buscar != "") {?><div class="b-txt"><a href="index.php">> Listado completo</a></div><?php } ?>
        	<div class="clear"></div>
        </div>
        </form>
    </div>
    <div class="sep15"></div>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Soporte Técnico</div>
            <div class="filtro-ver">
            	<div class="filtro-txt">Ver estado:</div>
                <div class="filtro-input">
                <select name="estado" class="select-1" onchange="document.location.href='index.php?estado='+this.value;">
                <?php if (($r1 != 0) AND ($buscar != "")) {?><option value="10000" selected>Seleccionar...</option><?php } ?>
                <option value="0">Todos los estados...</option>
				<?php 
				$sql = "SELECT estado_id, estado_nombre FROM soporte_estados ORDER BY estado_id Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($estado == $resultado["estado_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["estado_id"]."'>".$resultado["estado_nombre"]."</option>\n";
				}
				?>
                </select>
                </div>
                <?php if ($buscar == "") {?>
                <div class="imprimir"><a href="javascript:popup('../soporte/imprimir.php?estado=<?php echo $estado; ?>&p=<?php echo $pag; ?>&cant=<?php echo $cantidad;?>','imprimir',750,600,'yes');" title="Imprimir"><img src="../images/imprimir.gif" width="24" height="23" alt="Imprimir" /></a></div>
               <?php } ?>
            </div>
            <div class="clear-b"></div>
        </div><!-- fin cuadro encabezado -->
        
            <?php
			$filtro = "";
			
			//para busqueda exacta
			//if (($r1 == 1) AND ($buscar != "")) { $filtro = "AND netbook_codigo = '{$buscar}'"; }
			//if (($r1 == 2) AND ($buscar != "")) { $filtro = "AND soporte_nro_caso = '{$buscar}'"; }

			//para busqueda de la cadena
			if (($r1 == 1) AND ($buscar != "")) { $filtro = "AND netbook_codigo like '%{$buscar}%'"; }
			if (($r1 == 2) AND ($buscar != "")) { $filtro = "AND soporte_nro_caso like '%{$buscar}%'"; }
			if (($r1 == 3) AND ($buscar != "")) { $filtro = "AND netbook_num_serie like '%{$buscar}%'"; }

			if ($estado != 0) {
			$sql= "SELECT *,netbook_codigo,netbook_matricula_id,netbook_num_serie FROM soporte,netbooks WHERE soporte_netbook_id = netbook_id AND soporte_estado_id = {$estado} ORDER BY soporte_fecha_solicitud Asc";
			} else {
			$sql= "SELECT *,netbook_codigo,netbook_matricula_id,netbook_num_serie FROM soporte,netbooks WHERE soporte_netbook_id = netbook_id {$filtro} ORDER BY soporte_fecha_solicitud Asc";
			}
			
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
				<div class="nohay">No se encontraron solicitudes de soporte técnico cargadas en el sistema</div>
			<?php } else { ?>
        <form name="listado" method="POST">
        <input type="hidden" name="idborrar" value="0">
        <div class="cuadro-detalles">
           	<div class="check-all"><input type="checkbox" name="ch0" onclick="javascript:seleccionar_todo();" /></div>
            <ul class="lista-detalles">
            	<li class="w143">Codigo</li>
            	<li class="w80">Fecha</li>
            	<li class="w150">Nro de Caso</li>
            	<li class="w230">Asignada</li>
            	<li class="w140">Estado</li>
            	<li class="w116">Acciones</li>
            </ul>
            <div class="clear"></div>
        </div><!-- fin cuadro detalles -->
        <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
				$fecha = date("d-m-Y", $resultado['soporte_fecha_solicitud']);

				$matricula_id = $resultado["netbook_matricula_id"];
				$codigo = $resultado["netbook_codigo"];
				
				$sql2 = "SELECT matricula_apellido,matricula_nombre,matricula_seccion_id FROM matricula WHERE matricula_id = {$matricula_id}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				if (filas($consulta2)) {
					//$pertenece = $resultado2["matricula_apellido"]." ".$resultado2["matricula_nombre"];
					$pertenece = "<a href='../matricula/seccion.php?seccion=".$resultado2['matricula_seccion_id']."'>".$resultado2['matricula_apellido']." ".$resultado2['matricula_nombre']."</a>";
				} else {
					$pertenece = "<b>LIBRE</b>";
				}

				$sql2 = "SELECT estado_nombre FROM soporte_estados WHERE estado_id = {$resultado['soporte_estado_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$estado_nombre = $resultado2["estado_nombre"];
			?>
            <div class="<?php if ((esPar($i))!=1) { echo "check-all"; } else { echo "check-all-gris"; } ?>"><input type="checkbox" value="<?php echo $resultado["soporte_id"]; ?>" name="ch" /></div>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w143"><a href="../netbooks/index.php?r1=1&buscar=<?php echo $codigo;?>"><?php echo $codigo;?></a></li>
            	<li class="w80"><?php echo $fecha;?></li>
            	<li class="w150"><?php echo $resultado["soporte_nro_caso"];?></li>
            	<li class="w230"><?php echo $pertenece;?></li>
            	<li class="w140"><?php echo $estado_nombre; ?></li>
            	<li class="w116">
                	<div class="ico_editar"><a href="editar.php?id=<?php echo $resultado["soporte_id"];?>&estado=<?php echo $estado;?>&p=<?php echo $pag; ?>" title="Editar">Editar</a></div>
                	<div class="ico_eliminar"><a href="eliminar.php?id=<?php echo $resultado["soporte_id"];?>&estado=<?php echo $estado;?>&p=<?php echo $pag;?>" title="Eliminar" onclick="return confirm('¿Esta seguro que desea eliminar la solicitud de soporte de la netbook <?php echo $codigo; ?>?');">Eliminar</a></div>
                	<div class="ico_obs"><?php if ($resultado["soporte_reclamo"] != "") {?><a href=" javascript:tb_show('','reclamos.php?id=<?php echo $resultado["soporte_id"];?>&amp;KeepThis=true&amp;TB_iframe=true&amp;height=250&amp;width=600');" title="Reclamos">Reclamos</a><?php } ?></div>
                	<div class="ico_mas" id="mas<?php echo $i;?>"><a href="javascript:mostrardiv('<?php echo $i;?>');" title="Ver más">Ver más</a></div>
                	<div class="ico_menos" id="menos<?php echo $i;?>" style="display:none"><a href="javascript:cerrardiv('<?php echo $i;?>');" title="Ver menos">Ver menos</a></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="mas-datos" id="masdatos<?php echo $i;?>" style="display:none">
            	<div class="sep15"></div>
            	<ul>
                <li class="w814">Número de Serie: <?php echo $resultado["netbook_num_serie"] ?><br/>Descripción del Problema:<br/><?php echo $resultado["soporte_descripcion"] ?></li>
                </ul>
            	<div class="clear"></div>
            	<div class="sep15"></div>
            </div>
            <?php } ?>
			<!-- fin repetir -->
            <div class="sep10"></div>
            <div class="cuadro-opciones">
            	<div class="seleccionados">
                	<?php if ($buscar == "") {?>
                	<select name="seleccionados" class="select-1" onchange="javascript:seleccion(this.value);">
                		<option value="0" selected>Seleccionados...</option>
                        <option value="eliminar_todo.php?estado=<?php echo $estado;?>">Eliminar seleccionados</option>
                	</select>
                    <?php } ?>
                </div>
                <?php if ($total > 1) { ?>
                <div class="botonera">
                	<div class="anterior"><?php if ($pagant<>$pag) { ?><a href="?p=<?php echo $pagant;?>&estado=<?php echo $estado;?>" title="Anterior">Anterior</a><?php } ?></div><!-- saco el a href si no hay anterior -->
                    <div class="pagina">Página&nbsp; <select name="pagina" class="select-2" onchange="document.location.href='?estado=<?php echo $estado;?>&p='+this.value;">
                		<?php for($a=1;$a<=$total;$a++){ ?>
						<option <?php if ($pag == ($a-1)) { echo "selected='selected'"; } ?> value="<?php echo ($a-1)?>"><?php echo $a?></option>
						<?php } ?>
                        </select>&nbsp; de <?php echo $total; ?></div>
                    <div class="siguiente"><?php if ($pagsig<>$total) { ?><a href="?p=<?php echo $pagsig;?>&estado=<?php echo $estado;?>" title="Siguiente">Siguiente</a><?php } ?></div><!-- saco el a href si no hay siguiente -->
                </div><!-- fin botonera -->
                <?php } ?>
                <div class="mostrando">Mostrando items <?php echo $pagg+1; ?>-<?php echo $pagg+$i; ?> de <?php echo $total_usuarios; ?></div>
                <div class="clear-b"></div>
            </div><!-- fin opciones -->
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
	if ((document.consultar.r1[0].checked == false) && (document.consultar.r1[1].checked == false) && (document.consultar.r1[2].checked == false))  {
		alert("Error\nNo ha seleccionado como desea filtrar la búsqueda");
		return false;
	}
	if ((document.consultar.buscar.value == "") && (document.consultar.r1[0].checked == true)) {
		alert("Error\nNo ha ingresado el código de la netbook");
		document.consultar.buscar.focus();
		return false;
	}
	if ((document.consultar.buscar.value == "") && (document.consultar.r1[1].checked == true)) {
		alert("Error\nNo ha ingresado el número de caso de la solicitud");
		document.consultar.buscar.focus();
		return false;
	}
	return true;
}
// -->
// ]]>
</script>
<?php include('../includes/comun/pie.inc.php'); ?>