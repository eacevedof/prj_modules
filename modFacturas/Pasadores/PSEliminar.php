<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
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
            if($sAccion=="E") //Eliminar esta factura
            {
                $oBD = new CBaseDatos();
                $bEstado=$oBD->fBoolConectar();
                if(isset($_SESSION['arIDS']))
                {
                    $arIDS=$_SESSION['arIDS'];
                    for ($i=0; $i<count($arIDS); $i++)
                    {
                        $oFTmp=new CFactura($arIDS[$i], null, null, null, null, null, null, null);
                        $oFTmp->EliminarF();
                    }
                }
                else if(isset($_SESSION['oFactura']))
                {
                    $oFactura=$_SESSION['oFactura'];
                    $oFactura->EliminarF();
                }
            }
            unset($_SESSION['oFactura']);
            unset($_SESSION['arIDS']);
            $oFactura=null;
            $oFtmp=null;
            header('Location: ../Backend/UILista.php');
            exit;
        }
        else
        {
            $_SESSION['sWarning']="Pasador: USUARIO SIN PRIVILEGIOS";
        }
    }
    header('Location: ../../index.php');
    exit;
?>