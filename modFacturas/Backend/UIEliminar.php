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
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        
        if (isset($_SESSION['arIDS']))  //se envia desde UILista, chkID[]
        {
            $arIDS=$_SESSION['arIDS'];
            $arOFactura=Array();
            for ($i=0; $i<count($arIDS); $i++)
            {
                $oFTmp=new CFactura($arIDS[$i], null, null, null, null, null, null, null);
                $oFTmp->pAtributosDesdeIDN($oBD);
                array_push($arOFactura, $oFTmp);
            }
        }
        else if(isset($_SESSION['oFactura'])) //hidID se envia desde UIFicha
        {
            $oFactura=$_SESSION['oFactura'];
            $oFactura->pAtributosDesdeIDN($oBD);
        }
        $sWarning=$_SESSION['sWarning'];
    }
    //$oFactura = new CFactura(null, null, null, null, null, null, null, null);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIEliminar.css" media="screen" />
    
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../AJAX/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsFacturas.js"></script>
    <title>ELIMINAR FACTURA /S</title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO ELIMINAR -->
    <form id="frmFactura" method="post" action="" class="clsUIEliminar">
        <div id="divFrmHead">CONFIRMAR ELIMINACION</div>
        <div id="divFrmBody">
            <table style="border:1px solid black; width:100%;">
                <thead>
                    <tr>
                        <th>N&ordf; FACTURA</th>
                        <th>CLIENTE</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($arOFactura))
                      { ?>
                    <?php
                    for($i=0; $i < count($arOFactura); $i++)
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
                        <td><?php echo $arOFactura[$i]->getIdFactura(); ?></td>
                        <td><?php $oCliente=new CCliente($arOFactura[$i]->getIdCliente(), null, null, null, null, null, null, null, null, null, null, null, null); $oCliente->pAtributosDesdeIDN($oBD); echo $oCliente->getEmpresa(); ?></td>
                        <td style="text-align:right;"><?php echo $arOFactura[$i]->getTotal(); ?>&nbsp;&euro;</td>
                    </tr>
                    <?php } ?>
                <?php }
                      else if(isset($oFactura))
                      {
                ?>
                    <tr>
                        <td><?php echo $oFactura->getIdFactura(); ?></td>
                        <td><?php $oCliente=new CCliente($oFactura->getIdCliente(), null, null, null, null, null, null, null, null, null, null, null, null); $oCliente->pAtributosDesdeIDN($oBD); echo $oCliente->getEmpresa(); ?></td>
                        <td><?php echo $oFactura->getTotal(); ?>&nbsp;&euro;</td>
                    </tr>
                 <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="divFrmFoot">
            <input type="hidden" id="hidAccion" name="hidAccion" />
            <input type="button" id="botEliminar" name="botEliminar" value="Eliminar" onclick="pUIEliminar(this);" />
            <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="pUIEliminar(this);" />
        </div>
    </form>
    </center>
</body>
</html>
