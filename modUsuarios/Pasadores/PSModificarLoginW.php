<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.ConstBD.php';
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
?>
<?php
    //Borrar codigo de prueba son variables q se crearan al ingresar al sitema
    //y cuando esten en el panel
    //$_SESSION['bAcceso']=true;
    $_POST['hidNumref']=1;
    $bSesion=true;
    //fin borrar

    //$bSesion=CUtils::fBoolSesion();
      
    if(!$bSesion)
    {
       header('Location: '.$_RUTARAIZ.'ModAcceso/FrontEnd/Acceso.php');
       exit;
    }
    else
    {
        //Recuperar usuario con hidNumref
        if(!empty($_POST['hidNumref']))
        {
            $iIDN=$_POST['hidNumref'];
            $sLoginN=$_POST['txtLoginN'];

            //Conecto con la base de datos
            $oBD = new CBaseDatos(sUserBD,sClaveBD);
            $bEstado=$oBD->fBoolConectar();

            if(CUsuario::fStrLoginOK($sLoginN, $oBD)=="Y")
            {

                $oModDatos=new CUsuario($iIDN, $sLoginN, null, null, null, null,
                    null, null, null, null, null, null, null, null, null, null);
                //Escribo en la BD
                $oModDatos->ModificarLogin();
            }
            else
            {
                header('Location: '.$_RUTARAIZ.'index.php');
                exit;
            }
        }
        else
        {
            header('Location: UsuarioListaR.php');
            exit;
        }
    }
?>