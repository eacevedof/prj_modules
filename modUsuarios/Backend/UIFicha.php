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

        //el Cliente
        $oUsuario = $_SESSION['oUsuario'];
        $oUsuario->pAtributosDesdeIDN($oBD);

        $sWarning=$_SESSION['sWarning'];
    }
    /*$oUsuario=new CUsuario(null, null, null, null, null, null, null,
                 null, null, null, null, null, null, null, null, null, null);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIFicha.css" media="screen" />
    
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../Ajax/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsUsuarios.js"></script>
    <title>USUARIO: <?php echo $oUsuario->getNombres(); ?></title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO DETALLE -->
    <form id="frmUsuario" method="post" action="" class="clsUIFicha">
        <fieldset>
            <div id="divFrmHead">DATOS USUARIO</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>N&deg;&nbsp;REF:</label></dt>
                    <dd><label><?php echo $oUsuario->getIdUsuario(); ?></label></dd>
                    <dt><label>LOGIN:</label></dt>
                    <dd><label><?php echo $oUsuario->getLogin(); ?></label></dd>
                    <dt><label>EMAIL:</label></dt>
                    <dd><label><?php echo $oUsuario->getEmail(); ?></label></dd>
                    <dt><label>NOMBRES:</label></dt>
                    <dd><label><?php echo $oUsuario->getNombres(); ?></label></dd>
                    <dt><label>APELLIDOS:</label></dt>
                    <dd><label><?php echo $oUsuario->getApellidos(); ?></label></dd>
                    <dt><label>TELEFONOS:</label></dt>
                    <dd><label><?php echo $oUsuario->getTelefonos(); ?></label></dd>
                    <dt><label>PAIS:</label></dt>
                    <dd><label><?php echo $oUsuario->getPais(); ?></label></dd>
                    <dt><label>REGION:</label></dt>
                    <dd><label><?php echo $oUsuario->getRegion(); ?></label></dd>
                    <dt><label>COD.&nbsp;POSTAL:</label></dt>
                    <dd><label><?php echo $oUsuario->getCodigoPostal(); ?></label></dd>
                    <dt><label>SEXO:</label></dt>
                    <dd><label><?php echo $oUsuario->getSexo(); ?></label></dd>
                    <dt><label>F.&nbsp;NACIMIENTO:</label></dt>
                    <dd><label><?php echo $oUsuario->getFechaNacimiento(); ?></label></dd>
                </dl>
                <div class="clsDivFix"></div>
            </div>
            <div id="divFrmFoot">
            <input type="hidden" id="hidAccion" name="hidAccion" />
            <input type="button" id="botModificar" name="botModificar" value="Modificar" onclick="pUIFicha(this);"/>
            <input type="button" id="botEliminar" name="botEliminar" value="Eliminar" onclick="pUIFicha(this);" />
            <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIFicha(this);" />
            </div>
        </fieldset>

    </form>
    </center>
</body>
</html>
