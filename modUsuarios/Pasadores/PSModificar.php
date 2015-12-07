<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
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
            if($sAccion=="G") //Guardar Modificaciones
            {
                $oUsuario=$_SESSION['oUsuario'];

                $oUsuario->setLogin($_POST['txtLogin']);
                $oUsuario->setClave($_POST['pasClave2']);
                $oUsuario->setEmail($_POST['txtEmail']);
                $oUsuario->setNombres($_POST['txtNombres']);
                $oUsuario->setApellidos($_POST['txtApellidos']);
                $oUsuario->setTelefonos($_POST['txtTelefonos']);
                $oUsuario->setPais($_POST['txtPais']);
                $oUsuario->setRegion($_POST['txtRegion']);
                $oUsuario->setCodigoPostal($_POST['txtCodpos']);
                $oUsuario->setSexo($_POST['radSexo']);
                $oUsuario->setFechaNacimiento($_POST['txtFecha']);

                $sCategoria="USUARIO"; //SUPER - ADMINISTRADOR - USUARIO
                $sEstado="ACTIVO";    //ACTIVO - BLOQUEADO
                $sUltimaAccion="DATOS MODIFICADOS";  //DATOS MODIFICADOS - CREADO - BLOQUEADO
                $iEjecpor=$oUsuSesion->getIdUsuario();  //USUSESION->ID
                $dEjecfec=date("Y-n-j").' '.date("h:i:s"); //date("Y-n-j").' '.date("h:i:s")

                $oUsuario->setCagetgoria($sCategoria);
                $oUsuario->setEstado($sEstado);
                $oUsuario->setUltimaAccion($sUltimaAccion);
                $oUsuario->setEjecutadoPor($iEjecpor);
                $oUsuario->setEjecucionFecha($dEjecfec);

                $oBD = new CBaseDatos();
                $bEstado=$oBD->fBoolConectar();

                $oUsuario->Modificar();
                
                $_SESSION['sWarning']="Usuario modificado!!";
            }
            //C Cancelar
            unset($_SESSION['oUsuario']);
            $oUsuario=null;
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