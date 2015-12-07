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
        $oCliente = $_SESSION['oCliente'];
        $oCliente->pAtributosDesdeIDN($oBD);

        $sWarning=$_SESSION['sWarning'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIFicha.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsAjax.js"></script>
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../JS/jsClientes.js"></script>
    <title>CLIENTE: <?php echo $oCliente->getEmpresa(); ?></title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO DETALLE -->
    <form id="frmCliente" method="post" action="" class="clsUIFicha">
        <fieldset>
            <div id="divFrmHead">DATOS CLIENTE</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>N&deg;&nbsp;REF:</label></dt>
                    <dd><label><?php echo $oCliente->getIdCliente(); ?></label>
                        <input type="hidden" id="hidNumref" name="hidNumref" 
                               value="<?php echo $oCliente->getIdCliente(); ?>" /></dd>
                    <dt><label>CIFNIF:</label></dt>
                    <dd><label><?php echo $oCliente->getCifnif(); ?></label></dd>
                    <dt><label>EMPRESA:</label></dt>
                    <dd><label><?php echo $oCliente->getEmpresa(); ?></label></dd>
                    <dt><label>COD.&nbsp;POSTAL:</label></dt>
                    <dd><label><?php echo $oCliente->getCodigoPostal(); ?></label></dd>
                    <dt><label>CIUDAD:</label></dt>
                    <dd><label><?php echo $oCliente->getCiudad(); ?></label></dd>
                    <dt><label>DIRECCION:</label></dt>
                    <dd><label><?php echo $oCliente->getDireccion(); ?></label></dd>
                    <dt><label>TELEFONO(S):</label></dt>
                    <dd><label><?php echo $oCliente->getTelefonos(); ?></label></dd>
                    <dt><label>MOVIL/ES:</label></dt>
                    <dd><label><?php echo $oCliente->getMoviles(); ?></label></dd>
                    <dt><label>P.&nbsp;CONTACTO:</label></dt>
                    <dd><label><?php echo $oCliente->getPersonaContacto(); ?></label></dd>
                    <dt><label>EMAIL:</label></dt>
                    <dd><label><?php echo $oCliente->getEmail(); ?></label></dd>
                    <dt><label>C.&nbsp;BANCARIA:</label></dt>
                    <dd><label><?php echo $oCliente->getCuentaBancaria(); ?></label></dd>
                </dl>
                <div class="clsDivFix"></div>
            </div>
            <dl class="clsAuto">
                <dt><label>DOMINIOS:</label></dt>
                <dd><div><?php echo CUtils::fFicha($oCliente->getDominios()); ?></div></dd>
                <dt><label>NOTAS:</label></dt>
                <dd><div><?php echo CUtils::fFicha($oCliente->getNotas()); ?></div></dd>
            </dl>
            <div id="divFrmFoot">
                <input type="hidden" id="hidAccion" name="hidAccion" />
                <input type="button" id="botModificar" name="botModificar" value="Modificar" onclick="pUIFicha(this);"/>
                <input type="button" id="botEliminar" name="botEliminar" value="Eliminar" onclick="pUIFicha(this);" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIFicha(this);" />
            </div>
        </fieldset>

    </form>
</center>
</body>
</html>
