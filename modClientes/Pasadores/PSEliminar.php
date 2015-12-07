<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CValida.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
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
                        $oCTmp=new CCliente($arIDS[$i], null, null, null, null, null, null,
                                    null, null, null, null, null, null);
                        $oCTmp->EliminarF();
                    }
                }
                else if(isset($_SESSION['oCliente']))
                {
                    $oCliente=$_SESSION['oCliente'];
                    $oCliente->EliminarF();
                }
            }
            unset($_SESSION['oCliente']);
            unset($_SESSION['arIDS']);
            $oCliente=null;
            $oCtmp=null;
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