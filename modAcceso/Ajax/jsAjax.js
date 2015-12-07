//Constantes con los estados (STATE) de la peticion. Creo variables pq son mas intuitivas
//que los numeros, estos valores que se comprobaran en el evento "onreadystatechange"
//de la peticion
var READYSTATE_UNINTIALIZED=0;
var READYSTATE_LOADING=1;
var READYSTATE_LOADED=2;
var READYSTATE_INTERACTIVE=3;
var READYSTATE_COMPLETE=4;

//Esta funcion devuelve el objeto creado si no ha habido problemas en su intento
//sino devuelve un booleano false
function fCreaObjXMLHTTRequest()
{
    var oXmlReq=false;
    //Si el navegador soporta XMLHttpRequest entonces es un navegador estandar
    if(window.XMLHttpRequest)
    {
        oXmlReq=new XMLHttpRequest();
    }
    else if(window.ActiveXObject)//sino comprobamos que sea IE
    {
        //Como MICROSOFT maneja dos ActiveX para trabajar con AJAX, pruebo los 2
        try
        {
            oXmlReq= new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (sE)
        {
            alert("Excepcion: "+sE);
            oXmlReq= new ActiveXObject("Msxml2.XMLHTTP");
        }

    }
    return oXmlReq;
}

//sURL es el archivo PHP/JSP/ASP que usara el metodo $_POST['nombre_parametro'] para
function pNuevoLoginPOST(sArchivoPHP)
{
    var sRuta="http://"+location.host+"/ASEATODO/PHP/Clases/"+sArchivoPHP;
    var oTxtLogin, oSpanLogin, oHidden;

    oSpanLogin = document.getElementById('spnLogin');
    oTxtLogin = document.getElementById('txtLogin').value;
    oHidden= document.getElementById('hidRespLogin');
    
    var oXmlReq=fCreaObjXMLHTTRequest();
    
    if(oXmlReq)
    {
        var sParams="parLogin="+oTxtLogin;

        oXmlReq.open("POST", sRuta, true);
        //oXmlReq.open("POST", sRuta+"?"+sParametros, true);
        //alert(sRuta+"?"+sParametros);
        oXmlReq.onreadystatechange=function()
        {
            if(oXmlReq.readyState==READYSTATE_LOADING)
            {
                oSpanLogin.innerHTML = "..Cargando!";
            }
            else if(oXmlReq.readyState==READYSTATE_COMPLETE)
            {
                oSpanLogin.innerHTML = oXmlReq.responseText;
                oHidden.value=oXmlReq.responseText;
            }
        }
        
        oXmlReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oXmlReq.setRequestHeader("Content-length", sParams.length);
        oXmlReq.setRequestHeader("Connection", "close");

        oXmlReq.send(sParams);  //Con la funcion escape da error 
        delete(oXmlReq);
    }
    else
    {
        alert("no se pudo crear el objeto XMLHTTPRequest");
    }
}

function pCambioLoginPOST(sArchivoPHP)
{
    var sRuta="http://"+location.host+"/ASEATODO/PHP/Clases/"+sArchivoPHP;
    var oTxtLogin, oSpanLogin, oHidden;

    oSpanLogin = document.getElementById('spnLogin');
    oTxtLogin = document.getElementById('txtLogin').value;
    //Guarda la respuesta que viene del ajaxphp de modo que cuando se ejecuta el
    //envio final (sin ajax) se obtiene el valor de ese campo por javascript para
    //comprobar (x o ok) que este en un formato correcto
    oHidden= document.getElementById('hidRespLogin');

    var oXmlReq=fCreaObjXMLHTTRequest();
    //alert(sRuta);
    if(oXmlReq)
    {
        var sParams="parLogin="+oTxtLogin;

        oXmlReq.open("POST", sRuta, true);
        //oXmlReq.open("POST", sRuta+"?"+sParametros, true);
        //alert(sRuta+"?"+sParametros);
        oXmlReq.onreadystatechange=function()
        {
            if(oXmlReq.readyState==READYSTATE_LOADING)
            {
                oSpanLogin.innerHTML = "..Cargando!";
            }
            else if(oXmlReq.readyState==READYSTATE_COMPLETE)
            {
                oSpanLogin.innerHTML = oXmlReq.responseText;
                oHidden.value=oXmlReq.responseText;
            }
        }

        oXmlReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oXmlReq.setRequestHeader("Content-length", sParams.length);
        oXmlReq.setRequestHeader("Connection", "close");

        oXmlReq.send(sParams);  //Con la funcion escape da error
        delete(oXmlReq);
    }
    else
    {
        alert("no se pudo crear el objeto XMLHTTPRequest");
    }
}

/* EL ARCHIVO EN EL SERVIDOR el mio PHP seria asi su nombre es "PHPajax.php"

   <?php
    if (isset($_GET['parEmail']))
    {
        //lo que mando a imprimir se recupera con oXmlReq.responseText
        echo strtoupper($_GET['parEmail']);
    }
    //Cuando termina la ejecucion en el servidor a la peticion se le asigna
    //READYSTATE_COMPLETE
   ?>

   EN EL <HTML> dentro de un FORM
   debere tener algo como esto
   <label id="lblMensaje"></label>
   <input type="text" id="txtUsMail" name="txtUsMail" onkeyup="pMuestraGET('PHPajax.php');" />
   <input type="password" id="txtClave" name="txtClave" onkeypress="pMuestraGET('PHPajax.php');" />

 */

