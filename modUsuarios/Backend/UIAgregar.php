<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
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
       header('Location: ../../index.php');
       exit;
    }
    else
    {
        //Los clientes para el slect
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        $arListaClientes=CCliente::fArTabla($oBD);

        //La factura y sus detalles
        $arDetalles=Array();

        if(isset($_SESSION['oUsuario']))
        {
            $oUsuario=$_SESSION['oUsuario'];
        }
        else
        {
            $oUsuario=new CUsuario(null, null, null, null, null, null, null,
                 null, null, null, null, null, null, null, null, null, null);
            $_SESSION['oUsuario']=$oUsuario;
        }

        $sWarning=$_SESSION['sWarning'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIAgregar.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../Ajax/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsUsuarios.js"></script>
    
    <title>USUARIOS - NUEVO</title>
</head>
<body onload="pAutoselecRadio('valor','radSexo');">
    <center>
    <!-- EL FORMULARO PARA CREAR-->
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <form id="frmUsuario" method="post" action="" class="clsUIAgregar">
        <fieldset>
            <div id="divFrmHead">NUEVO USUARIO</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>LOGIN:</label></dt>
                    <dd><input type="text" id="txtLogin" name="txtLogin" value="<?php echo $oUsuario->getLogin(); ?>" /></dd>
                    <dt><label>CLAVE:</label></dt>
                    <dd><input type="password" id="pasClave" name="pasClave" value="<?php echo $oUsuario->getClave(); ?>"/></dd>
                    <dt><label>REPETIR&nbsp;CLAVE:</label></dt>
                    <dd><input type="password" id="pasClave2" name="pasClave2" value="<?php echo $oUsuario->getClave(); ?>"/></dd>
                    <dt><label>EMAIL:</label></dt>
                    <dd><input type="text" id="txtEmail" name="txtEmail" value="<?php echo $oUsuario->getEmail(); ?>" /></dd>
                    <dt><label>NOMBRES:</label></dt>
                    <dd><input type="text" id="txtNombres" name="txtNombres" value="<?php echo $oUsuario->getNombres(); ?>" /></dd>
                    <dt><label>APELLIDOS</label></dt>
                    <dd><input type="text" id="txtApellidos" name="txtApellidos" value="<?php echo $oUsuario->getApellidos(); ?>" /></dd>
                    <dt><label>TELEFONOS</label></dt>
                    <dd><input type="text" id="txtTelefonos" name="txtTelefonos" value="<?php echo $oUsuario->getTelefonos(); ?>" /></dd>
                    <dt><label>PAIS</label></dt>
                    <dd><input type="text" id="txtPais" name="txtPais" value="<?php echo $oUsuario->getPais(); ?>" /></dd>
                    <dt><label>REGION</label></dt>
                    <dd><input type="text" id="txtRegion" name="txtRegion" value="<?php echo $oUsuario->getRegion(); ?>" /></dd>
                    <dt><label>COD.&nbsp;POSAL</label></dt>
                    <dd><input type="text" id="txtCodpos" name="txtCodpos" value="<?php echo $oUsuario->getCodigoPostal(); ?>" /></dd>
                    <dt><label>SEXO</label></dt>
                    <dd><input type="radio" id="radSexo" name="radSexo" value="H" checked="checked" />Hombre
                        <input type="radio" id="radSexo" name="radSexo" value="M" />Mujer</dd>
                    <dt><label>F.&nbsp;NACIMIENTO</label></dt>
                    <dd><input type="text" id="txtFecha" name="txtFecha" value="<?php echo $oUsuario->getFechaNacimiento(); ?>" /></dd>
                </dl>
                <div class="clsDivFix"></div>
            </div>
            <div id="divFrmFoot">
                <input type="hidden" id="hidAccion" name="hidAccion"/>
                <input type="button" id="botGuardar" name="botGuardar" value="Guardar" onclick="pUIAgregar(this);" />
                <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIAgregar(this);" />
            </div>
        </fieldset>

    </form>
    </center>
</body>
</html>
