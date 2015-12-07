<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';
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
            $oBD = new CBaseDatos();
            $bEstado=$oBD->fBoolConectar();
            $oFactura=new CFactura($_POST['hidID'], null, null, null, null, null, null, null);
            $oFactura->pAtributosDesdeIDN($oBD);

            //Obtengo la Accion
            $sAccion=$_POST['hidAccion'];
            //COMPRUEBO LA ACCION
            if ($sAccion=="A")
            {
                header('Location: ../Backend/UIAgregar.php');
            }
            else if($sAccion=="M")//M:Modificar F:Ficha
            {
                $_SESSION['oFactura']=$oFactura;
                header('Location: ../BackEnd/UIModificar.php');
            }
            else if($sAccion=="F")
            {
                $_SESSION['oFactura']=$oFactura;
                header('Location: ../BackEnd/UIFicha.php');
            }
            else if($sAccion=="E") //E: Eliminar
            {
                if (isset($_POST['chkID']))  //se envia desde UILista
                {
                    $_SESSION['arIDS']=$_POST['chkID'];
                }
                else if(isset($_POST['hidID'])) //hidID se envia desde UIFicha
                {
                    $_SESSION['oFactura']=$oFactura;
                }
                header('Location: ../BackEnd/UIEliminar.php');
            }
            else if($sAccion=="P") //P: Panel
            {
                header('Location: ../../modPanel/Backend/');
            }
            exit;
        }
        else
        {
            $_SESSION['sWarning']="PS: USUARIO SIN PRIVILEGIOS";
        }
    }
    header('Location: ../../index.php');
    exit;
?>