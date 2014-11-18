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
include('../includes/comun/privilegio.php');
include_once("../funciones/conexion.php");
	
$nombre_backup = date("Y-m-d") . "-sysnetbd.sql";

// CABECERAS PARA DESCARGAR EL ARCHIVO
header( "Content-type: text/html; charset=UTF-8" );
header( "Content-type: application/savingfile" );
header( "Content-Disposition: attachment; filename=$nombre_backup" );
header( "Content-Description: Document." );

//quite var conexion porque las leo include

backup_tables($host,$user,$pass,$dbname);

function backup_tables($host,$user,$pass,$name,$tables = '*') {
   $return = "";
   $link = mysql_connect($host,$user,$pass);
   mysql_select_db($name,$link);
   

   if($tables == '*')
   {
      $tables = array();
      $result = mysql_query('SHOW TABLES');
      while($row = mysql_fetch_row($result))
      {
         $tables[] = $row[0];
      }
   }
   else
   {
      $tables = is_array($tables) ? $tables : explode(',',$tables);
   }
      
   foreach($tables as $table) {
      $result = mysql_query('SELECT * FROM '.$table);
      $num_fields = mysql_num_fields($result);
      
	  //$return.= 'CREATE TABLE IF NOT EXISTS '.$table.';';
      $return.= 'DROP TABLE IF EXISTS '.$table.';';
      $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
      $return.= "\n\n".$row2[1].";\n\n";
      
    for ($i = 0; $i < $num_fields; $i++)
      {
         while($row = mysql_fetch_row($result))
         {
            $return.= 'INSERT INTO '.$table.' VALUES(';
            for($j=0; $j<$num_fields; $j++) 
            {
               $row[$j] = addslashes($row[$j]);
               //$row[$j] = preg_replace('/[^A-Za-z0-9_]/', '',$row[$j]);
			   //$row[$j] = utf8_encode($row[$j]);
               if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
               if ($j<($num_fields-1)) { $return.= ','; }
            }
            $return.= ");\n";
         }
      }
      $return.="\n\n\n";
   }
   echo $return;

   //save file
   $handle = fopen('../backups/backups_realizados/'.date('Y-m-d').'-sysnetbd.sql','w+');
   fwrite($handle,$return);
   fclose($handle);
}
?>