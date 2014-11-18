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
<?php include("../includes/comun/privilegio.php"); ?>
<?php
include('../funciones/funciones.php');
$user_listar = 1;
//veo si selecciono filtrado
$filtro = isset($_GET["filtro"]) ? (is_numeric($_GET["filtro"]) ? $_GET["filtro"] : 0) : 0;
if ($filtro == 0) {
	$verprivilegio = "";
} else {
	$verprivilegio = " WHERE usuario_privilegio = {$filtro} ";
}
//fin seleccion filtrado
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
include('../includes/comun/mensajes.inc.php');
?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>    
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Usuarios</div>
        	<div class="linea-titulo"></div>
            <div class="filtro-ver">
            	<div class="filtro-txt">Ver usuarios:</div>
                <div class="filtro-input">
                <select name="filtro" class="select-1" onchange="document.location.href='?filtro='+this.value;">
                	<option value="0" <?php if ($filtro == 0) { echo "selected"; } ?>>Todos los usuarios...</option>
                	<option value="10" <?php if ($filtro == 10) { echo "selected"; } ?>>Usuarios administradores</option>
                    <option value="1" <?php if ($filtro == 1) { echo "selected"; } ?>>Usuarios operadores</option>
                </select>
                </div>
            </div>
            <div class="clear-b"></div>
        </div><!-- fin cuadro encabezado -->
        
            <?php
			include_once("../funciones/conexion.php");
			$conexion=conectar();

			$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;

			$sql= "SELECT usuario_id,usuario_apellido,usuario_nombre,usuario_dni,usuario_tel,usuario_cel,usuario_email,usuario_privilegio FROM usuarios {$verprivilegio} ORDER BY usuario_apellido Asc";
			
			$cantidad = 30;
			$consulta = consulta($sql,$conexion);

			$total_usuarios = filas($consulta);
			$total = ceil($total_usuarios / $cantidad);

			$pagg = $pag * $cantidad;
			$pagsig = (($pag + 1) > $total) ? $total : ($pag + 1);
			$pagant = (($pag - 1) < 0) ? 0 : ($pag - 1);
			
			$sql.= " LIMIT $pagg,$cantidad";
			$consulta = consulta($sql,$conexion);
				
			$i = 0;
		
			$privilegio[1] = "Operador";
			$privilegio[10] = "Administrador";

			$privilegio2[1] = "operadores";
			$privilegio2[10] = "administradores";

			if ($total_usuarios == 0) { ?>
				<div class="nohay">No se encontraron usuarios <?php echo $privilegio2[$filtro]; ?> cargados en el sistema</div>
			<?php } else { ?>
        <form name="listado" method="POST">
        <input type="hidden" name="idborrar" value="0">
        <div class="cuadro-detalles">
           	<div class="check-all"><input type="checkbox" name="ch0" onclick="javascript:seleccionar_todo();" /></div>
            <ul class="lista-detalles">
            	<li class="w205">Apellido</li>
            	<li class="w267">Nombre</li>
            	<li class="w150">DNI</li>
            	<li class="w160">Privilegio</li>
            	<li class="w87">Acciones</li>
            </ul>
            <div class="clear"></div>
        </div><!-- fin cuadro detalles -->
        <div class="cuadro-resultados">
			<!-- repito esto -->
			<?php
			while ($resultado = resultado($consulta)) {
				$i++;
			?>
            <div class="<?php if ((esPar($i))!=1) { echo "check-all"; } else { echo "check-all-gris"; } ?>"><input type="checkbox" <?php if ($_SESSION["id_usuario"] == $resultado["usuario_id"]) { echo "disabled='disabled'"; } ?> value="<?php echo $resultado["usuario_id"]; ?>" name="ch" /></div>
            <ul class="lista-resultados <?php if ((esPar($i))==1) { echo "fgris"; } ?>">
            	<li class="w205"><?php echo $resultado["usuario_apellido"];?></li>
            	<li class="w267"><?php echo $resultado["usuario_nombre"];?></li>
            	<li class="w150"><?php echo $resultado["usuario_dni"];?></li>
            	<li class="w160"><?php print $privilegio[$resultado["usuario_privilegio"]]; ?></li>
            	<li class="w87">
                	<div class="ico_editar"><a href="editar.php?id=<?php echo $resultado["usuario_id"];?>&filtro=<?php echo $filtro;?>&p=<?php echo $pag;?>" title="Editar">Editar</a></div>
                	<div class="ico_eliminar"><?php if ($_SESSION["id_usuario"] == $resultado["usuario_id"]) {?><img src="../images/ico_eliminar_des.gif" width="14" height="14" alt="" /><?php } else {?><a href="eliminar.php?id=<?php echo $resultado["usuario_id"];?>&filtro=<?php echo $filtro;?>" title="Eliminar" onclick="return confirm('¿Esta seguro que desea eliminar el usuario <?php echo $resultado['usuario_apellido']." ".$resultado['usuario_nombre']; ?>?');">Eliminar</a><?php } ?></div>
                	<div class="ico_mas" id="mas<?php echo $i;?>"><a href="javascript:mostrardiv('<?php echo $i;?>');" title="Ver más">Ver más</a></div>
                	<div class="ico_menos" id="menos<?php echo $i;?>" style="display:none"><a href="javascript:cerrardiv('<?php echo $i;?>');" title="Ver menos">Ver menos</a></div>
                </li>
            </ul>
            <div class="clear"></div>
            <div class="mas-datos" id="masdatos<?php echo $i;?>" style="display:none">
            	<div class="sep15"></div>
            	<ul>
                <li class="w200">Teléfono: <?php if ($resultado["usuario_tel"] != 0) { echo $resultado["usuario_tel"]; }?></li>
                <li class="w267">Celular: <?php if ($resultado["usuario_cel"] != 0) { echo $resultado["usuario_cel"]; }?></li>
                <li class="w200">E-mail: <a href="mailto:<?php echo $resultado["usuario_email"];?>"><?php echo $resultado["usuario_email"];?></a></li>
                </ul>
            	<div class="clear"></div>
            	<div class="sep15"></div>
            </div>
            <?php } ?>
			<!-- fin repetir -->
            <div class="sep10"></div>
            <div class="cuadro-opciones">
            	<div class="seleccionados">
                	<select name="seleccionados" class="select-1" onchange="javascript:seleccion(this.value);">
                		<option value="0" selected>Seleccionados...</option>
                        <option value="eliminar_todo.php?filtro=<?php echo $filtro;?>">Eliminar seleccionados</option>
                	</select>
                </div>
                <?php if ($total > 1) { ?>
                <div class="botonera">
                	<div class="anterior"><?php if ($pagant<>$pag) { ?><a href="?p=<?php echo $pagant;?>&filtro=<?php echo $filtro;?>" title="Anterior">Anterior</a><?php } ?></div><!-- saco el a href si no hay anterior -->
                    <div class="pagina">Página&nbsp; <select name="pagina" class="select-2" onchange="document.location.href='?filtro=<?php echo $filtro;?>&p='+this.value;">
                		<?php for($a=1;$a<=$total;$a++){ ?>
						<option <?php if ($pag == ($a-1)) { echo "selected='selected'"; } ?> value="<?php echo ($a-1)?>"><?php echo $a?></option>
						<?php } ?>
                        </select>&nbsp; de <?php echo $total; ?></div>
                    <div class="siguiente"><?php if ($pagsig<>$total) { ?><a href="?p=<?php echo $pagsig;?>&filtro=<?php echo $filtro;?>" title="Siguiente">Siguiente</a><?php } ?></div><!-- saco el a href si no hay siguiente -->
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
// -->
// ]]>
</script>
<?php include('../includes/comun/pie.inc.php'); ?>