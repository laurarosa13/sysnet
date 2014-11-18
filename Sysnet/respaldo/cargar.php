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
<?php $menu_posicion = 5; ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<?php
$msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0;
include('../includes/comun/mensajes.inc.php');
?>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php }?> 
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Cargar respaldo</div>
        </div><!-- fin cuadro encabezado --> 
       	<div class="sep20"></div>
       	<div class="respaldo">
        <?php if ($resultado["usuario_privilegio"] == 10) {?>

        	<div class="solo-admin"><span>ATENCION:</span> al realizar la carga de la copia de respaldo se reemplazará toda la información que se encuentra actualmente cargada en el sistema.<br/><br/><b>No cierre el navegador</b> hasta que no haya finalizado la carga.<br/><br/>Para mayor seguridad <a href="index.php">realice una copia actual de respaldo</a> antes de continuar<br/><br/></div>
            <form name="subirbd" method="post" action="cargar_respaldo.php" enctype="multipart/form-data" onsubmit="return validarrespaldo();">
            <input type="hidden" name="MAX_FILE_SIZE" value="2048000"/>
            <div class="txt-cargar left">Seleccione la copia de respaldo a cargar</div>
            <div class="custom-input-file left"><input name="archivobd" type="file" class="input-file"/><div class="archivo"></div></div>
            <div class="bt_cargar left"><input src="../images/bt_cargar_respaldo.jpg" width="153" height="26" type="image"/></div>
            <div class="clear"></div>
        	<div class="sep30"></div>
            </form>
         <?php } else {?> 
         <div class="solo-admin">Solo los administradores pueden realizar la carga de una copia de respaldo de la base de datos.<br/><br/>Pongase en contacto con un administrador si necesita realizar esta acción.</div>  
         <?php } ?>
        </div><!-- fin respaldo -->
        <div class="sep20"></div>
        <div class="volver-respaldo"><a href="javascript:history.go(-1);"><img src="../images/bt_volver.jpg" width="100"  height="26" alt="" /></a></div>
        <div class="sep20"></div>
    </div><!-- fin cuadro-lista -->
</div><!-- fin centro -->
<script type="text/javascript">
<!-- // --><![CDATA[
$(function(){
    $(".custom-input-file input:file").change(function(){
        $(this).parent().find(".archivo").html($(this).val());
    }).css('border-width',function(){
        if(navigator.appName == "Microsoft Internet Explorer")
            return 0;
    });
});
// -->
// ]]>
</script>
<?php include('../includes/comun/pie.inc.php'); ?>