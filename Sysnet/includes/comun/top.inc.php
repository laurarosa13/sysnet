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
if (!isset($_SESSION["id_usuario"])) {
		header("Location: ../../salir/");
		exit;
} 
include_once("../funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT usuario_privilegio FROM usuarios WHERE usuario_id = {$_SESSION['id_usuario']} LIMIT 0,1";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);

if ($resultado["usuario_privilegio"] == 10) { $privi = "administrador"; } else { $privi = "operador"; }
?>
<?php if (!isset($menu_posicion)) { $menu_posicion = 0; } ?>
<div id="encabezado">
	<div id="logo"><a href="../home/"><img src="../images/logo.jpg" title="Inicio" alt="Inicio" /></a></div>
    <div id="usuario">
    	<div id="txt-user">usuario: <strong><?php echo $_SESSION["nombre_usuario"]." ".$_SESSION["apellido_usuario"];?></strong><?php echo " (".$privi.")"; ?></div>
    	<div id="ico-salir"><a href="../salir/"><img src="../images/salir.jpg" title="Salir" alt="Salir" /></a></div>
        <div class="clear"></div>
        <!-- solo administradores -->
        <?php if ($resultado["usuario_privilegio"] == 10) {?>
        <div class="usuarios-panel">
        	<ul>
            <li><a href="../usuarios/index.php" <?php if (isset($user_listar)) { echo "class='act'"; }?>><span>:.</span> Listar usuarios</a></li>
            <li><a href="../usuarios/cargar.php" <?php if (isset($user_cargar)) { echo "class='act'"; }?>><span>:.</span> Cargar usuario</a></li>
            </ul>
        </div>
        <div class="clear-r"></div>
        <?php } else {?>
        <div class="usuarios-panel">
        	<ul>
            <li><a href="../usuarios/mis_datos.php" <?php if (isset($user_datos)) { echo "class='act'"; }?>><span>:.</span> Editar mis datos</a></li>
            </ul>
        </div>
        <div class="clear-r"></div>        
        <?php } ?>
        <!-- fin solo administradores -->
    </div>
	<div class="clear-b"></div>
    <div id="menu">
        <!-- Menú desplegables -->
		<div style='position:relative' id="sddm">
			<div id="m1" style='width:177px;left:89px' onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
			<ul>
			<li><a href="../matricula/index.php">Listar matricula</a></li>
			<li><a href="../matricula/cargar.php">Cargar matricula</a></li>
			</ul>		
			</div>
			<div id="m2" style='width:177px;left:214px' onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
			<ul>
			<li><a href="../netbooks/index.php">Listar netbooks</a></li>
			<li><a href="../netbooks/cargar.php">Cargar netbook</a></li>
			</ul>		
			</div>
			<div id="m3" style='width:177px;left:342px' onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
			<ul>
			<li><a href="../soporte/index.php">Listar solicitudes</a></li>
			<li><a href="../soporte/cargar.php">Cargar solicitud</a></li>
			</ul>		
			</div>
			<div id="m4" style='width:177px;left:520px' onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
			<ul>
			<li><a href="../respaldo/index.php">Realizar respaldo</a></li>
			<li><a href="../respaldo/cargar.php">Cargar respaldo</a></li>
			</ul>		
			</div>
		</div>
		<!-- Fin menu desplegables -->
    	<ul>
        <li id="it_inicio" <?php if ($menu_posicion ==1) { echo "class='activo'"; } ?>><a href="../home/" title="Inicio">Inicio</a></li>
        <li id="it_matricula" <?php if ($menu_posicion ==2) { echo "class='activo'"; } ?>><a href="../matricula/" title="Matricula" onmouseover="mopen('m1')" onmouseout="mclosetime()">Matricula</a></li>
        <li id="it_netbooks" <?php if ($menu_posicion ==3) { echo "class='activo'"; } ?>><a href="../netbooks/" title="Netbooks" onmouseover="mopen('m2')" onmouseout="mclosetime()">Netbooks</a></li>
        <li id="it_soporte" <?php if ($menu_posicion ==4) { echo "class='activo'"; } ?>><a href="../soporte/" title="Soporte Técnico" onmouseover="mopen('m3')" onmouseout="mclosetime()">Soporte Técnico</a></li>
        <li id="it_respaldo" <?php if ($menu_posicion ==5) { echo "class='activo'"; } ?>><a href="../respaldo/" title="Respaldo" onmouseover="mopen('m4')" onmouseout="mclosetime()">Respaldo</a></li>
        <li id="it_ayuda" <?php if ($menu_posicion ==6) { echo "class='activo'"; } ?>><a href="../manual/manualdelusuario.pdf" target="_blank" title="Ayuda">Ayuda</a></li>
    	</ul>
    </div>
</div>
<div class="clear"></div>
<div class="sep20"></div>
<script type="text/javascript">
<!-- // --><![CDATA[
var timeout	= 100;
var closetimer	= 0;
var ddmenuitem	= 0;

function mopen(id) {	
	mcancelclosetime();
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
}
function mclose() {
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}
function mclosetime() {
	closetimer = window.setTimeout(mclose, timeout);
}
function mcancelclosetime() {
	if(closetimer) {
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}
document.onclick = mclose; 
// -->
// ]]>
</script>