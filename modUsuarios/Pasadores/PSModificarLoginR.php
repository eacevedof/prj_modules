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
    //Borrar codigo de prueba son variables q se crearan al ingresar al sitema
    //y cuando esten en el panel
    //$_SESSION['bAcceso']=true;
    $_POST['hidNumref']=1;
    $bSesion=true;
    //fin borrar

    //$bSesion=CUtils::fBoolSesion();
      
    if(!$bSesion)
    {
       header('Location: ../../ModAcceso/FrontEnd/Acceso.php');
       exit;
    }
    else
    {
        //Recuperar usuario con hidNumref
        if(!empty($_POST['hidNumref']))
        {
            $iIDN=$_POST['hidNumref'];

            //Conecto con la base de datos
            $oBD = new CBaseDatos(sUserBD,sClaveBD);
            $bEstado=$oBD->fBoolConectar();

            $oModLogin=new CUsuario($iIDN, null, null, null, null, null, null,
                null, null, null, null, null, null, null, null, null,null);
            $oModLogin->pAtributosDesdeIDN($oBD);

            $_SESSION['oModLogin']=$oModLogin;

            header('Location: ../BackEnd/UIModificarLogin.php');
            exit;
        }
        else
        {
            header('Location: UsuarioListaR.php');
            exit;
        }
    }
?>