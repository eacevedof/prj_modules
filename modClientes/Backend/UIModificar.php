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
        //Los clientes para el select
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        $arListaClientes=CCliente::fArTabla($oBD);

        if(isset($_SESSION['oCliente']))
        {
            $oCliente=$_SESSION['oCliente'];
        }
        else
        {
           header('Location: ../../index.php');
           exit;
        }
        $sWarning=$_SESSION['sWarning'];
    }
    /*$oCliente = new CCliente(null, null, null, null, null, null, null,
                null, null, null, null, null, null);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIModificar.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsAjax.js"></script>
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../JS/jsClientes.js"></script>
    
    <title>CLIENTES - MODIFICAR</title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning; ?></div>
    
    <!-- EL FORMULARO MODIFICAR CLIENTE -->
    <form id="frmCliente" method="post" action="" class="clsUIModificar">
        <fieldset>
            <div id="divFrmHead">MODIFICAR DATOS CLIENTE</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>N&deg;&nbsp;REF:</label></dt>
                    <dd><label><?php echo $oCliente->getIdCliente(); ?></label>
                        <input type="hidden" id="hidNumref" name="hidNumref" 
                               value="<?php echo $oCliente->getIdCliente(); ?>" /></dd>
                    <dt><label>CIFNIF:</label></dt>
                    <dd><input type="text" id="txtCifnif" name="txtCifnif" 
                               value="<?php echo $oCliente->getCifnif(); ?>" /></dd>
                    <dt><label>EMPRESA:</label></dt>
                    <dd><input type="text" id="txtEmpresa" name="txtEmpresa"
                               value="<?php echo $oCliente->getEmpresa(); ?>" /></dd>
                    <dt><label>COD. POSTAL:</label></dt>
                    <dd><input type="text" id="txtCodpos" name="txtCodpos"
                               value="<?php echo $oCliente->getCodigoPostal(); ?>" /></dd>
                    <dt><label>CIUDAD:</label></dt>
                    <dd><input type="text" id="txtCiudad" name="txtCiudad"
                               value="<?php echo $oCliente->getCiudad(); ?>" /></dd>
                    <dt><label>DIRECCION:</label></dt>
                    <dd><input type="text" id="txtDirecc" name="txtDirecc"
                               value="<?php echo $oCliente->getDireccion(); ?>" /></dd>
                    <dt><label>TELEFONO/S:</label></dt>
                    <dd><input type="text" id="txtTelefo" name="txtTelefo"
                               value="<?php echo $oCliente->getTelefonos(); ?>" /></dd>
                    <dt><label>MOVIL/ES:</label></dt>
                    <dd><input type="text" id="txtMovil" name="txtMovil"
                               value="<?php echo $oCliente->getMoviles(); ?>" /></dd>
                    <dt><label>P.&nbsp;CONTACTO:</label></dt>
                    <dd><input type="text" id="txtPersona" name="txtPersona"
                               value="<?php echo $oCliente->getPersonaContacto(); ?>" /></dd>
                    <dt><label>EMAIL:</label></dt>
                    <dd><input type="text" id="txtEmail" name="txtEmail"
                               value="<?php echo $oCliente->getEmail(); ?>" /></dd>
                    <dt><label>C.&nbsp;BANCARIA:</label></dt>
                    <dd><input type="text" id="txtCuentaB" name="txtCuentaB"
                               value="<?php echo $oCliente->getCuentaBancaria(); ?>" /></dd>
                </dl>
                <div class="clsDivFix"></div>
            </div>
            <dl class="clsAuto">
                <dt><label>DOMINIOS:</label></dt>
                <dd>
                    <textarea id="txaDominios" name="txaDominios" rows="" cols=""><?php echo $oCliente->getDominios();?></textarea>
                </dd>
                <dt><label>NOTAS:</label></dt>
                <dd>
                    <textarea id="txaNotas" name="txaNotas" rows="" cols=""><?php echo $oCliente->getNotas(); ?></textarea>
                </dd>
            </dl>
            <div id="divFrmFoot">
                <input type="hidden" id="hidAccion" name="hidAccion"/>
                <input type="button" id="botGuardar" name="botGuardar" value="Guardar" onclick="pUIModificar(this);" />
                <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIModificar(this);" />
            </div>
        </fieldset>

    </form>
    </center>
</body>
</html>
