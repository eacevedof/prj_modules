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

            if($sAccion=="M") //Ir a UIModificar
            {
                header('Location: ../BackEnd/UIModificar.php');
            }
            else if($sAccion=="E") //Eliminar esta factura
            {
                header('Location: ../BackEnd/UIEliminar.php');
            }
            else if($sAccion=="C") //Ir a UILista
            {
                unset($_SESSION['oFactura']);
                header('Location: ../BackEnd/UILista.php');
            }
            else if($sAccion=="PDF") //Crear PDF
            {
                header('Location: ../PDF/PDFFicha.php');
            }
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