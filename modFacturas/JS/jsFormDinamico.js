//AUTOR: EDUARDO A. F.
//EMAIL: eduysucodigo.blogspot.com
//
//
//**************************************************************
//***********ZONA DE PARAMETROS DE LOS OBJETOS *****************//
//**************************************************************
////Estas son las propiedades basicas para crear los elementos.
//si quieres las puedes cambiar para ver el efecto que tienen
//
//arDIVFONDO: Son los parametros para el Div de fondo que evitara interaccionar con
//los elementos (controles) que hay detras.  Los que programan en .NET es el
//equivalente a la opcion MODAL del formulario.
var arDIVFONDO=new Array();
arDIVFONDO['id']="divFondo";
arDIVFONDO['Alto']="0px";
arDIVFONDO['Ancho']="0px";
arDIVFONDO['ColorFondo']="#000";
arDIVFONDO['Opacidad']=".5";
arDIVFONDO['Filtro']="alpha(opacity=50)";
arDIVFONDO['Posicion']="absolute";
arDIVFONDO['z']="1";
arDIVFONDO['y']="0px";
arDIVFONDO['x']="0px";
arDIVFONDO['Padding']="0px";

//arDIVFORM: Contenedor del formulario ojo con z pq su padre no es el arDIVFONDO
//si fuera asi, todo se veria con opacidad asi que este, esta encima con z=2
var arDIVFORM=new Array();
arDIVFORM['id']="divForm";
arDIVFORM['Alto']="55px";
arDIVFORM['Ancho']="499px";
arDIVFORM['ColorFondo']="white";
arDIVFORM['Opacidad']=".99";
arDIVFORM['Filtro']="alpha(opacity=100)";
arDIVFORM['Posicion']="absolute";
arDIVFORM['z']="2";
arDIVFORM['y']="0px";
arDIVFORM['x']="0px";
arDIVFORM['Padding']="10px";

//arFORM: Los atributos del formulario que ira dentro de divForm
var arFORM=new Array();
arFORM['id']="frmEditar";
arFORM['Nombre']="frmEditar";
arFORM['Metodo']="post";
arFORM['Accion']="ruta_arhivo.php";  //modificar
arFORM['Alto']="auto";
arFORM['Ancho']="auto";
arFORM['ColorFondo']="auto";
arFORM['Posicion']="relative";
arFORM['z']="2";
arFORM['y']="0px";
arFORM['x']="0px";
arFORM['Padding']="0";

//arTabla: La tabla que utilizare para ordenar los controles
//se que esto no cumple con W3C Strict, pero si me ponia con fieldset se me
//iba hacer muy largo. 2Filas una la cabecera y otra con los controles
var arTABLA=new Array();
arTABLA['id']="tabDetalles";
arTABLA['Filas']=2;
arTABLA['Columnas']=5;
arTABLA['Alto']="auto";
arTABLA['Ancho']="auto";
arTABLA['ColorFondo']="auto";
arTABLA['Posicion']="relative";
arTABLA['z']="2";
arTABLA['y']="0px";
arTABLA['x']="0px";
arTABLA['Borde']="1px solid gray";

//arHIDDEN: Mi campo hidden necesario para enviarlo con POST y capturarlo con
//PHP
var arHIDDEN=new Array();
arHIDDEN['Tipo']="hidden";
arHIDDEN['id']="hidFila";
arHIDDEN['Nombre']="hidFila";
arHIDDEN['Valor']="5";          //Modificar, es el campo clave del registro

var arHIDDENAc=new Array();
arHIDDENAc['Tipo']="hidden";
arHIDDENAc['id']="hidAccion";
arHIDDENAc['Nombre']="hidAccion";
arHIDDENAc['Valor']="M";          //M es la accion a verifcar en el archivo.php

//arTXTCONCEP: Campo de texto "CONCEPTO"
var arTXTCONCEP=new Array();
arTXTCONCEP['Tipo']="text";
arTXTCONCEP['id']="txtConcep";
arTXTCONCEP['Nombre']="txtConcep";
arTXTCONCEP['Valor']="Diseño de tarjetas + impresion";  //Modificar
arTXTCONCEP['Ancho']="250px";

//arTXTCONCEP: Campo de texto "CANTIDAD"
var arTXTCANT=new Array();
arTXTCANT['Tipo']="text";
arTXTCANT['id']="txtCant";
arTXTCANT['Nombre']="txtCant";
arTXTCANT['Valor']=" 300,00 ";  //Modificar
arTXTCANT['Ancho']="70px";

//arBOTCANCELAR: Sirve para destruir las dos capas y permite seguir interactuando
//con el formulario original
var arBOTCANCELAR=new Array();
arBOTCANCELAR['Tipo']="button";
arBOTCANCELAR['id']="botCancelar";
arBOTCANCELAR['Nombre']="botCancelar";
arBOTCANCELAR['Valor']="Cancelar";
arBOTCANCELAR['Ancho']="auto";

//arSUBACEPTAR: Sirve para enviar la informacion del formulario. (El submit de toda la vida).
var arSUBACEPTAR=new Array();
arSUBACEPTAR['Tipo']="submit";
arSUBACEPTAR['id']="subAceptar";
arSUBACEPTAR['Nombre']="subAceptar";
arSUBACEPTAR['Valor']="Aceptar";
arSUBACEPTAR['Ancho']="auto";

//**************************************************************
//**************  FIN ZONA DE PARAMETROS  ********************//
//**************************************************************

//--- AQUI EMPIEZA LO BUENO -- //

//VARIABLES "GLOBALES" (por lo de la G ;0)
var oGVentana=null;   //Pq "o"? pq esta clase no gestiona ningun elemento DOM
var eGDivFondo=null;
var eGDivForm=null;
var eGFormulario=null;

var eGTabla=null;
var eGHidFila=null;
var eGTxtConcep=null;
var eGTxtCant=null;
var eGbotCancelar=null;
var eGSubAceptar=null;
var eGHidAccion=null;

var bGFrmCreado=false;


//CLASE VENTANA
function CVentana()
{
    var iAltura = 0; // height
    var iAnchura = 0; // width

    var pCalculaTamano=function()
    {
        if( typeof( window.innerHeight ) == 'number' )
        {
            iAltura = window.innerHeight;
            iAnchura = window.innerWidth;
        }
        else if( document.body && document.body.clientHeight )
        {
            //IE 4 o superior
            iAltura = document.body.clientHeight;
            iAnchura = document.body.clientWidth;
        }
    }

    pCalculaTamano();
    this.iAncho=iAnchura;
    this.iAlto=iAltura;

    this.getAncho=function()
    {
        return this.iAncho+"px";
    }
    this.getAlto=function()
    {
        return this.iAlto+"px";
    }
}

//CLASE FONDO
//sIdPadre es el ID del div donde se insertara este, si se pasa null el padre
//sera document.body
function CDiv(arDiv, sIdPadre)
{
    var ePadre=document.body;
    this.eDiv=document.createElement('div');

    with(this.eDiv)
    {
        id=arDiv['id'];
        style.height=arDiv['Alto'];
        style.width=arDiv['Ancho'];
        style.backgroundColor=arDiv['ColorFondo'];
        style.opacity=arDiv['Opacidad'];
        style.filter=arDiv['Filtro'];//PARA IE
        style.position=arDiv['Posicion'];
        style.zIndex=arDiv['z'];
        style.top=arDiv['y'];
        style.left=arDiv['x'];
        style.padding=arDiv['Padding'];
    }

    if(sIdPadre==null)
    {
        ePadre.appendChild(this.eDiv);
    }
    else
    {
        ePadre=document.getElementById(sIdPadre);
        ePadre.appendChild(this.eDiv);
    }

    //GETS
    this.getID=function()
    {
        return this.eDiv.id;
    }
    this.getWidth=function()
    {
        return this.eDiv.offsetWidth;
    }

    this.getHeight=function()
    {
        return this.eDiv.offsetHeight;
    }

    this.getTop=function()
    {
        return this.eDiv.offsetTop;
    }

    this.getLeft=function()
    {
        return this.eDiv.offsetLeft;
    }

    //SETS
    this.setWidth=function(sValor)
    {
        this.eDiv.style.width=sValor;
    }

    this.setHeight=function(sValor)
    {
        this.eDiv.style.height=sValor;
    }

    this.setTop=function(sValor)
    {
        this.eDiv.style.top=sValor;
    }

    this.setLeft=function(sValor)
    {
        this.eDiv.style.left=sValor;
    }
}

//CLASE FORMULARIO
function CForm(arForm, sIdPadre)
{
    var ePadre=document.body;
    this.eForm=document.createElement('form');

    with(this.eForm)
    {
        id=arForm['id'];
        setAttribute("name", arForm['Nombre']);
        setAttribute("method", arForm['Metodo']);
        setAttribute("action", arForm['Accion']);

        style.height=arForm['Alto'];
        style.width=arForm['Ancho'];
        style.backgroundColor=arForm['ColorFondo'];
        style.position=arForm['Posicion'];
        style.zIndex=arForm['z'];
        style.top=arForm['y'];
        style.left=arForm['x'];
        style.padding=arForm['Padding'];
        /*style.border="1px solid green";*/
    }

    if(sIdPadre==null)
    {
        ePadre.appendChild(this.eForm);
    }
    else
    {
        ePadre=document.getElementById(sIdPadre);
        ePadre.appendChild(this.eForm);
    }

    //GETS
    this.getID=function()
    {
        return this.eForm.id;
    }
    this.getWidth=function()
    {
        return this.eForm.offsetWidth;
    }

    this.getHeight=function()
    {
        return this.eForm.offsetHeight;
    }

    this.getTop=function()
    {
        return this.eForm.offsetTop;
    }

    this.getLeft=function()
    {
        return this.eForm.offsetLeft;
    }

    //SETS
    this.setWidth=function(sValor)
    {
        this.eForm.style.width=sValor;
    }

    this.setHeight=function(sValor)
    {
        this.eForm.style.height=sValor;
    }

    this.setTop=function(sValor)
    {
        this.eForm.style.top=sValor;
    }

    this.setLeft=function(sValor)
    {
        this.eForm.style.left=sValor;
    }
}

//CLASE INPUT boton, texto, hidden submit..
function CInput(arInput, eParent)
{
    var ePadre=document.body;
    this.eInput=document.createElement('input');

    with(this.eInput)
    {
        setAttribute("type", arInput['Tipo']);
        id=arInput['id'];
        setAttribute("name", arInput['Nombre']);
        setAttribute("value", arInput['Valor']);
        //Estilo
        style.width=arInput['Ancho'];
    }

    if(arInput['Tipo']=="button")
    {
        //Registramos los eventos
        //http://www.w3.org/TR/DOM-Level-2-Events/events.html
        if(document.all) //ES IE
        {
            this.eInput.attachEvent("onclick", pCancelar);
        }
        else //OTROS NAVEGADORES
        {
            this.eInput.addEventListener("click", pCancelar, true);
        }
    }


    function pCancelar()
    {
        var eDivAux = document.getElementById(eGDivForm.getID());
        document.body.removeChild(eDivAux);

        eDivAux = document.getElementById(eGDivFondo.getID());
        document.body.removeChild(eDivAux);

        //Destruyo mis objetos
        oGVentana=null;
        eGDivFondo=null;
        eGDivForm=null;
        eGFormulario=null;
        eGTabla=null;
        eGHidFila=null;
        eGTxtConcep=null;
        eGTxtCant=null;
        eGbotCancelar=null;
        eGSubAceptar=null;
        eGHidAccion=null;

        //Actualizo mi variable
        bGFrmCreado=false;
    }

    if(eParent==null)
    {
        ePadre.appendChild(this.eInput);
    }
    else
    {
        eParent.appendChild(this.eInput);
    }

    //GETS
    this.getID=function()
    {
        return this.eInput.id;
    }

    this.getValor=function()
    {
        return this.eInput.value;
    }

    this.getWidth=function()
    {
        return this.eInput.offsetWidth;
    }

    //SETS
    this.setWidth=function(sValor)
    {
        this.eInput.style.width=sValor;
    }
}

//CLASE TABLA
function CTabla(arTabla, sIdPadre)
{
    var arTextos=new Array();
    arTextos[0]="F";
    arTextos[1]="CONCEPTO";
    arTextos[2]="CANTIDAD";
    arTextos[3]="";
    arTextos[4]="";

    var ePadre=document.body;
    this.eTable=document.createElement('table');

    with(this.eTable)
    {
        id=arTabla['id'];
        setAttribute("name", arTabla['Nombre']);

        style.height=arTabla['Alto'];
        style.width=arTabla['Ancho'];
        style.backgroundColor=arTabla['ColorFondo'];
        style.position=arTabla['Posicion'];
        style.zIndex=arTabla['z'];
        style.top=arTabla['y'];
        style.left=arTabla['x'];
        style.padding=arTabla['Padding'];
        style.border=arTabla['Borde'];
    }
    //Genero la tabla
    for(var i=0; i<arTabla['Filas']; i++)
    {
        var auxTR=document.createElement("tr");
        for(var j=0; j<arTabla['Columnas']; j++)
        {
            var auxTD=document.createElement("td");
            var auxText;
            if(i==0) //Es la cabecera
            {
                auxText=document.createTextNode(arTextos[j]);
                auxTD.appendChild(auxText);
            }
            else //El resto de filas
            {
                switch (j)
                {
                    case 0:
                       eGHidFila = new CInput(arHIDDEN, auxTD);
                       auxText=document.createTextNode(eGHidFila.getValor());
                       auxTD.appendChild(auxText);
                        break
                    case 1:
                       eGTxtConcep = new CInput(arTXTCONCEP, auxTD);
                        break
                    case 2:
                       eGTxtCant = new CInput(arTXTCANT, auxTD);
                        break
                    case 3:
                       eGbotCancelar = new CInput(arBOTCANCELAR, auxTD);
                        break
                    case 4:
                       eGSubAceptar = new CInput(arSUBACEPTAR, auxTD);
                       eGHidAccion=new CInput(arHIDDENAc, auxTD);
                       break
                    default:
                        document.write("Esta columna no existe!!");
                }
            }
            auxTR.appendChild(auxTD);
        }
        this.eTable.appendChild(auxTR);
    }

    if(sIdPadre==null)
    {
        ePadre.appendChild(this.eTable);
    }
    else
    {
        ePadre=document.getElementById(sIdPadre);
        ePadre.appendChild(this.eTable);
    }

    //GETS
    this.getID=function()
    {
        return this.eTable.id;
    }
    this.getWidth=function()
    {
        return this.eTable.offsetWidth;
    }

    this.getHeight=function()
    {
        return this.eTable.offsetHeight;
    }

    this.getTop=function()
    {
        return this.eTable.offsetTop;
    }

    this.getLeft=function()
    {
        return this.eTable.offsetLeft;
    }

    //SETS
    this.setWidth=function(sValor)
    {
        this.eTable.style.width=sValor;
    }

    this.setHeight=function(sValor)
    {
        this.eTable.style.height=sValor;
    }

    this.setTop=function(sValor)
    {
        this.eTable.style.top=sValor;
    }

    this.setLeft=function(sValor)
    {
        this.eTable.style.left=sValor;
    }
}

//Genera el formulario, antes de llamar a este procedimiento se deberia
//actualizar el indice 'Valor' de los array
function pGeneraFormulario()
{
    //Objeto ventana obtiene el tamaño de la pantalla
    //necesario para el centrado y el recubrimiento de los controles
    oGVentana = new CVentana();

    //El elemento Div con opacidad
    eGDivFondo= new CDiv(arDIVFONDO,null);
    eGDivFondo.setWidth(oGVentana.getAncho());
    eGDivFondo.setHeight(oGVentana.getAlto());

    //El elemento Div contenedor del formulario
    eGDivForm = new CDiv(arDIVFORM, null);
    
    //Centro el contenedor en pantalla
    var aux=(eGDivFondo.getWidth()-eGDivForm.getWidth())/2 + "px";
    eGDivForm.setLeft(aux);
    aux=(eGDivFondo.getHeight()-eGDivForm.getHeight())/2 + "px";
    eGDivForm.setTop(aux);

    //Creo el Formulario y lo adjunto a su padre el eGDivForm
    eGFormulario=new CForm(arFORM, eGDivForm.getID());

    //Creo la Tabla (para tabular mis controles) y lo adjunto a su padre eGFormulario
    eGTabla=new CTabla(arTABLA, eGFormulario.getID());

    //Indico que se ha generado el formulario, esto me servira para
    //el evento que se ejecuta cuando se redimensiona la pantalla
    bGFrmCreado=true;
}

window.onresize = function ()
{
    if(bGFrmCreado)
    {
        //Creo nuevamente oVentana para actualizar su tamaño
        oGVentana = new CVentana();
        //Redimensiono el Div con opacidad
        eGDivFondo.setWidth(oGVentana.getAncho());
        eGDivFondo.setHeight(oGVentana.getAlto());

        //centro divForm
        var aux=(eGDivFondo.getWidth()-eGDivForm.getWidth())/2 + "px";
        eGDivForm.setLeft(aux);
        aux=(eGDivFondo.getHeight()-eGDivForm.getHeight())/2 + "px";
        eGDivForm.setTop(aux);
    }
}

//Llamado desde UIAgregar.php
function pFormAgregarDet(eBoton)
{
    var sIdTabla="tblDetalles"
    var arTextos=new Array();
    var iNumNodos=0;
    var eTabla=document.getElementById(sIdTabla);

    //Uso el boton para obtener el indice de la fila
    var iBot=eBoton.id;
    iBot=iBot.substring(6);
    iBot=iBot*2+1;
    //Como hay nodos de texto entre las filas la progresion es esa

    //nodos en una tabla: 0 texto, 1 thead, 2 texto, 3 tbody, 4 texto;
    //         eTabla.   tbody3    .    tr1      .  td1(varia) .   label1    .childnodes;
    //arTextos=eTabla.childNodes[3].childNodes[1].childNodes[1].childNodes[1].childNodes;

    iNumNodos = eTabla.childNodes[3].childNodes[iBot].childNodes.length;

    //le resto 5 pq las ultimas dos columnas son botones 2td+3txt=5nodos
    for (var i=0; i<iNumNodos-5; i++)
    {
        if(i%2==1)
        {
            var oNodoTexto=null;
            oNodoTexto=eTabla.childNodes[3].childNodes[iBot].childNodes[i].childNodes[1].firstChild;
            //alert("oNodoTexto="+oNodoTexto);
            if(oNodoTexto==null)
            {
                arTextos.push("-");
            }
            else
            {
                arTextos.push(oNodoTexto.data);
            }
        }
    }
    //alert(arTextos);
    arFORM['Accion']="../Pasadores/PSAgregarDetalles.php";
    arHIDDEN['Valor']=arTextos[0];
    arTXTCONCEP['Valor']=arTextos[1];
    arTXTCANT['Valor']=arTextos[2];
    pGeneraFormulario();
}
//Llamado desde UIModificar.php
function pFormModificarDet(eBoton)
{
    var sIdTabla="tblDetalles"
    var arTextos=new Array();
    var iNumNodos=0;
    var eTabla=document.getElementById(sIdTabla);

    //Uso el boton para obtener el indice de la fila
    var iBot=eBoton.id;
    iBot=iBot.substring(6);
    iBot=iBot*2+1;
    //Como hay nodos de texto entre las filas la progresion es esa

    //nodos en una tabla: 0 texto, 1 thead, 2 texto, 3 tbody, 4 texto;
    //         eTabla.   tbody3    .    tr1      .  td1(varia) .   label1    .childnodes;
    //arTextos=eTabla.childNodes[3].childNodes[1].childNodes[1].childNodes[1].childNodes;

    iNumNodos = eTabla.childNodes[3].childNodes[iBot].childNodes.length;

    //le resto 5 pq las ultimas dos columnas son botones 2td+3txt=5nodos
    for (var i=0; i<iNumNodos-5; i++)
    {
        if(i%2==1)
        {
            var oNodoTexto=null;
            oNodoTexto=eTabla.childNodes[3].childNodes[iBot].childNodes[i].childNodes[1].firstChild;
            //alert("oNodoTexto="+oNodoTexto);
            if(oNodoTexto==null)
            {
                arTextos.push("-");
            }
            else
            {
                arTextos.push(oNodoTexto.data);
            }
        }
    }
    var eHidID=document.getElementById("hidID"+eBoton.id.substring(6));
    arFORM['Accion']="../Pasadores/PSModificarDetalles.php";
    arHIDDEN['Valor']=arTextos[0];
    arTXTCONCEP['Valor']=arTextos[1];
    arTXTCANT['Valor']=arTextos[2];
    pGeneraFormulario();
}
