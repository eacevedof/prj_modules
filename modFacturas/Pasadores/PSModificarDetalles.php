<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CValida.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CDetalleFactura.php';
?>
<?php
    session_start();
    $oUsuSesion=$_SESSION['oUsuSesion'];
    if($oUsuSesion==null||!$oUsuSesion->getSesion())
    {
       $_SESSION['sWarning']="Debe iniciar sesión.";
    }
    else
    {
        //COMPRUEBO LOS USUARIOS
        if (($oUsuSesion->getCategoria() == "SUPER") || ($oUsuSesion->getCategoria() == "ADMINISTRADOR"))
        {
            $sAccion=$_POST['hidAccion'];
            //DETALLES
            $arDetalles=$_SESSION['arDetalles'];
            $iFila=$_POST['hidFila'];
            
            if($sAccion=="A") //Agregar una fila a los detalles
            {
                $sConcepto=$_POST['txtConcep'.$iFila];
                $fCantidad=$_POST['txtCant'.$iFila];

                $arFilaD=Array
                (
                    "CONCEPTO" => $sConcepto,
                    "CANTIDAD" => $fCantidad
                );

                array_push($arDetalles, $arFilaD);
            }
            else if($sAccion=="M") //Modificar una fila con FORM DINAMICO
            {
                $sConcepto=$_POST['txtConcep'];
                $fCantidad=$_POST['txtCant'];
                $arDetalles[$iFila]['CONCEPTO']=$sConcepto;
                $arDetalles[$iFila]['CANTIDAD']=$fCantidad;
            }
            else if($sAccion=="E") //Eliminar una fila de los detalles
            {
                if(isset($_SESSION['arElim']))//Segunda y sucesivas
                {
                    $arElim=$_SESSION['arElim'];
                }
                else //Primera vez
                {
                    $arElim=Array();
                }

                //si exite el campo IDN o este no esta vacio es pq esta en
                //la BD y se tendra que eliminar, por eso se guarda en arElim
                if($arDetalles[$iFila]['IDN']!=null && $arDetalles[$iFila]['IDN']!="")
                {
                    array_push($arElim, $arDetalles[$iFila]['IDN']);
                }
                array_splice($arDetalles,$iFila,1);
                $_SESSION['arElim']=$arElim;
            }

            //CALCULO CANTIDADES
            $fSubtotal=0; $fIva=0; $fTotal=0;
            for ($i=0; $i<count($arDetalles); $i++)
            {
                $fSubtotal+=$arDetalles[$i]['CANTIDAD'];
            }
            //Actualizo el total
            $fIva=($fSubtotal*16)/100;
            $fTotal=$fSubtotal + $fIva;

            //REDONDEO A 2 Decimales
            $fSubtotal=round($fSubtotal,2);
            $fIva=round($fIva,2);
            $fTotal=round($fTotal,2);

            //GENERO FACTURA
            $oFactura=$_SESSION['oFactura'];

            if(isset($_POST['txtFecha']))
            {
               $oFactura->setFecha($_POST['txtFecha']);
            }
            $oFactura->setSubtotal($fSubtotal);
            $oFactura->setIva($fIva);
            $oFactura->setTotal($fTotal);
            if(isset($_POST['selEstado']))
            {
               $oFactura->setEstado($_POST['selEstado']);
            }
            if(isset($_POST['txaNotas']))
            {
               $oFactura->setNotas($_POST['txaNotas']);
            }
            if(isset($_POST['selCliente']))
            {
               $oFactura->setIdCliente($_POST['selCliente']);
            }            
            //ACTUALIZO Variables
            $_SESSION['oFactura']=$oFactura;
            $_SESSION['arDetalles']=$arDetalles;
          
            $_SESSION['sWarning']="";

            header('Location: ../Backend/UIModificar.php');
            exit;
        }
        else
        {
            $_SESSION['sWarning']="Error: No tiene privilegios!!";
        }
    }
    header('Location: ../../index.php');
    exit;
?>