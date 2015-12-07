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
            //FACTURA
            $oFactura=$_SESSION['oFactura'];

            //DETALLES
            $arDetalles=$_SESSION['arDetalles'];
            $iFila=$_POST['hidFila'];
            if($sAccion=="A") //Agregar una fila a los detalles
            {
                //Actualizo la factura
                $oFactura->setFecha($_POST['txtFecha']);
                $oFactura->setNotas($_POST['txaNotas']);
                $oFactura->setIdCliente($_POST['selCliente']);
                //Actualizo los detalles
                $sConcepto=$_POST['txtConcep'.$iFila];
                $fCantidad=$_POST['txtCant'.$iFila];
                $arFilaD=Array
                (
                    "Concepto" => $sConcepto,
                    "Cantidad" => $fCantidad
                );

                array_push($arDetalles, $arFilaD);
            }
            else if($sAccion=="M") //Modificar una fila con FORM DINAMICO
            {
                //Actualizo los detalles
                $sConcepto=$_POST['txtConcep'];
                $fCantidad=$_POST['txtCant'];
 
                $arDetalles[$iFila]['Concepto']=$sConcepto;
                $arDetalles[$iFila]['Cantidad']=$fCantidad;

            }
            else if($sAccion=="E") //Eliminar una fila de los detalles
            {
                //Actualizo la factura
                $oFactura->setFecha($_POST['txtFecha']);
                $oFactura->setNotas($_POST['txaNotas']);
                $oFactura->setIdCliente($_POST['selCliente']);
                //Actualizo los detalles
                array_splice($arDetalles,$iFila,1);
            }

            //CALCULO CANTIDADES
            $fSubtotal=0; $fIva=0; $fTotal=0;
            for ($i=0; $i<count($arDetalles); $i++)
            {
                $fSubtotal+=$arDetalles[$i]['Cantidad'];
            }
            //Actualizo el total
            $fIva=($fSubtotal*16)/100;
            $fTotal=$fSubtotal + $fIva;
            
            //REDONDEO A 2 Decimales
            $fSubtotal=round($fSubtotal,2);
            $fIva=round($fIva,2);
            $fTotal=round($fTotal,2);

            //ACTUALIZO cifras en factura
            $oFactura->setSubtotal($fSubtotal);
            $oFactura->setIva($fIva);
            $oFactura->setTotal($fTotal);

            //ACTUALIZO Variables
            $_SESSION['oFactura']=$oFactura;
            $_SESSION['arDetalles']=$arDetalles;
            $_SESSION['sWarning']="";

            header('Location: ../Backend/UIAgregar.php');
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