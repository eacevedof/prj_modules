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
                $oBD = new CBaseDatos();
                $bEstado=$oBD->fBoolConectar();

                $oCliente=$_SESSION['oCliente'];
                //MODIFICO la factura
                $oCliente->setCifnif($_POST['txtCifnif']);
                $oCliente->setEmpresa($_POST['txtEmpresa']);
                $oCliente->setCodpos($_POST['txtCodpos']);
                $oCliente->setCiudad($_POST['txtCiudad']);
                $oCliente->setDireccion($_POST['txtDirecc']);
                $oCliente->setTelefono($_POST['txtTelefo']);
                $oCliente->setMovil($_POST['txtMovil']);
                $oCliente->setPersonaContacto($_POST['txtPersona']);
                $oCliente->setEmail($_POST['txtEmail']);
                $oCliente->setCuentaBancaria($_POST['txtCuentaB']);
                $oCliente->setDominios(CUtils::fNotasBD($_POST['txaDominios']));
                $oCliente->setNotas(CUtils::fNotasBD($_POST['txaNotas']));

                $oCliente->Modificar();
                $_SESSION['sWarning']="Cliente modificado!!";
            }
            //C Cancelar
            unset($_SESSION['oCliente']);
            $oCliente=null;
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