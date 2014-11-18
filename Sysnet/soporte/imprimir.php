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
$estado = isset($_GET["estado"]) ? (is_numeric($_GET["estado"]) ? $_GET["estado"] : 0) : 0; 
$pag = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0; 
$cantidad = isset($_GET["cant"]) ? (is_numeric($_GET["cant"]) ? $_GET["cant"] : 0) : 0; 

include_once("../funciones/conexion.php");
$conexion=conectar();

$sql = "SELECT estado_nombre FROM soporte_estados WHERE estado_id = {$estado}";
$consulta = consulta($sql,$conexion);
if (filas($consulta)) {
	$resultado = resultado($consulta);
	$tema_listado = "Listado de solicitudes de Soporte Técnico en estado <span>".$resultado["estado_nombre"]."</span>";
} else {
    $tema_listado = "Listado de todas las solicitudes de Soporte Técnico";
}

if ($estado != 0) {
	$sql= "SELECT *,netbook_codigo,netbook_matricula_id,netbook_num_serie FROM soporte,netbooks WHERE soporte_netbook_id = netbook_id AND soporte_estado_id = {$estado} ORDER BY soporte_fecha_solicitud Asc";
} else {
	$sql= "SELECT *,netbook_codigo,netbook_matricula_id,netbook_num_serie FROM soporte,netbooks WHERE soporte_netbook_id = netbook_id ORDER BY soporte_fecha_solicitud Asc";
}
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
    	<div class="tema">No existen solicitudes de Soporte Técnico cargadas</div>
        <?php } else { ?>
    	<div class="tema"><?php echo $tema_listado; ?> (página <?php echo $pag+1; ?> de <?php echo $total; ?>)</div>
    	<div class="tabla">
        <table border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="120" class="encabeza">Código</td>
        <td width="90" class="encabeza">Fecha</td>
        <td width="130" class="encabeza">Nro de Caso</td>
        <td width="250" class="encabeza">Asignada</td>
	    <td width="120" class="encabeza">Estado</td>	
        </tr>
		<?php
		$consulta = consulta($sql,$conexion);
		$i = $pagg;
		while ($resultado = resultado($consulta)) {
				$i++;
				$fecha = date("d-m-Y", $resultado['soporte_fecha_solicitud']);
				$matricula_id = $resultado["netbook_matricula_id"];
				$sql2 = "SELECT matricula_apellido,matricula_nombre,matricula_seccion_id FROM matricula WHERE matricula_id = {$matricula_id}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				if (filas($consulta2)) {
					$pertenece = $resultado2['matricula_apellido']." ".$resultado2['matricula_nombre'];
				} else {
					$pertenece = "<b>LIBRE</b>";
				}

				$sql2 = "SELECT estado_nombre FROM soporte_estados WHERE estado_id = {$resultado['soporte_estado_id']}";
				$consulta2 = consulta($sql2,$conexion);
				$resultado2 = resultado($consulta2);
				$estado_nombre = $resultado2["estado_nombre"];		
		?>
        <tr>
        <td width="120" class="result"><?php echo $resultado["netbook_codigo"];?></td>
        <td width="90" class="result"><?php echo $fecha;?></td>
        <td width="130" class="result"><?php echo $resultado["soporte_nro_caso"];?></td>
        <td width="250" class="result"><?php echo $pertenece;?></td>
	    <td width="120" class="result"><?php echo $estado_nombre; ?></td>	
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