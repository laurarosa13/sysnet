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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="imagetoolbar" content="no" />
        <title>Sysnet - Sistema de Administración de Netbooks</title>
        <meta name="ROBOTS" content="NOODP" />
        <meta name="KEYWORDS" content="" />
        <meta name="DESCRIPTION" content="" />
        <meta name="robots" content="index,follow" />
        <meta name="author" content="Laura Rosa" />
        <link rel="shortcut icon" href="../favicon.ico" />
        <link href="../estilos/reset.css" rel="stylesheet" type="text/css" />
        <link href="../estilos/estilos.css" rel="stylesheet" type="text/css" />
		<link href="../estilos/thickbox.css" rel="stylesheet" type="text/css" />
        <script src='../js/funciones.js' type='text/javascript'></script>
        <script src="../js/jquery-1.7.2.min.js" type="text/javascript"></script>
    </head>
    <body>
    <div id="contenedor">