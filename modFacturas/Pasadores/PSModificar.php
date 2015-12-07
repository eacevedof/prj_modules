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
            if($sAccion=="G") //Guardar Modificaciones
            {
                $oBD = new CBaseDatos();
                $bEstado=$oBD->fBoolConectar();

                $oFactura=$_SESSION['oFactura'];
                //MODIFICO la factura
                $oFactura->setFecha($_POST['txtFecha']);
                $oFactura->setIdCliente($_POST['selCliente']);
                $oFactura->setNotas(CUtils::fNotasBD(($_POST['txaNotas'])));
                $oFactura->setEstado($_POST['selEstado']);
                $oFactura->Modificar();

                //MODIFICO Y AGREGO los detalles
                $arDetalles=$_SESSION['arDetalles'];

                for($i=0; $i<count($arDetalles); $i++)
                {
                    if($arDetalles[$i]['IDN']!=null && $arDetalles[$i]['IDN']!="")
                    {
                        $oDetalles=new CDetalleFactura($arDetalles[$i]['IDN'], $arDetalles[$i]['CONCEPTO'], $arDetalles[$i]['CANTIDAD'], $oFactura->getIdFactura());
                        $oDetalles->Modificar();
                    }
                    else //son detalles nuevos
                    {
                        $oDetalles=new CDetalleFactura(null, $arDetalles[$i]['CONCEPTO'], $arDetalles[$i]['CANTIDAD'], $oFactura->getIdFactura());
                        $oDetalles->Agregar();
                    }
                }

                //ELIMINO los detalles
                $arElim=$_SESSION['arElim'];
                for($i=0; $i<count($arElim); $i++)
                {
                    $oDetalles=new CDetalleFactura($arElim[$i], null, null, null);
                    $oDetalles->EliminarF();
                }
                $_SESSION['sWarning']="Factura modificada!!";
            }
            //C Cancelar
            unset($_SESSION['oFactura']);
            unset($_SESSION['arDetalles']);
            unset($_SESSION['arElim']);
            $arElim=null;
            $arDetalles=null;
            $oFactura=null;
            
            header('Location: ../Backend/UILista.php');
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