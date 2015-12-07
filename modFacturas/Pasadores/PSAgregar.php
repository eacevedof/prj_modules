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
            if($sAccion=="G")
            {
                //Factura
                //$oFactura=new CFactura(null, null, null, null, null, null, null, null);
                $oFactura=$_SESSION['oFactura'];
                //Actualizo estos campos, por si se modificaron antes del envio
                $oFactura->setFecha($_POST['txtFecha']);
                $oFactura->setIdCliente($_POST['selCliente']);
                $oFactura->setNotas(CUtils::fNotasBD(($_POST['txaNotas'])));

                $arDetalles=$_SESSION['arDetalles'];
                //ZONA FILTRO TODO
                $oBD = new CBaseDatos();
                $bEstado=$oBD->fBoolConectar();

                //$oFacturaW=new CFactura(null, $arFactura['Fecha'], $arFactura['Subtotal'], $arFactura['Iva'], $arFactura['Total'], $arFactura['Estado'], $arFactura['Notas'], $arFactura['IdCliente']);
                $oFactura->Agregar();
                $iIdFactura=CFactura::fIdFactura
                (
                    $oBD,$oFactura->getFecha(), $oFactura->getSubtotal(), $oFactura->getIva(),
                    $oFactura->getTotal(), $oFactura->getEstado(), $oFactura->getNotas(), $oFactura->getIdCliente()
                );

                for($i=0; $i<count($arDetalles); $i++)
                {
                    $oDetalles=new CDetalleFactura(null, $arDetalles[$i]['Concepto'], $arDetalles[$i]['Cantidad'], $iIdFactura);
                    $oDetalles->Agregar();
                }
                $_SESSION['sWarning']="Factura agregada!!";
            }
            unset($_SESSION['oFactura']);
            unset($_SESSION['arDetalles']);
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