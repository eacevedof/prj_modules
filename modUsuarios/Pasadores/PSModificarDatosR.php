<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.ConstBD.php';
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
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

            $oUsuDatosR=new CUsuario($iHidNumref, null, null, null, null, null, null,
                null, null, null, null, null, null, null, null, null, null);
            
            $oUsuDatosR->pAtributosDesdeIDN($oBD);

            $_SESSION['oUsuDatosR']=$oUsuDatosR;
            header('Location: ../BackEnd/UIModificarDatos.php');
            exit;
        }
        else
        {
            $_SESSION['sWarning']="Pasador: USUARIO SIN PRIVILEGIOS";
            header('Location: ../../index.php');
            exit;
        }
    }
?>