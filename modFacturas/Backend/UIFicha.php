<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CDetalleFactura.php';
    //require $_RUTARAIZ.'modPDF/Clases/fpdf.php';
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

        //La factura, el Cliente y sus Detalles
        $oFactura = $_SESSION['oFactura'];
        $oFactura->pAtributosDesdeIDN($oBD);
        $oCliente=new CCliente($oFactura->getIdCliente(), null, null, null, null, null, null, null, null, null, null, null, null);
        $oCliente->pAtributosDesdeIDN($oBD);

        $arDetalles=CDetalleFactura::fArTabla($oFactura->getIdFactura(), $oBD);
    
        $sWarning=$_SESSION['sWarning'];
    }
    //$oFactura = new CFactura(null, null, null, null, null, null, null, null);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIFicha.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../AJAX/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsFacturas.js"></script>
    <title>FACTURA N&deg;: <?php echo $oFactura->getIdFactura(); ?></title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO GENERAL -->
    <form id="frmFactura" method="post" action="" class="clsUIFicha">
        <fieldset>
            <div id="divFrmHead">FACTURA</div>
            <div id="divFrmBody">
                <dl>
                    <dt></dt>
                    <dd><label>FECHA:</label><label><?php echo $oFactura->getFecha(); ?></label></dd>
                    <dt></dt>
                    <dd><label>N&deg;:</label><label><?php echo $oFactura->getIdFactura(); ?></label>
                        <input type="hidden" id="hidNumref" name="hidNumref" 
                               value="<?php echo $oFactura->getIdFactura(); ?>" /></dd>

                    <dt><label></label></dt>
                    <dd><label><b><?php echo $oCliente->getEmpresa(); ?></b></label></dd>
                    <dt><label></label></dt>
                    <dd><label><?php echo $oCliente->getCifnif(); ?></label></dd>
                    <dt><label></label></dt>
                    <dd><label><?php echo $oCliente->getDireccion(); ?></label></dd>
                    <dt><label></label></dt>
                    <dd><label><?php echo $oCliente->getCodigoPostal(); ?></label>-<label><?php echo $oCliente->getCiudad(); ?></label></dd>
                </dl>
                <div class="clsDivFix"></div>
                <table>
                    <thead>
                        <tr>
                            <th style="width:5%;">Item</th>
                            <th>DESCRIPCI&Oacute;N</th>
                            <th  style="width:15%;">CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i=0; $i < count($arDetalles); $i++)
                        {
                            if(($i%2)==0)
                            {
                                $sEstilo="clsPar";
                            }
                            else
                            {
                                $sEstilo="clsImpar";
                            }
                         ?>
                        <tr class="<?php echo $sEstilo ?>" >
                            <td><?php echo $i; ?></td>
                            <td><?php echo $arDetalles[$i]["CONCEPTO"]; ?></td>
                            <td style="text-align:right;"><?php echo $arDetalles[$i]["CANTIDAD"]; ?>&nbsp;&euro;</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>SUBTOTAL</td>
                            <td><?php echo $oFactura->getSubtotal(); ?>&nbsp;&euro;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>IVA</td>
                            <td><?php echo $oFactura->getIva(); ?>&nbsp;&euro;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><?php echo $oFactura->getTotal(); ?>&nbsp;&euro;</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <dl class="clsAuto">
                <dt><label>NOTAS:</label></dt>
                <dd><div><?php echo CUtils::fFicha($oFactura->getNotas()); ?></div></dd>
                <dt><label>ESTADO:</label></dt>
                <dd><div><?php echo $oFactura->getEstado(); ?></div></dd>
            </dl>
            <div id="divFrmFoot">
                <input type="hidden" id="hidAccion" name="hidAccion" />
                <input type="button" id="botModificar" name="botModificar" value="Modificar" onclick="pUIFicha(this);"/>
                <input type="button" id="botEliminar" name="botEliminar" value="Eliminar" onclick="pUIFicha(this);" />
                <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIFicha(this);" />
                <input type="button" id="botPDF" name="botPDF" value="PDF" onclick="pUIFicha(this);" />
            </div>
        </fieldset>
    </form>
    </center>
</body>
</html>
