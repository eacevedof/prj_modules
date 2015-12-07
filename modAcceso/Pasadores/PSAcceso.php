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
    //Obtiene los datos desde el formulario;
    if (!empty($_POST['subAceptar']) )
    {
        $oBD = new CBaseDatos(sUserBD,sClaveBD);
        $bEstado=$oBD->fBoolConectar();
        //Datos desde formulario
        $sAccion=$_POST['hidAccion'];
        $sLogin=$_POST['txtLog'];
        $sClave=$_POST['pasClave'];
        $sBot=$_POST['txtVeri'];

        if(CUsuario::fBoolAcceso($sLogin, $sClave, $oBD) && $sBot=="ok")
        {
            $oUsuSesion = new CUsuario(null, $sLogin, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null);
            $oUsuSesion->pAtributosDesdeLogin($oBD);
            //Como todo esta correcto actualizo su sesion a true
            $oUsuSesion->setSesion(true);
            
            //Creo la variable de sesion
            $_SESSION['oUsuSesion']=$oUsuSesion;
            $_SESSION['sWarning']="BIENVENIDO";
            header('Location: ../../modPanel/Backend/index.php');
            exit;
        }
    }
    header('Location: ../../index.php');
?>