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
function esPar($numero) { 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return true;
	}else{ 
        return false; 
	}
}

function paginar($variables)
 {
 $paginado='<div class="botonera">
                	<div class="anterior"><a href="" title="Anterior">Anterior</a></div><!-- saco el a href si no hay anterior -->
                    <div class="pagina">Página&nbsp; <select name="pagina" class="select-2"><option>100</option></select>&nbsp; de 310</div>
                    <div class="siguiente"><a href="" title="Siguiente">Siguiente</a></div><!-- saco el a href si no hay siguiente -->
                </div>';
 echo $paginado;
 }
?>
