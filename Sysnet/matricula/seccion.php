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
<?php 
$r1 = isset($_GET["r1"]) ? (is_numeric($_GET["r1"]) ? $_GET["r1"] : 1) : 1;
$buscar = isset($_GET["buscar"]) ? $_GET["buscar"] : "";
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
$cantidad = 30;

include('../includes/comun/header.inc.php'); 
include('../funciones/funciones.php'); 

//para ver si existe algun mensaje que mostrar
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
include('../includes/comun/mensajes.inc.php');

$seccion = isset($_GET["seccion"]) ? (is_numeric($_GET["seccion"]) ? $_GET["seccion"] : 0) : 0;

include_once("../funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT seccion_nombre FROM matricula_secciones WHERE seccion_id = {$seccion}";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);
$nombre_seccion = $resultado["seccion_nombre"];
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
            <?php if ($buscar != "") {?><div class="b-txt"><a href="index.php">> Mostrar el listado de secciones de la matrícula</a></div><?php } ?>
        	<div class="clear"></div>
        </div>
        </form>
    </div>
    <div class="sep15"></div>
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Matricula <?php if (($r1 == 0) AND ($buscar == "")) {?>> <a href="index.php">Secciones</a> > <?php echo $nombre_seccion; ?><?php } ?></div>
            <div class="filtro-ver">
            	<div class="filtro-txt">Ver sección:</div>
                <div class="filtro-input">
                <select name="seccion" class="select-1" onchange="document.location.href='seccion.php?seccion='+this.value;">
                <?php if (($r1 != 0) AND ($buscar != "")) {?><option value="0" selected>Seleccionar...</option><?php } ?>
				<?php 
				$sql = "SELECT seccion_id, seccion_nombre FROM matricula_secciones ORDER BY seccion_orden Asc";
				$consulta = consulta($sql,$conexion);
				while ($resultado = resultado($consulta)) {
				$check = ($seccion == $resultado["seccion_id"]) ? "selected" : "";
				echo "<option {$check} value='".$resultado["seccion_id"]."'>".$resultado["seccion_nombre"]."</option>\n";
				}
				?>
                </select>
                </div>
                <?php if ($buscar == "") {?>
                <div class="imprimir"><a href="javascript:popup('../matricula/imprimir.php?seccion=<?php echo $seccion; ?>&p=<?php echo $pag; ?>&cant=<?php echo $cantidad;?>','imprimir',750,600,'yes');" title="Imprimir"><img src="../images/imprimir.gif" width="24" height="23" alt="Imprimir" /></a></div>
                <?php } ?>
            </div>
            <div class="clear-b"></div>
        </div><!-- fin cuadro encabezado -->
        
            <?php
			//busqueda exacta
			//if (($r1 == 1) AND ($buscar != "")) { $filtro = "WHERE matricula_dni = '{$buscar}'"; }
			//if (($r1 == 2) AND ($buscar != "")) { $filtro = "WHERE matricula_apellido = '{$buscar}'"; }
			
			//busqueda de la cadena en los diferentes campos
			if (($r1 == 1) AND ($buscar != "")) { $filtro = "WHERE matricula_dni like '%{$buscar}%'"; }
			if (($r1 == 2) AND ($buscar != "")) { $filtro = "WHERE matricula_apellido like '%{$buscar}%'"; }


			if ($seccion != 0) {
				$sql= "SELECT * FROM matricula WHERE matricula_seccion_id = {$seccion} ORDER BY matricula_apellido Asc";
			} else {
				$sql= "SELECT * FROM matricula $filtro ORDER BY matricula_apellido Asc";			
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
				<div class="nohay">No se encontraron matriculados cargados</div>
			<?php } else { ?>
        <form name="listado" method="POST">
        <input type="hidden" name="idborrar" value="0">
        <div class="cuadro-detalles">
           	<div class="check-all"><input type="checkbox" name="ch0" onclick="javascript:seleccionar_todo();" /></div>
            <ul class="lista-detalles">
            	<li class="w205">Apellido</li>
            	<li class="w238">Nombre</li>
            	<li class="w150">DNI</li>
            	<li class="w160">Netbook</li>
            	<li class="w116">Acciones</li>
            </ul>
            <div class="clear"></div>
        </div><!-- fin cuadro detalles -->
        <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
				$sql2 = "SELECT localidad_nombre,localidad_provincia_id FROM localidades WHERE localidad_id = {$resultado['matricula_localidad_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$nombre_localidad = $resultado2["localidad_nombre"];
				$provincia_id = $resultado2["localidad_provincia_id"];			

				$sql2 = "SELECT provincia_nombre FROM provincias WHERE provincia_id = {$provincia_id}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$nombre_provincia = $resultado2["provincia_nombre"];

				$sql2 = "SELECT responsable_cuil,responsable_apellido,responsable_nombre FROM matricula_responsables WHERE responsable_id = {$resultado['matricula_responsable_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$cuil_responsable = $resultado2["responsable_cuil"];
				$apellido_responsable = $resultado2["responsable_apellido"];
				$nombre_responsable = $resultado2["responsable_nombre"];
				
				$firma[0] = "NO";
				$firma[1] = "SI";	
				$sql2 = "SELECT netbook_id,netbook_codigo,netbook_observaciones,netbook_contrato FROM netbooks WHERE netbook_matricula_id = {$resultado['matricula_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				if (filas($consulta2)) {		
					$netbook_id = $resultado2["netbook_id"];
					$netbook_observaciones = $resultado2["netbook_observaciones"];
					$netbook_asignada = '<a href="../netbooks/index.php?r1=1&buscar='.$resultado2["netbook_codigo"].'">'.$resultado2["netbook_codigo"].'</a>';
					$firma_contrato = $firma[$resultado2["netbook_contrato"]];
				} else {
					$firma_contrato = $firma[0];
					$netbook_observaciones = "";
					$netbook_asignada = "Falta Asignar";
				}
			?>
            <div class="<?php if ((esPar($i))!=1) { echo "check-all"; } else { echo "check-all-gris"; } ?>"><input type="checkbox" value="<?php echo $resultado["matricula_id"]; ?>" name="ch" /></div>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w205"><?php echo $resultado["matricula_apellido"];?></li>
            	<li class="w238"><?php echo $resultado["matricula_nombre"];?></li>
            	<li class="w150"><?php echo $resultado["matricula_dni"];?></li>
            	<li class="w160"><?php echo $netbook_asignada; ?></li>
            	<li class="w116">
                	<div class="ico_editar"><a href="matriculado_editar.php?id=<?php echo $resultado["matricula_id"];?>&seccion=<?php echo $seccion;?>&p=<?php echo $pag; ?>" title="Editar">Editar</a></div>
                	<div class="ico_eliminar"><a href="eliminar_matriculado.php?id=<?php echo $resultado["matricula_id"];?>&seccion=<?php echo $seccion;?>&p=<?php echo $pag;?>" title="Eliminar" onclick="return confirm('¿Esta seguro que desea eliminar el matriculado <?php echo $resultado['matricula_apellido']." ".$resultado['matricula_nombre']; ?>?');">Eliminar</a></div>
                	<div class="ico_obs"><?php if ($netbook_observaciones != "") {?><a href=" javascript:tb_show('','../netbooks/observaciones.php?id=<?php echo $netbook_id;?>&amp;KeepThis=true&amp;TB_iframe=true&amp;height=250&amp;width=600');" title="Observaciones">Observaciones</a><?php } ?></div>
                	<div class="ico_mas" id="mas<?php echo $i;?>"><a href="javascript:mostrardiv('<?php echo $i;?>');" title="Ver más">Ver más</a></div>
                	<div class="ico_menos" id="menos<?php echo $i;?>" style="display:none"><a href="javascript:cerrardiv('<?php echo $i;?>');" title="Ver menos">Ver menos</a></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="mas-datos" id="masdatos<?php echo $i;?>" style="display:none">
            	<div class="sep15"></div>
            	<ul>
                <li class="w200">CUIL: <?php echo $resultado["matricula_cuil"]; ?></li>
                <li class="w267">Firmó contrato: <?php echo $firma_contrato; ?></li>
                <li class="w267">Dirección: <?php echo $resultado["matricula_calle"];?> <?php if ($resultado["matricula_nro"] != 0) { echo $resultado["matricula_nro"]; }?> <?php echo $resultado["matricula_depto"];?></li>
                </ul>
	           	<div class="clear"></div>
            	<div class="sep10"></div>
                <ul>
                <li class="w200">Provincia: <?php echo $nombre_provincia; ?></li>
                <li class="w267">Localidad: <?php echo $nombre_localidad; ?></li>
                <li class="w267">CP: <?php echo $resultado["matricula_cp"]; ?></li>
                </ul>
	           	<div class="clear"></div>
            	<div class="sep10"></div>
            	<ul>
                <li class="w200">Teléfono: <?php if ($resultado["matricula_tel"] != 0) { echo $resultado["matricula_tel"]; }?></li>
                <li class="w267">Celular: <?php if ($resultado["matricula_cel"] != 0) { echo $resultado["matricula_cel"]; }?></li>
                <li class="w267">E-mail: <a href="mailto:<?php echo $resultado["matricula_email"];?>"><?php echo $resultado["matricula_email"];?></a></li>
                </ul>
            	<?php if ($cuil_responsable != "") {?>
                <div class="clear"></div>
            	<div class="sep10"></div>
             	<ul>
                <li class="w477">Nombre del responsable: <?php echo $apellido_responsable;?> <?php echo $nombre_responsable;?></li>
                <li class="w267">CUIL del responsable: <?php echo $cuil_responsable;?></li>
                </ul>
                <?php } ?>
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
                        <option value="eliminar_todo.php?seccion=<?php echo $seccion;?>">Eliminar seleccionados</option>
						<?php 
						$sql = "SELECT seccion_id, seccion_nombre FROM matricula_secciones ORDER BY seccion_orden Asc";
						$consulta = consulta($sql,$conexion);
						while ($resultado = resultado($consulta)) {
						$mover_nombre = $resultado["seccion_nombre"];
						$mover_id = $resultado["seccion_id"];
						if ($seccion != $mover_id) {
							echo "<option value='mover_todo.php?seccion={$seccion}&mover={$mover_id}'>Mover a {$mover_nombre}</option>\n";
							}
						}
						?>
                        <!--<option value="mover_todo.php?seccion=<?php echo $seccion;?>">Mover a Alumnos 1A</option>-->
                	</select>
                    <?php } ?>
                </div>
                <?php if ($total > 1) { ?>
                <div class="botonera">
                	<div class="anterior"><?php if ($pagant<>$pag) { ?><a href="?p=<?php echo $pagant;?>&seccion=<?php echo $seccion;?>" title="Anterior">Anterior</a><?php } ?></div><!-- saco el a href si no hay anterior -->
                    <div class="pagina">Página&nbsp; <select name="pagina" class="select-2" onchange="document.location.href='?seccion=<?php echo $seccion;?>&p='+this.value;">
                		<?php for($a=1;$a<=$total;$a++){ ?>
						<option <?php if ($pag == ($a-1)) { echo "selected='selected'"; } ?> value="<?php echo ($a-1)?>"><?php echo $a?></option>
						<?php } ?>
                        </select>&nbsp; de <?php echo $total; ?></div>
                    <div class="siguiente"><?php if ($pagsig<>$total) { ?><a href="?p=<?php echo $pagsig;?>&seccion=<?php echo $seccion;?>" title="Siguiente">Siguiente</a><?php } ?></div><!-- saco el a href si no hay siguiente -->
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