//Devuelve un ID desde el id de un boton
//botDeti o botAgri etc..
function fIdBoton(eBoton)
{
    //eBoton.id=botDeti o botModi
    var sBotNombre=eBoton.id;
    var iID=sBotNombre.substring(6);
    return iID;
}

function pUILista(eBoton)
{
    var eForm=document.getElementById('frmLista');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    var hidID=document.getElementById('hidID');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Agregar")
    {
        hidAccion.value="A";
    }
    else if(sAccion=="Modificar")
    {
        hidAccion.value="M";
        hidID.value=fIdBoton(eBoton);
    }
    else if(sAccion=="Ficha")
    {
        hidAccion.value="F";
        hidID.value=fIdBoton(eBoton);
    }
    else if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
        //hidID.value=fIdBoton(eBoton); SE ENVIA checkboxes
    }
    else if(sAccion=="Panel")
    {
        hidAccion.value="P";
    }

    eForm.attributes.action.value="../Pasadores/PSLista.php";
    eForm.submit();
}

function pUIAgregar(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    var hidID=document.getElementById('hidID');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Guardar")
    {
        hidAccion.value="G";
    }
    else if(sAccion=="Cancelar")
    {
        hidAccion.value="C";
    }
    //Para Modificar, Ficha
    //hidID.value=fIdBoton(eBoton);
    eForm.attributes.action.value="../Pasadores/PSAgregar.php";
    eForm.submit();
}

function pUIAgregarDetalles(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    var hidFila=document.getElementById('hidFila');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Agregar")
    {
        hidAccion.value="A";
        hidFila.value=fIdBoton(eBoton);
    }
    else if(sAccion=="Modificar")
    {
        hidAccion.value="M";//Con formulario dinamico
        return;             //Fuerzo la salida
    }
    else if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
        hidFila.value=fIdBoton(eBoton);
    }
    
    eForm.attributes.action.value="../Pasadores/PSAgregarDetalles.php";
    eForm.submit();
}

function pUIModificarDetalles(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    var hidFila=document.getElementById('hidFila');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Agregar")
    {
        hidAccion.value="A";
        hidFila.value=fIdBoton(eBoton);
    }
    else if(sAccion=="Modificar")
    {
        hidAccion.value="M";//Con formulario dinamico
        return;             //Fuerzo la salida
    }
    else if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
        hidFila.value=fIdBoton(eBoton);
    }
    
    eForm.attributes.action.value="../Pasadores/PSModificarDetalles.php";
    eForm.submit();
}

function pUIModificar(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    //var hidID=document.getElementById('hidID');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Guardar")
    {
        hidAccion.value="G";
    }
    else if(sAccion=="Cancelar")
    {
        hidAccion.value="C";
    }
    eForm.attributes.action.value="../Pasadores/PSModificar.php";
    eForm.submit();
}

function pUIFicha(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    //var hidID=document.getElementById('hidID');
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Modificar")
    {
        hidAccion.value="M";
    }
    else if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
    }
    else if(sAccion=="Cancelar")
    {
        hidAccion.value="C";
    }
    else if(sAccion=="PDF")
    {
        hidAccion.value="PDF";
    }
    //hidID.value=fIdBoton(eBoton);
    eForm.attributes.action.value="../Pasadores/PSFicha.php";
    eForm.submit();
}

function pUIEliminar(eBoton)
{
    var eForm=document.getElementById('frmFactura');
    var eBot=document.getElementById(eBoton.id);
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Eliminar")
    {
        hidAccion.value="E";
    }
    else if(sAccion=="Cancelar")
    {
        hidAccion.value="C";
    }
    eForm.attributes.action.value="../Pasadores/PSEliminar.php";
    eForm.submit();
}