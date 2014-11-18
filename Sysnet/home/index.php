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
$menu_posicion = 1; 
?>
<?php include("../includes/comun/session.php"); ?>
<?php include('../includes/comun/header.inc.php'); ?>
<?php include('../includes/comun/top.inc.php'); ?>
<?php $msj = isset($_GET["msj"]) ? (is_numeric($_GET["msj"]) ? $_GET["msj"] : 0) : 0; ?>
<?php include('../includes/comun/mensajes.inc.php'); ?>
<?php
include_once("../funciones/conexion.php");
$conexion=conectar();

//netbooks en alerta
$sql = "SELECT soporte_id FROM soporte WHERE soporte_estado_id = '3'";
$consulta = consulta($sql,$conexion);
$cant_alerta = filas($consulta);

//alumnos regulares y docentes matriculados
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo IN(1,2)";
$consulta = consulta($sql,$conexion);
$cant_alumnos_reg_docentes = filas($consulta);


//alumnos regulares
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 1";
$consulta = consulta($sql,$conexion);
$cant_alumnos_reg = filas($consulta);

//alumnos egresados
$sql = "SELECT matricula_id FROM matricula WHERE matricula_seccion_id = '16'";
$consulta = consulta($sql,$conexion);
$cant_alumnos_egresados = filas($consulta);

//docentes matriculados
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 2";
$consulta = consulta($sql,$conexion);
$cant_docentes = filas($consulta);

//pases solicitados
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id = '8'";
$consulta = consulta($sql,$conexion);
$cant_pases = filas($consulta);

//pases en tramite
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id = '9'";
$consulta = consulta($sql,$conexion);
$cant_pases_entramite = filas($consulta);

//pases finalizados
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id = '7'";
$consulta = consulta($sql,$conexion);
$cant_pases_finalizados = filas($consulta);


//alumnos regulares sin netbooks
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 1 AND matricula_id NOT IN (SELECT netbook_matricula_id FROM netbooks)";
$consulta = consulta($sql,$conexion);
$cant_alumnos_sinnet = filas($consulta);

//docentes sin netbooks
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 2 AND matricula_id NOT IN (SELECT netbook_matricula_id FROM netbooks)";
$consulta = consulta($sql,$conexion);
$cant_docentes_sinnet = filas($consulta);

$cant_total_asignar = ($cant_alumnos_sinnet+$cant_docentes_sinnet);

//total de netbooks recibidas
$sql = "SELECT netbook_id FROM netbooks";
$consulta = consulta($sql,$conexion);
$cant_total_netbooks = filas($consulta);

//total de netbooks obsequiadas
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id ='2'";
$consulta = consulta($sql,$conexion);
$cant_netbooks_obsequiadas = filas($consulta);

$cant_netbooks_institucion = ($cant_total_netbooks-$cant_netbooks_obsequiadas);

//alumnos regulares con netbooks
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 1 AND matricula_id IN (SELECT netbook_matricula_id FROM netbooks)";
$consulta = consulta($sql,$conexion);
$cant_asignadas_alumnos = filas($consulta);

//docentes con netbooks
$sql = "SELECT matricula_id FROM matricula,matricula_secciones WHERE matricula_seccion_id = seccion_id AND seccion_tipo = 2 AND matricula_id IN (SELECT netbook_matricula_id FROM netbooks)";
$consulta = consulta($sql,$conexion);
$cant_asignadas_docentes = filas($consulta);

//total de netbooks libres
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_matricula_id ='0' AND netbook_estado_id = '1'";
$consulta = consulta($sql,$conexion);
$cant_netbooks_libres = filas($consulta);

//total de netbooks en soporte
$sql = "SELECT soporte_id FROM soporte WHERE soporte_estado_id IN(2,3)";
$consulta = consulta($sql,$conexion);
$cant_netbooks_soporte = filas($consulta);

//total de netbooks en espera soporte
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id = 5";
$consulta = consulta($sql,$conexion);
$cant_netbooks_espera = filas($consulta);

//total de netbooks no devueltas
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id ='3'";
$consulta = consulta($sql,$conexion);
$cant_netbooks_nodevueltas = filas($consulta);

//total de netbooks robadas
$sql = "SELECT netbook_id FROM netbooks WHERE netbook_estado_id ='4'";
$consulta = consulta($sql,$conexion);
$cant_netbooks_robadas = filas($consulta);
?>
<div id="centro">
	<?php if ($msj != 0) {?>
	<div class="<?php echo $clase; ?>"><?php echo $muestro; ?></div>
    <div class="sep10"></div>
	<?php } ?>  
    <div class="col">
    	<div class="cuadro-col">
    		<div class="titu-alerta">Netbooks en Alerta</div>
            <div class="centrar-al">
            	<div class="txt-alerta">Total de netbooks que no han recibido respuesta de soporte técnico trascurridos 60 días</div>
            	<div class="cant-alerta"><?php echo $cant_alerta; ?></div>
            	<div class="item-ver"><a href="../soporte/index.php?estado=3">Ver</a></div>
            	<div class="clear"></div>
            </div>
    	</div>
        <div class="sep20"></div>
    	<div class="cuadro-col">
    		<div class="titu-alerta">Matricula</div>
            <div class="centrar-al">
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de alumnos regulares y docentes matriculados</div>
                	<div class="item-cant"><?php echo $cant_alumnos_reg_docentes; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de alumnos regulares</div>
                	<div class="item-cant"><?php echo $cant_alumnos_reg;?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de alumnos egresados</div>
                	<div class="item-cant"><?php echo $cant_alumnos_egresados;?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de pases a otra escuela solicitados</div>
                	<div class="item-cant"><?php echo $cant_pases;?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de pases a otra escuela en trámite</div>
                	<div class="item-cant"><?php echo $cant_pases_entramite;?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de docentes matriculados</div>
                	<div class="item-cant"><?php echo $cant_docentes;?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de alumnos regulares sin netbooks</div>
                	<div class="item-cant"><?php echo $cant_alumnos_sinnet; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de docentes matriculados sin netbooks</div>
                	<div class="item-cant"><?php echo $cant_docentes_sinnet; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de matriculados sin netbook</div>
                	<div class="item-cant-naranja"><?php echo $cant_total_asignar; ?></div>
                	<div class="clear"></div>
                </div>
            </div>
    	</div>
    </div>
    <div class="sep19h"></div>
    <div class="col">
    	<div class="cuadro-col">
    		<div class="titu-alerta">Netbooks</div>
                        <div class="centrar-al">
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks recibidas</div>
                	<div class="item-cant"><?php echo $cant_total_netbooks; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks obsequiadas a egresados</div>
                	<div class="item-cant"><?php echo $cant_netbooks_obsequiadas; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks pertenecientes a la institución</div>
                	<div class="item-cant"><?php echo $cant_netbooks_institucion; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks asignadas a alumnos regulares</div>
                	<div class="item-cant"><?php echo $cant_asignadas_alumnos; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks asignadas a docentes</div>
                	<div class="item-cant"><?php echo $cant_asignadas_docentes; ?></div>
                	<div class="clear"></div>
                </div>
            	<div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks libres para asignar</div>
                	<div class="item-cant-verde"><?php echo $cant_netbooks_libres; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks en soporte técnico</div>
                	<div class="item-cant"><?php echo $cant_netbooks_soporte; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks en espera de soporte técnico</div>
                	<div class="item-cant"><?php echo $cant_netbooks_espera; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks no devueltas</div>
                	<div class="item-cant"><?php echo $cant_netbooks_nodevueltas; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de pases a otra escuela finalizados</div>
                	<div class="item-cant"><?php echo $cant_pases_finalizados; ?></div>
                	<div class="clear"></div>
                </div>
                <div class="recuadro-gris">
            		<div class="item-txt">Total de netbooks robadas</div>
                	<div class="item-cant"><?php echo $cant_netbooks_robadas; ?></div>
                	<div class="clear"></div>
                </div>
            </div>
    	</div>
    </div>
</div><!-- fin centro -->
<?php include('../includes/comun/pie.inc.php'); ?>