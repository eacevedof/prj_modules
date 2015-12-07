<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    //Se le llama desde el Panel_i.php
    require_once $_RUTARAIZ.'modConexion/Clases/class.ConstBD.php';
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CValida.php';
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
            $iIDN=$_POST['hidNumref'];
            //$sLogin=$_POST['txtLogin'];
            //$sClave=$_POST['txtClave'];
            $sEmail=$_POST['txtEmail'];
            $sNombres=$_POST['txtNombres'];
            $sApellidos=$_POST['txtApellidos'];
            $sTelefonos=$_POST['txtTelefonos'];
            $sPais=$_POST['selPais'];
            $sRegion=$_POST['selRegion'];
            $sCodpos=$_POST['txtCodpos'];
            $bSexo=$_POST['radSexo'];
            $dFecnac=$_POST['selFecnac'];

            //Con funciones
            //$sEstado="ACTIVO";
            $sUltimaAccion="MODIFICACION DE DATOS";
            $iEjecpor=$oUsuSesion->getIdUsuario();
            $dEjecfec=date("Y-n-j").' '.date("h:i:s");
            //$sCategoria="SUPER";

            //ZONA FILTRO
            if(!CValida::fBoolEmail($sEmail))
            {
                $_SESSION['sWarning']="EMAIL no valido!";
            }
            elseif(!CValida::fBoolNombres($sNombres))
            {
                $_SESSION['sWarning']="NOMBRES con caracteres invalidos!";
            }
            elseif(!CValida::fBoolNombres($sApellidos))
            {
                $_SESSION['sWarning']="APELLIDOS con caracteres invalidos"
            }
            elseif(!CValida::fBoolTelefono($sTelefonos))
            {
                $_SESSION['sWarning']="TELEFONO no valido"
            }
            elseif(!CValida::fBoolPais($sPais))
            {
                $_SESSION['sWarning']=""
            }
            elseif(!CValida::fBoolT($sTelefonos))
            {
                $_SESSION['sWarning']=""
            }
            //TODO: Al modificar debo ver que no haya campos repetidos en los campos unicos ejemplo
            //email
            //TODO: Debo comprobar que los datos sean coherentes con ayuda de expresiones
            //regulares si alguno da error voy al UI con el warning de error

            //Conecto con la base de datos
            $oBD = new CBaseDatos(sUserBD,sClaveBD);
            $bEstado=$oBD->fBoolConectar();

            //new CUsuario($iIDN, $sLogin, $sClave, $sEmail, $sNombres, $sApellidos,
            //$sTelefonos, $sPais, $sRegion, $sCodpos, $sSexo, $dFecnac, $sCategoria, $sEstado,
            //$sUltimaAccion, $iEjecpor, $sEjecfec)
            $oUsuDatosW=new CUsuario($iIDN, null, null, $sEmail, $sNombres, $sApellidos,
                $sTelefonos, $sPais, $sRegion, $sCodpos, $bSexo, $dFecnac, null, null,
                $sUltimaAccion, $iEjecpor, $dEjecfec);
            //Escribo en la BD
            $oUsuDatosW->ModificarDatos();
            if($oUsuSesion->getIdUsuario() == $iHidNumref)
            {
                $oUsuSesion=new CUsuario($iDN, null, null, null, null, null, null, null, null,
                                         null, null, null, null, null, null, null, null);
                $oUsuSesion->pAtributosDesdeIDN($oBD);
                $_SESSION['oUsuSesion']=$oUsuSesion;
            }
            $_SESSION['sWarning']="Los datos han sido modificados!!";
        }
        else
        {
            $_SESSION['sWarning']="Error: No tiene privilegios!!";
        }
    }
    header('Location: ../../index.php');
    exit;
?>