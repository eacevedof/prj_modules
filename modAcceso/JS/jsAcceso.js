//Devuelve un ID desde el id de un boton
//botDeti o botAgri etc..
function fIdBoton(eBoton)
{
    //eBoton.id=botDeti o botModi
    var sBotNombre=eBoton.id;
    var iID=sBotNombre.substring(6);
    return iID;
}

function pUIAcceso(eBoton)
{
    var eForm=document.getElementById('frmAcceso');
    var eBot=document.getElementById(eBoton.id);
    //Hidden
    var hidAccion=document.getElementById('hidAccion');

    var sAccion=eBot.value;
    if(sAccion=="Aceptar")
    {
        hidAccion.value="A";
    }
    else if(sAccion=="Cancelar")
    {
        hidAccion.value="C";
    }
    eForm.attributes.action.value="../Pasadores/PSAcceso.php";
    eForm.submit();
}