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
//-----------------------------------------------------------------------------------------------
function popup(url,nombre,ancho,alto,scroll) {
newWindow = window.open(url,nombre,'resizable=yes,menubar=no,location=no,toolbar=no,status=no,scrollbars='+scroll+',directories=no,width='+ancho+',height='+alto+',left='+(screen.availWidth-ancho)/2+',top='+(screen.availHeight-alto)/2);
}
//------------------------------------------------------------------

function mostrardiv(diva,divb) {
	div = document.getElementById('masdatos'+diva);
	div.style.display = '';
	div = document.getElementById('mas'+diva);
	div.style.display = 'none';
	div = document.getElementById('menos'+diva);
	div.style.display = '';
}
function cerrardiv(diva,divb) {
	div = document.getElementById('masdatos'+diva);
	div.style.display = 'none';
	div = document.getElementById('menos'+diva);
	div.style.display = 'none';
	div = document.getElementById('mas'+diva);
	div.style.display = '';
}
function seleccionar_todo(){ 
if(document.listado.ch0.checked) {
	for (i=0;i<document.listado.elements.length;i++) 
   	 if((document.listado.elements[i].type == "checkbox") && (document.listado.elements[i].disabled == false)) { document.listado.elements[i].checked=1 } 
} else {
	for (i=0;i<document.listado.elements.length;i++) 
   	 if((document.listado.elements[i].type == "checkbox") && (document.listado.elements[i].disabled == false)) { document.listado.elements[i].checked=0 } 
	}
}
function seleccion(valor) {
	if (valor != 0) {
		var total = document.listado.ch.length;
		var cont = 0;
		ira = "";
		rela="";

    	for (i=0;i<total;i++){ 
    	   if (document.listado.ch[i].checked) {
			rela+= document.listado.ch[i].value+',';
            cont++;
		   }
    	} 

		if(typeof total=="undefined") {
			if(document.listado.ch.checked==true) {
				rela+= document.listado.ch.value+',';
				cont++;
			}
		}
		
		if (cont == 0) {
			document.listado.seleccionados.value = 0;
			alert('No ha seleccionado ningun item para realizar esta acción');
		} else {
			var r= confirm('¿Esta seguro que desea realizar esta acción en todos los items seleccionados?');
			if (r==true) {
				ira= document.listado.seleccionados.options[document.listado.seleccionados.selectedIndex].value;
				document.listado.seleccionados.value = 0;
				document.listado.idborrar.value = rela;
				document.listado.action= ira;
				document.listado.submit();
			} else {
				document.listado.seleccionados.value = 0;
			}
		}
	}
}
//--------------------------//
function ValidarLetras(sPass) {
	var passexp =/^[A-Za-zñÑáéíóúÁÉÍÓÚ\_\-\.\s\xF1\xD1]+$/;
    if (passexp.test(sPass))
    	return 0
    else
    	return 1
}
function ValidarMail(sEmail) {
    var emailexp = /^[a-z_0-9\-\']+(\.[a-z_0-9\-\']+)*@[a-z_0-9\-]+(\.[a-z_0-9\-]+){1,}$/i
    if (emailexp.test(sEmail) )
    	return 0
    else
    	return 1
}
function ValidarClave(sPass) {
    var passexp = /^[a-z_0-9\-\']{1,}$/i
    if (passexp.test(sPass))
    	return 0
    else 
		return 1
}

//-----------------------------------------------------------------------------------------------

function mostrar(/* id a ocultar/mostrar */ id, /* elemento a cambiar texto */ mi, texto )
{
	mos = document.getElementById(id);
	if(mos.style.display == "block") { mos.style.display = "none"; }
	else { mos.style.display = "block"; }
	if(mi)
	{
		mi.setAttribute("onclick", "mostrar('" + id + "', this, '" + mi.innerHTML + "')");
		mi.innerHTML = texto;
	}
}

var xmlhttp;
var xmlhttp2;
var xmlDoc;

function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function GetXmlHttpObject(handler)
{
   var objXMLHttp=null
   if (window.XMLHttpRequest)
   {
	   objXMLHttp=new XMLHttpRequest()
   }
   else if (window.ActiveXObject)
   {
	   objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
   }
   return objXMLHttp
}

function htmlData(url, qStr, reemp)
{
	var contenido;

	if(reemp) { contenido = document.getElementById("localidades"+reemp); } else { contenido = document.getElementById("localidades"); } 

	if(url.length==0) { contenido.innerHTML=""; return; }

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null) { alert ("Browser does not support HTTP Request"); return; }

	url=url+"?"+qStr;
	url=url+"&sid="+Math.random();
	if(reemp) { url += "&corch" }
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			contenido.innerHTML= xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChanged()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById("localidades").innerHTML= xmlHttp.responseText;
	}
}

function borrar_responsable() {
	document.cargar.responsable_id.value = 0;
	document.cargar.responsable.value = '';
	return;
}

function borrar_matricula() {
	document.cargar.matricula_id.value = 0;
	document.cargar.matricula.value = '';
	return;
}

function borrar_netbook() {
	document.cargar.netbook_id.value = 0;
	document.cargar.netbook.value = '';
	return;
}

function divreclamo(estado) {
	div = document.getElementById('flotante');
	if (estado == 3) {
		div.style.display = '';
	} else {
		div.style.display = 'none';		
	}
}

//-----------------------------------------------------------------
// validaciones
//----------------------------------------------------------------
function validarmatricula() {
	if (document.cargar.apellido.value == "") {
		alert("Error\nNo ha ingresado el apellido del matriculado");
		document.cargar.apellido.focus();
		return false;
	}
    if (ValidarLetras(document.cargar.apellido.value) ) {
        alert("Error\nEl apellido solo puede contener letras");
        document.cargar.apellido.focus();
        return false;
	}
	if (document.cargar.nombre.value == "") {
		alert("Error\nNo ha ingresado los nombres del matriculado");
		document.cargar.nombre.focus();
		return false;
	}	
    if (ValidarLetras(document.cargar.nombre.value) ) {
        alert("Error\nLos nombres solo pueden contener letras");
        document.cargar.nombre.focus();
        return false;
	}
	if (document.cargar.dni.value == "") {
		alert("Error\nNo ha ingresado el número de DNI del matriculado");
		document.cargar.dni.focus();
		return false;
	}
	if (isNaN(document.cargar.dni.value)) {
		alert("Error\nEl DNI debe contener solo números.");
		document.cargar.dni.focus();
		return false;
 	}
	if (document.cargar.dni.value.length < 8) {
		alert("Error\nEL DNI debe contener 8 números");
		document.cargar.dni.focus();
		return false;
	}
	if (document.cargar.cuil.value == "") {
		alert("Error\nNo ha ingresado el número de CUIL del matriculado");
		document.cargar.cuil.focus();
		return false;
	}
	if (isNaN(document.cargar.cuil.value)) {
		alert("Error\nEl CUIL debe contener solo números.");
		document.cargar.cuil.focus();
		return false;
 	}
	if (document.cargar.cuil.value.length < 11) {
		alert("Error\nEL CUIL debe contener 11 números");
		document.cargar.cuil.focus();
		return false;
	}
	if (document.cargar.calle.value == "") {
		alert("Error\nNo ha ingresado la calle del matriculado");
		document.cargar.calle.focus();
		return false;
	}	
	if (isNaN(document.cargar.nro.value)) {
		alert("Error\nEl número de casa debe contener solo números.");
		document.cargar.nro.focus();
		return false;
 	}
	if (document.cargar.provincia.value == "0") {
       alert("Error\nNo ha seleccionado la provincia a la que pertenece el matriculado");
       document.cargar.provincia.focus();
       return false;
    }
	if (document.cargar.localidad_id.value == "0") {
       alert("Error\nNo ha seleccionado la localidad a la que pertenece el matriculado");
       document.cargar.localidad_id.focus();
       return false;
    }
	if (isNaN(document.cargar.telefono.value)) {
		alert("Error\nEl télefono debe contener solo números.");
		document.cargar.telefono.focus();
		return false;
 	}
	if (isNaN(document.cargar.celular.value)) {
		alert("Error\nEl celular debe contener solo números.");
		document.cargar.celular.focus();
		return false;
 	}
    if ((document.cargar.email.value != "") && (ValidarMail(document.cargar.email.value))) {
       alert("Error\nEl email ingresado no es válido");
       document.cargar.email.focus();
    	return false;
    }
	if (document.cargar.seccion.value == "0") {
       alert("Error\nNo ha seleccionado la sección a la que pertenece el matriculado");
       document.cargar.seccion.focus();
       return false;
    }
	return true;
}

function validarresponsable() {
	if (document.cargar_resp.apellido.value == "") {
		alert("Error\nNo ha ingresado el apellido del responsable");
		document.cargar_resp.apellido.focus();
		return false;
	}
    if (ValidarLetras(document.cargar_resp.apellido.value) ) {
        alert("Error\nEl apellido solo puede contener letras");
        document.cargar_resp.apellido.focus();
        return false;
	}
	if (document.cargar_resp.nombre.value == "") {
		alert("Error\nNo ha ingresado los nombres del responsable");
		document.cargar_resp.nombre.focus();
		return false;
	}	
    if (ValidarLetras(document.cargar_resp.nombre.value) ) {
        alert("Error\nLos nombres solo pueden contener letras");
        document.cargar_resp.nombre.focus();
        return false;
	}
	if (document.cargar_resp.dni.value == "") {
		alert("Error\nNo ha ingresado el número de DNI del responsable");
		document.cargar_resp.dni.focus();
		return false;
	}
	if (isNaN(document.cargar_resp.dni.value)) {
		alert("Error\nEl DNI debe contener solo números.");
		document.cargar_resp.dni.focus();
		return false;
 	}
	if (document.cargar_resp.dni.value.length < 8) {
		alert("Error\nEL DNI debe contener 8 números");
		document.cargar_resp.dni.focus();
		return false;
	}
	if (document.cargar_resp.cuil.value == "") {
		alert("Error\nNo ha ingresado el número de CUIL del responsable");
		document.cargar_resp.cuil.focus();
		return false;
	}
	if (isNaN(document.cargar_resp.cuil.value)) {
		alert("Error\nEl CUIL debe contener solo números.");
		document.cargar_resp.cuil.focus();
		return false;
 	}
	if (document.cargar_resp.cuil.value.length < 11) {
		alert("Error\nEL CUIL debe contener 11 números");
		document.cargar_resp.cuil.focus();
		return false;
	}
	if (document.cargar_resp.calle.value == "") {
		alert("Error\nNo ha ingresado la calle del responsable");
		document.cargar_resp.calle.focus();
		return false;
	}	
	if (isNaN(document.cargar_resp.nro.value)) {
		alert("Error\nEl número de casa debe contener solo números.");
		document.cargar_resp.nro.focus();
		return false;
 	}
	if (document.cargar_resp.provincia.value == "0") {
       alert("Error\nNo ha seleccionado la provincia a la que pertenece el responsable");
       document.cargar_resp.provincia.focus();
       return false;
    }
	if (document.cargar_resp.localidad_id.value == "0") {
       alert("Error\nNo ha seleccionado la localidad a la que pertenece el responsable");
       document.cargar_resp.localidad_id.focus();
       return false;
    }
	if (isNaN(document.cargar_resp.telefono.value)) {
		alert("Error\nEl télefono debe contener solo números.");
		document.cargar_resp.telefono.focus();
		return false;
 	}
	if (isNaN(document.cargar_resp.celular.value)) {
		alert("Error\nEl celular debe contener solo números.");
		document.cargar_resp.celular.focus();
		return false;
 	}
    if ((document.cargar_resp.email.value != "") && (ValidarMail(document.cargar.email.value))) {
       alert("Error\nEl email ingresado no es válido");
       document.cargar_resp.email.focus();
    	return false;
    }
	return true;
}

function validarnetbook() {
	if (document.cargar.codigo.value == "") {
		alert("Error\nNo ha ingresado el codigo de la netbook");
		document.cargar.codigo.focus();
		return false;
	}
    if (document.cargar.marca_id.value == 0) {
        alert("Error\nNo ha seleccionado la marca de la netbook");
        document.cargar.marca_id.focus();
        return false;
	}
	if (document.cargar.modelo.value == "") {
		alert("Error\nNo ha ingresado el modelo de la netbook");
		document.cargar.modelo.focus();
		return false;
	}	
    if (document.cargar.serie.value == "") {
        alert("Error\nNo ha ingresado el número de serie de la netbook");
        document.cargar.serie.focus();
        return false;
	}
	if (document.cargar.macaddress.value == "") {
		alert("Error\nNo ha ingresado la Mac Address de la netbook");
		document.cargar.macaddress.focus();
		return false;
	}
    if (document.cargar.estado_id.value == 0) {
        alert("Error\nNo ha seleccionado el estado de la netbook");
        document.cargar.estado_id.focus();
        return false;
	}
	return true;
}

function validarsoporte() {
	if (document.cargar.caso.value == "") {
		alert("Error\nNo ha ingresado el nro de caso de la solicitud");
		document.cargar.caso.focus();
		return false;
	}
    if (document.cargar.estado_id.value == 0) {
        alert("Error\nNo ha seleccionado el estado de la netbook");
        document.cargar.estado_id.focus();
        return false;
	}
	if (document.cargar.fecha.value == "") {
		alert("Error\nNo ha seleccionado la fecha en la que se realizo la solicitud");
		document.cargar.fecha.focus();
		return false;
	}	
    if (document.cargar.netbook_id.value == 0) {
        alert("Error\nNo ha seleccionado la netbook correspondiente a dicha solicitud");
        return false;
	}
	if (document.cargar.descripcion.value == "") {
		alert("Error\nNo ha ingresado la descripción del problema de la netbook");
		document.cargar.descripcion.focus();
		return false;
	}
	return true;
}

function validarrespaldo() {
	if (document.subirbd.archivobd.value == "") {
		alert("Error\nNo ha seleccionado la copia de respaldo de la base de datos");
		return false;
	}
	return true;
}

function validarusuario() {
	if (document.cargar.apellido.value == "") {
		alert("Error\nNo ha ingresado el apellido del usuario");
		document.cargar.apellido.focus();
		return false;
	}
    if (ValidarLetras(document.cargar.apellido.value) ) {
        alert("Error\nEl apellido solo puede contener letras");
        document.cargar.apellido.focus();
        return false;
	}
	if (document.cargar.nombre.value == "") {
		alert("Error\nNo ha ingresado los nombres del usuario");
		document.cargar.nombre.focus();
		return false;
	}	
    if (ValidarLetras(document.cargar.nombre.value) ) {
        alert("Error\nLos nombres solo pueden contener letras");
        document.cargar.nombre.focus();
        return false;
	}
	if (document.cargar.dni.value == "") {
		alert("Error\nNo ha ingresado el número de DNI del usuario");
		document.cargar.dni.focus();
		return false;
	}
	if (isNaN(document.cargar.dni.value)) {
		alert("Error\nEl DNI debe contener solo números.");
		document.cargar.dni.focus();
		return false;
 	}
	if (document.cargar.dni.value.length < 8) {
		alert("Error\nEL DNI debe contener 8 números");
		document.cargar.dni.focus();
		return false;
	}
	if (isNaN(document.cargar.telefono.value)) {
		alert("Error\nEl télefono debe contener solo números.");
		document.cargar.telefono.focus();
		return false;
 	}
	if (isNaN(document.cargar.celular.value)) {
		alert("Error\nEl celular debe contener solo números.");
		document.cargar.celular.focus();
		return false;
 	}
	if (document.cargar.privilegio.value == "0") {
       alert("Error\nNo ha seleccionado el privilegio del usuario");
       document.cargar.privilegio.focus();
       return false;
    }

     if ((document.cargar.clave1.value != "") && (ValidarClave(document.cargar.clave1.value))){
                alert("Error\nLa contraseña ingresada no es válida");
                document.cargar.clave1.focus();
                return false;
     }else{
         if ((document.cargar.clave1.value != "") && (document.cargar.clave1.value != document.cargar.clave2.value)){
                    alert("Error\nLas contraseñas ingresadas no coinciden");
                    document.cargar.clave1.focus();
                    return false;
      	 }
     }
	if ((document.cargar.clave1.value != "") && ((document.cargar.clave1.value.length < 4) || (document.cargar.clave1.value.length > 50))) {
			alert("Error\nLa contraseña debe ser igual o superior a 4 caracteres y menor a 50");
			document.cargar.clave1.focus();
			return false;
		}
	return true;
}

function validarmisdatos() {
	if (isNaN(document.cargar.telefono.value)) {
		alert("Error\nEl télefono debe contener solo números.");
		document.cargar.telefono.focus();
		return false;
 	}
	if (isNaN(document.cargar.celular.value)) {
		alert("Error\nEl celular debe contener solo números.");
		document.cargar.celular.focus();
		return false;
 	}
    if ((document.cargar.clave1.value != "") && (ValidarClave(document.cargar.clave1.value))){
                alert("Error\nLa contraseña ingresada no es válida");
                document.cargar.clave1.focus();
                return false;
     }else{
         if ((document.cargar.clave1.value != "") && (document.cargar.clave1.value != document.cargar.clave2.value)){
                    alert("Error\nLas contraseñas ingresadas no coinciden");
                    document.cargar.clave1.focus();
                    return false;
      	 }
     }
	if ((document.cargar.clave1.value != "") && ((document.cargar.clave1.value.length < 4) || (document.cargar.clave1.value.length > 50))) {
			alert("Error\nLa contraseña debe ser igual o superior a 4 caracteres y menor a 50");
			document.cargar.clave1.focus();
			return false;
		}
	return true;
}

function validaringreso() {
	if (document.ingreso.dni.value == "") {
		alert("Error\nNo ha ingresado su DNI");
		document.ingreso.dni.focus();
		return false;
		}
		
	if (isNaN(document.ingreso.dni.value)) {
		alert("Error\nEl DNI debe contener solo números.");
		document.ingreso.dni.focus();
		return false;
 	}
	
	if (document.ingreso.dni.value.length < 8) {
		alert("Error\nEL DNI debe contener 8 números");
		document.ingreso.dni.focus();
		return false;
	}
		
	if (document.ingreso.clave.value == "") {
            alert("Error\nNo ha ingresado la contraseña");
            document.ingreso.clave.focus();
            return false;
	}else{
     	   if(ValidarClave(document.ingreso.clave.value)){
                alert("Error\nLa contraseña ingresada no es válida");
                document.ingreso.clave.focus();
                return false;
            }
    }
	if ((document.ingreso.clave.value.length < 4) || (document.ingreso.clave.value.length > 50)) {
			alert("Error\nLa contraseña debe ser igual o superior a 4 caracteres y menor a 50");
			document.ingreso.clave.focus();
			return false;
	}
	return true;
}

function validarcambioclave() {
	if (document.contacto.clave1.value == "") {
            alert("Error\nNo ha ingresado la nueva contraseña");
            document.contacto.clave1.focus();
            return false;
        }else{
            if(ValidarClave(document.contacto.clave1.value)){
                alert("Error\nLa contraseña ingresada no es válida");
                document.contacto.clave1.focus();
                return false;
            }else{
                if(document.contacto.clave1.value != document.contacto.clave2.value){
                    alert("Error\nLas contraseñas ingresadas no coinciden");
                    document.contacto.clave1.focus();
                    return false;
                }
            }
        }
		if ((document.contacto.clave1.value.length < 4) || (document.contacto.clave1.value.length > 50)) {
			alert("Error\nLa contraseña debe ser igual o superior a 4 caracteres y menor a 50");
			document.contacto.clave1.focus();
			return false;
		}
}

function validarseccion() {
	if (document.cargar_seccion.nombre.value == "") {
		alert("Error\nNo ha ingresado el nombre de la sección");
		return false;
	}
	return true;
}

function validaradmin() {
	if (document.cargar.apellido.value == "") {
		alert("Error\nNo ha ingresado el apellido del usuario");
		document.cargar.apellido.focus();
		return false;
	}
    if (ValidarLetras(document.cargar.apellido.value) ) {
        alert("Error\nEl apellido solo puede contener letras");
        document.cargar.apellido.focus();
        return false;
	}
	if (document.cargar.nombre.value == "") {
		alert("Error\nNo ha ingresado los nombres del usuario");
		document.cargar.nombre.focus();
		return false;
	}	
    if (ValidarLetras(document.cargar.nombre.value) ) {
        alert("Error\nLos nombres solo pueden contener letras");
        document.cargar.nombre.focus();
        return false;
	}
	if (document.cargar.dni.value == "") {
		alert("Error\nNo ha ingresado el número de DNI del usuario");
		document.cargar.dni.focus();
		return false;
	}
	if (isNaN(document.cargar.dni.value)) {
		alert("Error\nEl DNI debe contener solo números.");
		document.cargar.dni.focus();
		return false;
 	}
	if (document.cargar.dni.value.length < 8) {
		alert("Error\nEL DNI debe contener 8 números");
		document.cargar.dni.focus();
		return false;
	}
	if (document.cargar.clave1.value == "") {
		alert("Error\nNo ha ingresado la contraseña de ingreso");
		document.cargar.clave1.focus();
		return false;
	}
    if ((document.cargar.clave1.value != "") && (ValidarClave(document.cargar.clave1.value))){
                alert("Error\nLa contraseña ingresada no es válida");
                document.cargar.clave1.focus();
                return false;
     }else{
         if ((document.cargar.clave1.value != "") && (document.cargar.clave1.value != document.cargar.clave2.value)){
                    alert("Error\nLas contraseñas ingresadas no coinciden");
                    document.cargar.clave1.focus();
                    return false;
      	 }
     }
	if ((document.cargar.clave1.value != "") && ((document.cargar.clave1.value.length < 4) || (document.cargar.clave1.value.length > 50))) {
			alert("Error\nLa contraseña debe ser igual o superior a 4 caracteres y menor a 50");
			document.cargar.clave1.focus();
			return false;
	}
	if (document.cargar.acepto.checked) {
		return true;
	} else {
		alert("Error\nDebe aceptar que entiende que si no recuerda los datos cargados no podrá acceder a sysnet");
		return false;
	}
	return true;
}