<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';
    require_once $_RUTARAIZ.'modFacturas/Clases/class.CDetalleFactura.php';
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

        if(isset($_SESSION['oFactura']))
        {
            $oFactura=$_SESSION['oFactura'];
        }
        else
        {
            $oFactura=new CFactura(null, '2010-01-01', 0, 0, 0, 'PENDIENTE', '-', 0);
            $_SESSION['oFactura']=$oFactura;
        }

        if(isset($_SESSION['arDetalles'])) //la segunda vez y sucesivas
        {
            $arDetalles=$_SESSION['arDetalles'];
        }
        else //la primera vez
        {
            $arDetalles=Array();
            $_SESSION['arDetalles']=$arDetalles;
        }
        $sWarning=$_SESSION['sWarning'];
    }
        //$oFactura=new CFactura(null, null, null, null, null, null, null, null);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIAgregar.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../AJAX/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsFacturas.js"></script>
    <script type="text/javascript" src="../JS/jsFormDinamico.js"></script>
    <title>FACTURAS - NUEVA</title>
</head>
<body onload="pSeleccionaValorIndice('<?php echo $oFactura->getIdCliente(); ?>','selCliente');">
    <center>
    <!-- EL FORMULARO PARA CREAR -->
    <div id="divMensaje"><?php echo $sWarning ?></div>

    <form id="frmFactura" method="post" action="" class="clsUIAgregar">
        <fieldset>
            <div id="divFrmHead">NUEVA FACTURA</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>FECHA:</label></dt>
                    <dd><input type="text" id="txtFecha" name="txtFecha" value="<?php echo $oFactura->getFecha(); ?>" /></dd>
                    <dt><label>CLIENTE:</label></dt>
                    <dd>
                        <select id="selCliente" name="selCliente">
                            <?php
                                for($i=0; $i < count($arListaClientes); $i++)
                                {
                            ?>
                            <option value="<?php echo $arListaClientes[$i]['IDN'] ?>" >
                            <?php echo $arListaClientes[$i]["EMPRESA"] ?>
                            </option>
                            <?php } ?>
                        </select>
                    </dd>
                </dl>
                <div class="clsDivFix"></div>
                <table id="tblDetalles">
                    <thead>
                        <tr>
                            <th>Item.</th><th>CONCEPTO</th><th>CANTIDAD</th><th></th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=0; $i < count($arDetalles); $i++)
                            {
                        ?>
                        <tr id="tr<?php echo $i; ?>" class="<?php echo ok; ?>">
                            <td>
                                <label><?php echo $i; ?></label>
                            </td>
                            <td>
                                <label><?php echo $arDetalles[$i]['Concepto']; ?></label>
                            </td>
                            <td style="text-align:right;">
                                <label><?php printf("%01.2f",$arDetalles[$i]['Cantidad']); ?></label>&nbsp;&euro;
                            </td>
                            <td>
                                <input type="button" id="botMod<?php echo $i; ?>" name="botMod<?php echo $i; ?>" value="Modificar" onclick="pFormAgregarDet(this);" />
                            </td>
                            <td>
                                <input type="button" id="botEli<?php echo $i; ?>" name="botEli<?php echo $i; ?>" value="Eliminar" onclick="pUIAgregarDetalles(this);" />
                            </td>
                        </tr>
                        <?php } ?>
                        <tr id="tr<?php echo $i; ?>" class="<?php echo $i; ?>">
                            <td><?php echo $i; ?></td>
                            <td>
                                <input type="text" id="txtConcep<?php echo $i; ?>" name="txtConcep<?php echo $i; ?>" value="" class="clsConcepto"/>
                            </td>
                            <td style="text-align:right;">
                                <input type="text" id="txtCant<?php echo $i; ?>" name="txtCant<?php echo $i; ?>" value="" class="clsCantidad" />&nbsp;&euro;
                            </td>
                            <td>
                                <input type="button" id="botAgr<?php echo $i; ?>" name="botAgr<?php echo $i; ?>" value="Agregar" onclick="pUIAgregarDetalles(this);" />
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="">
                            <td></td>
                            <td>SUBTOTAL:</td>
                            <td>
                                <?php printf("%01.2f", $oFactura->getSubtotal()); ?>&nbsp;&euro;
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td>IVA:</td>
                            <td>
                                <?php printf("%01.2f",$oFactura->getIva()); ?>&nbsp;&euro;
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td>TOTAL:</td>
                            <td>
                                <?php printf("%01.2f",$oFactura->getTotal()); ?>&nbsp;&euro;
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <dl class="clsAuto">
                <dt><label>NOTAS:</label></dt>
                <dd>
                    <textarea id="txaNotas" name="txaNotas" rows="" cols=""><?php echo $oFactura->getNotas(); ?></textarea>
                </dd>
            </dl>
            <div id="divFrmFoot">
                <input type="hidden" id="hidFila" name="hidFila"/>
                <input type="hidden" id="hidAccion" name="hidAccion"/>
                <input type="button" id="botGuardar" name="botGuardar" value="Guardar" onclick="pUIAgregar(this);" />
                <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIAgregar(this);" />
            </div>
        </fieldset>

    </form>
    </center>
</body>
</html>
