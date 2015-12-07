<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CValida.php';
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
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        
        if (isset($_SESSION['arIDS']))  //se envia desde UILista, chkID[]
        {
            $arIDS=$_SESSION['arIDS'];
            $arOCliente=Array();
            for ($i=0; $i<count($arIDS); $i++)
            {

                $oCTmp=new CCliente($arIDS[$i], null, null, null, null, null, null,
                                        null, null, null, null, null, null);
                $oCTmp->pAtributosDesdeIDN($oBD);
                array_push($arOCliente, $oCTmp);
            }
        }
        else if(isset($_SESSION['oCliente'])) //hidID se envia desde UIFicha
        {
            $oCliente=$_SESSION['oCliente'];
            $oCliente->pAtributosDesdeIDN($oBD);
        }
        $sWarning=$_SESSION['sWarning'];
    }
    /*$oCliente=new CCliente(null, null, null, null, null, null, null,
                null, null, null, null, null, null);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIEliminar.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../AJAX/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsClientes.js"></script>
    <title>CLIENTES - ELIMINAR</title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO GENERAL -->
    <form id="frmCliente" method="post" action="" class="clsUIEliminar">
        <div id="divFrmHead">CONFIRMAR ELIMINACION</div>
        <div id="divFrmBody">
            <table>
                <thead>
                    <tr>
                        <th>N&deg;&nbsp;CLIENTE</th>
                        <th>EMPRESA</th>
                        <th>CONTACTO</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($arOCliente))
                      { ?>
                    <?php
                    for($i=0; $i < count($arOCliente); $i++)
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
                        <td><?php echo $arOCliente[$i]->getIdCliente(); ?></td>
                        <td><?php echo $arOCliente[$i]->getEmpresa(); ?></td>
                        <td><?php echo $arOCliente[$i]->getPersonaContacto(); ?></td>
                    </tr>
                    <?php } ?>
                <?php }
                      else if(isset($oCliente))
                      {
                ?>
                    <tr>
                        <td><?php echo $oCliente->getIdCliente(); ?></td>
                        <td><?php echo $oCliente->getEmpresa(); ?></td>
                        <td><?php echo $oCliente->getPersonaContacto(); ?></td>
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
