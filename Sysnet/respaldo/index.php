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
<div id="centro" class="alto-minimo">
	<div class="cuadro-lista">
    	<div class="cuadro-encabezado">
        	<div class="cuadro-titulo">Realizar respaldo</div>
        </div><!-- fin cuadro encabezado --> 
       	<div class="sep20"></div>
        <div class="respaldo">
        <?php if ($resultado["usuario_privilegio"] == 10) {?>
       	<div class="solo-admin">Le recordamos que se recomienda realizar una copia de respaldo periódicamente y mantener bien guardadas los ultimas copias realizadas.<br/><br/>Para descargar una copia actual haga click en el siguiente botón:</div>
        <div class="sep20"></div>
       	<div><a href="realizar_respaldo.php"><img src="../images/bt_realizar_respaldo.jpg" width="160" height="26" alt="" /></a></div>
        <?php }  else {?>
       	<div class="solo-admin">Solo los administradores pueden realizar una copia de respaldo de la base de datos.<br/><br/>Pongase en contacto con un administrador si necesita realizar esta acción.</div>
        <?php } ?>
        </div>
        <div class="sep20"></div>
        <div class="volver-respaldo"><a href="javascript:history.go(-1);"><img src="../images/bt_volver.jpg" width="100"  height="26" alt="" /></a></div>
        <div class="sep20"></div>
    </div><!-- fin cuadro-lista -->
</div><!-- fin centro -->
<?php include('../includes/comun/pie.inc.php'); ?>