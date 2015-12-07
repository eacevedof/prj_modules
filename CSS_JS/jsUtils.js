//AUTHOR: www.burban.es
//eacevedof@yahoo.es

//Aplica el foco sobre cualquier elemento
function pEnfoca(sIdElemento)
{
    var oElemento=document.getElementById(sIdElemento);
    oElemento.focus();
}

//Limpia el texto que muestra un elemento, previamente
//deberia instanciarse con var e:getElementById
function pLimpiaElemento(oElemento)
{
    while (oElemento.firstChild)
    {
        oElemento.removeChild(oElemento.firstChild);
    }

    var nodoLimpia=document.createTextNode("");
    oElemento.appendChild(nodoLimpia);
}

//CONTROL SELECT (Lista Desplegable)
//Autoselecciona un valor. Lee sValor lo busca en las opciones del control SELECT
//y lo deja seleccionado
function pSeleccionaValor(sValor,sIdSelect)
{
    //http://www.forosdelweb.com/f13/seleccionar-valor-select-desde-javascript-402186/
    //alert(sIdSelect+" valor"+sValor);
    var objCombo=document.getElementById(sIdSelect);
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

//CONTROL RADIO (pociones)
//Autoselecciona un valor. Lee sValor lo busca en las opciones del control RADIO
//y lo deja seleccionado
function pSeleccionaRadio(sValor,sNameRadio)
{
    //alert(sIdRadio+" valor"+sValor);
    //Se usa nombre pq asi se agrupa con id no funciona
    var eRadio=document.getElementsByName(sNameRadio);
    var iTamRadio=eRadio.length;

    for(i=0; i<iTamRadio; i++)
    {
        if ( sValor==eRadio[i].value)
        {
            //alert(eRadio[i].value);
            eRadio[i].checked=true;
            break;
        }
    }
}

//CONTROL SELECT (Lista Desplegable)
//Autoselecciona un valor. Lee sValor lo busca en las opciones del control SELECT
//y lo deja seleccionado
function pSeleccionaValorIndice(sValor,sIdSelect)
{
    //http://www.forosdelweb.com/f13/seleccionar-valor-select-desde-javascript-402186/
    //alert(sIdSelect+" valor"+sValor);
    var objCombo=document.getElementById(sIdSelect);
    var iTamCombo=objCombo.length;
    for(i=0; i<iTamCombo; i++)
    {
        //alert("valor pasado="+sValor+". value="+objCombo.options[i].value.toString());
        if ( sValor==objCombo.options[i].value)
        {
            //alert("value="+objCombo.options[i].value);
            objCombo[i].selected=true;
            break;
        }
    }
}

//CONTROL CHECKBOX
//Alterna a "checked" o no todos los checkboxes en array.
//Lee un checkbox (instanciado antes con byId), lo busca en el formulario y cambia su
//valor.
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

//CONTROL CHECKBOX
//Verifica que se haya activado al menos un checkbox
//Utilizado sobretodo en tablas
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

//CONTROL TEXT (textbox)
//Lee el valor almacenado en un "eInputText" lo pasa a mayusculas y
//lo vuelve a insertar. Recomendado para el evento onblur con this
function pA_Mayusculas(eInputText)
{
    eInputText.value=eInputText.value.toUpperCase();
}

//CONTROL TEXT (textbox)
//Lee el valor almacenado en un "eInputText" lo pasa a minusculas y
//lo vuelve a insertar. Recomendado para el evento onblur con this
function pA_Minusculas(eInputText)
{
    eInputText.value=eInputText.value.toLowerCase();
}

//Inserta la fecha actual en un elemento input-text en el formato
//que admite PHP DD-MM-AAAA
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

//Mantiene el foco sobre oTextBox e imprime un mensaje en un DIV siempre
//que el formato de la fecha insertado no respete DD-MM-AAAA
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

//CONTROL BUTTON
//Lee una ruta, esta ruta se convierte en la pagina destino
function pIr(sPagina)
{
    window.top.location.href = sPagina;
}


