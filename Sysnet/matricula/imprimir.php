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
<?php
$seccion = isset($_GET["seccion"]) ? (is_numeric($_GET["seccion"]) ? $_GET["seccion"] : 0) : 0; 
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0; 
$cantidad = isset($_GET["cant"]) ? (is_numeric($_GET["cant"]) ? $_GET["cant"] : 0) : 0; 

include_once("../funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT seccion_nombre FROM matricula_secciones WHERE seccion_id = {$seccion}";
$consulta = consulta($sql,$conexion);
$resultado = resultado($consulta);
$nombre_seccion = $resultado["seccion_nombre"];

$sql= "SELECT * FROM matricula WHERE matricula_seccion_id = {$seccion} ORDER BY matricula_apellido Asc";
$consulta = consulta($sql,$conexion);
$total_usuarios = filas($consulta);
$total = ceil($total_usuarios / $cantidad);

$pagg = $pag * $cantidad;
	
$sql.= " LIMIT $pagg,$cantidad";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Imprimir</title>
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/imprimir.css" rel="stylesheet" type="text/css" />
	</head>
    <body>
	<div id="contenedor">
    	<div class="sep10"></div>
    	<div class="titulo">Sysnet</div>
        <?php if ($total_usuarios == 0) { ?>
    	<div class="tema">No existen matriculados cargados en esta sección</div>
        <?php } else { ?>
    	<div class="tema">Listado de la sección <span><?php echo $nombre_seccion; ?></span> (página <?php echo $pag+1; ?> de <?php echo $total; ?>)</div>
    	<div class="tabla">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="45" class="encabeza">Nro</td>
        <td width="205" class="encabeza">Apellido</td>
        <td width="240" class="encabeza">Nombre</td>
        <td width="100" class="encabeza">DNI</td>
	    <td width="120" class="encabeza">Netbook</td>	
        </tr>
		<?php
		$consulta = consulta($sql,$conexion);
		$i = $pagg;
		while ($resultado = resultado($consulta)) {
				$i++;
				$sql2 = "SELECT netbook_id,netbook_codigo FROM netbooks WHERE netbook_matricula_id = {$resultado['matricula_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				if (filas($consulta2)) {		
					$netbook_id = $resultado2["netbook_id"];
					$netbook_asignada = $resultado2["netbook_codigo"];
				} else {
					$netbook_asignada = "Falta Asignar";
				}			
			
		?>
        <tr>
        <td width="45" class="result"><?php echo $i; ?></td>
        <td width="205" class="result"><?php echo $resultado["matricula_apellido"];?></td>
        <td width="240" class="result"><?php echo $resultado["matricula_nombre"];?></td>
        <td width="100" class="result"><?php echo $resultado["matricula_dni"];?></td>
	    <td width="120" class="result"><?php echo $netbook_asignada; ?></td>	
        </tr>
        <?php } } ?>
        </table>
        </div>
    	<div class="sep20"></div>
    </div>
    <?php if ($total_usuarios != 0) { ?> 
    <script language='JavaScript' type='text/javascript'>
    <!-- // --><![CDATA[
         window.print();
    // ]]>
    </script>
    <?php } ?>
    </body>
</html>