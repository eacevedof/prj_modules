//Enfoca
function pEnfoca(eId)
{
    var oElemento=document.getElementById(eId);
    oElemento.focus();
}

//METODO
//Un elemento etiqueta que este creado previamente con getElembyid
//y que tenga un texto se resetea
function pLimpiaElemento(oElemento)
{
    while ( oElemento.firstChild )
    {
        oElemento.removeChild( oElemento.firstChild );
    }

    var nodoLimpia=document.createTextNode("");
    oElemento.appendChild(nodoLimpia);
}

//UsuarioNuevo.php
//metodo para verificar que la clave no este vacia
function pClaveOnBlur()
{

    var txtClave1, txtClave2;
    var spnClave, divMensaje;

    divMensaje=document.getElementById("divMensaje");
    spnClave=document.getElementById("spnClave");
    txtClave1=document.getElementById("txtClave1");
    txtClave2=document.getElementById("txtClave2");

    spnClave.firstChild.data="";
    
    if(txtClave1.value!=txtClave2.value)
    {
        var nodoTexto=document.createTextNode("Las claves no son iguales");
        pLimpiaElemento(divMensaje);
        divMensaje.appendChild(nodoTexto);

        spnClave.firstChild.data="x";
        txtClave1.focus();
        return false;
    }
    else
    {
        return true;
    }

}

//UsuarioNuevo.php
//funcion onsubmit, verifica errores antes de enviar y crear un nuevo usuario
//c caracter 'N' o 'M' nuevo, modificar
function fValidaDatos(cN_M)
{
    var divMensaje=document.getElementById('divMensaje');
    var nodoTexto;
    
    pLimpiaElemento(divMensaje);
    
    var arNombresTxt=new Array();
    
    arNombresTxt[0]="txtNombre";
    arNombresTxt[1]="txtApellido";
    arNombresTxt[2]="txtLogin";
    arNombresTxt[3]="txtClave1";
    arNombresTxt[4]="txtClave2";

    //Compruebo vacios
    for (var i=0; i<arNombresTxt.length; i++)
    {
        var textBox=document.getElementById(arNombresTxt[i]);
        if(textBox.value=="")
        {
            textBox.focus();
            nodoTexto=document.createTextNode("Campo vacio!!");
            divMensaje.appendChild(nodoTexto);
            return false;
        }
    }

    var txtClave1=document.getElementById(arNombresTxt[3]);
    var txtClave2=document.getElementById(arNombresTxt[4]);

    if(txtClave1.value != txtClave2.value)
    {
        nodoTexto=document.createTextNode("Las claves no son iguales!");
        divMensaje.appendChild(nodoTexto);

        txtClave1.focus();
        return false;
    }

    var patronLogin = /^[a-zd_]{4,28}$/i;
    var txtLogin=document.getElementById(arNombresTxt[2]);
    var txtHidden=document.getElementById("hidRespLogin");
    
    if(txtLogin.value.search(patronLogin)==-1)
    {
        nodoTexto=document.createTextNode("Login no valido, verifique que tenga al menos 4 caracteres y que no contenga caracteres especiales como: <,*,?,¿,+, etc!");
        divMensaje.appendChild(nodoTexto);
        txtLogin.focus();
        return false;
    }

    //Si es un nuevo usuario se bloquea el envio si esta duplicado, pero no si se esta modificando
    if(cN_M=='N')
    {
        if(txtHidden.value != "ok")
        {
            nodoTexto=document.createTextNode("Ya existe un usuario con ese Login!");
            divMensaje.appendChild(nodoTexto);

            txtLogin.focus();
            return false;
        }
    }
    else if(cN_M=='M')
    {

    }

    return true;
}

//UsuarioListaModR.php
//Al cargar el formulario autoselecciona el combo "sSelecID" con el valor sValor
function pSeleccionaValor(sSelecID,sValor)
{
    //http://www.forosdelweb.com/f13/seleccionar-valor-select-desde-javascript-402186/
    //alert(sSelecID+" valor"+sValor);
    var objCombo=document.getElementById(sSelecID);
    var iTamCombo=objCombo.length;

    for(i=0; i<iTamCombo; i++)
    {
        if ( sValor==objCombo.options[i].text)
        {
            //alert(objCombo.options[i].text);
            objCombo[i].selected=true;
            break;
        }
    }
}

//UsuarioListaR.php
//obtiene todos los checkboxes de la tabla y los pone a true
function pSelecAll(oCheckBox,sIdForm)
{

    var oForm=document.getElementById(sIdForm);
    var oChkBox;
    //Si se le dice selecciona todo con bTodo=true;

    for (i=0;i<oForm.elements.length;i++)
    {
        if(oForm.elements[i].type == "checkbox")
        {
            oChkBox=oForm.elements[i];
            if (oCheckBox.checked)
            {
                oChkBox.checked=1;
            }
            else
            {
                oChkBox.checked=0;
            }
        }
    }

}

//Verifica que se haya seleccionado al menos un registro
//activando algun checkbox
function fBoolEliminar(sIdForm)
{
    var oForm=document.getElementById(sIdForm);
    var oChkBox;
    //Si se le dice selecciona todo con bTodo=true;
    for (i=0;i<oForm.elements.length;i++)
    {
        if(oForm.elements[i].type == "checkbox")
        {
            oChkBox=oForm.elements[i];
            if (oChkBox.checked)
            {
                //Si al menos uno esta "Chequeado"
                return true;
            }
        }
    }
    //Si no se ha roto el bucle es pq ninguno esta
    //"Chequeado" por lo tanto devuelve false y anula el evento
    //click usando en onClick="return fBoolEliminar('frmUsuarios');"
    var sMensaje="Debe seleccionar almenos un\n"+
                    "\tregistro!!"
    alert(sMensaje);
    return false;
}

//PSLista.php
//metodo en este formulario hay una tabla que presenta botones modificar y un
//boton eliminar
function pClienteListaAccion(sIdBot)
{
    var hidAccion=document.getElementById('hidAccion');
    var eForm=document.getElementById('frmLista');
    var eBoton=document.getElementById(sIdBot);

    var sAccion=eBoton.value;
    if((sAccion=="Modificar") || (sAccion=="Detalles"))
    {
        var sBotNombre=eBoton.name;
        var hidNumref=document.getElementById('hidNumref');
        var iID=sBotNombre.substring(6);
        //Guardo el ID
        hidNumref.value = iID;
        //Guardo la accion
        if(sAccion=="Modificar")
        {
            hidAccion.value="M";
        }
        else
        {
            hidAccion.value="D";
        }
    }

    else if(sAccion=="Eliminar")
    {
        if(!fBoolEliminar(eForm.id)) //Si no hay ninguno seleccionado
        {
            return;
        }
        else
        {
            hidAccion.value="E";
        }
    }
    eForm.attributes.action.value="../Pasadores/PSListaRW.php";
    eForm.submit();
}

//PSFicha.php
//metodo en este formulario hay una tabla que presenta botones modificar y un
//boton eliminar
function pClienteFichaAccion(sIdBot)
{
    var hidAccion=document.getElementById('hidAccion');
    var eForm=document.getElementById('frmFicha');
    var eBoton=document.getElementById(sIdBot);

    var sAccion=eBoton.value;
    if(sAccion=="Modificar") 
    {
        hidAccion.value="M";
    }
    else if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
    }
    eForm.attributes.action.value="../Pasadores/PSFichaW.php";
    eForm.submit();
}

function pNoticiaListaAccion(sIdBot)
{
    var sBotNombre;
    var eForm=document.getElementById('frmNoticiaLista');
    var eBoton=document.getElementById(sIdBot);

    var sAccion=eBoton.value;
    if(sAccion=="Modificar")
    {
        var hidNumref=document.getElementById('hidNumref');
        sBotNombre=eBoton.name;
        var iID=sBotNombre.substring(3);
        //lleno el hidden para poder capturarlo con POST en el formulario
        hidNumref.value = iID;
        eForm.attributes.action.value="NoticiaListaModR.php";

    }
    else if(sAccion=="Eliminar")
    {
        if(fBoolEliminar('frmNoticiaLista'))
        {
            eForm.attributes.action.value="Clases/pNotListaEliR.php";
        }
        else
        {
            return;
        }
    }
    //alert(hidNumref.value);
    eForm.submit();
}

//funciones para cajas de texto
function pA_Mayusculas(eInputText)
{
    eInputText.value=eInputText.value.toUpperCase();
}

function pA_Minusculas(eInputText)
{
    eInputText.value=eInputText.value.toLowerCase();
}

function pIr(sPagina)
{
    window.top.location.href = sPagina;
}

function pPoneFecha(sIdTxtBox)
{
    var eTextBox=document.getElementById(sIdTxtBox);

    var datHoy = new Date();
    var iDia   = datHoy.getDate();
    var iMes = datHoy.getMonth();
    var iAnyo  = datHoy.getYear();
    //var dia = datHoy.getDay();
    if (iAnyo < 1000)
    {
       iAnyo += 1900;
    }
    
    var sFecha=iDia+"-"+iMes+"-"+iAnyo;

    eTextBox.value=sFecha;
}

//NoticiaListaModR.php y NoticiaNueva.php
//en el evento onblur de txtFecha
function fBoolFechaOk(oTextBox)
{
    var nodoTexto;
    var patronFecha = /([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})/;

    var divMensaje=document.getElementById('divMensaje');
    pLimpiaElemento(divMensaje);

    var eTxtFecha=document.getElementById(oTextBox.id);

    alert(eTxtFecha.value.search(patronFecha));
    if(eTxtFecha.value.search(patronFecha) == -1)
    {
        //si no cumple con el patron
        nodoTexto=document.createTextNode("La fecha debe tener el siguiente formato: DD-MM-AAAA");
        divMensaje.appendChild(nodoTexto);
        eTxtFecha.focus();
        return false;
    }
    return true;
}

function pEntrada()
{
    var eTxtLog=document.getElementById("txtLog");
    eTxtLog.value="gestiona";
    var eTxtPass=document.getElementById("txtPass");
    eTxtPass.value="bb12345678";
    var eTxtVeri=document.getElementById("txtVeri");
    eTxtVeri.value="ok";
}