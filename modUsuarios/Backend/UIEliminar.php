<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CValida.php';
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
            $arOUsuario=Array();
            for ($i=0; $i<count($arIDS); $i++)
            {
                $oUTmp=new CUsuario($arIDS[$i], null, null, null, null, null, null,
                 null, null, null, null, null, null, null, null, null, null);
                $oUTmp->pAtributosDesdeIDN($oBD);
                array_push($arOUsuario, $oUTmp);
            }
        }
        else if(isset($_SESSION['oUsuario'])) //hidID se envia desde UIFicha
        {
            $oUsuario=$_SESSION['oUsuario'];
            $oUsuario->pAtributosDesdeIDN($oBD);
        }
        $sWarning=$_SESSION['sWarning'];
    }
    /* $oUsuario=new CUsuario(null, null, null, null, null, null, null,
                 null, null, null, null, null, null, null, null, null, null);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIEliminar.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../Ajax/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsUsuarios.js"></script>
    <title>ELIMINAR USUARIO /S</title>
</head>
<body onload="">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    <!-- EL FORMULARO ELIMINAR -->
    <form id="frmUsuario" method="post" action="" class="clsUIEliminar">
        <div id="divFrmHead">CONFIRMAR ELIMINACION</div>
        <div id="divFrmBody">
            <table style="border:1px solid black; width:100%;">
                <thead>
                    <tr>
                        <th>N&deg;&nbsp;USUARIO</th>
                        <th>LOGIN</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($arOUsuario))
                      { ?>
                    <?php
                    for($i=0; $i < count($arOUsuario); $i++)
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
                        <td><?php echo $arOUsuario[$i]->getIdUsuario(); ?></td>
                        <td><?php echo $arOUsuario[$i]->getLogin(); ?></td>
                        <td><?php echo $arOUsuario[$i]->getNombres(); ?></td>
                        <td><?php echo $arOUsuario[$i]->getApellidos(); ?></td>
                    </tr>
                    <?php } ?>
                <?php }
                      else if(isset($oUsuario))
                      {
                ?>
                    <tr>
                        <td><?php echo $oUsuario->getIdUsuario(); ?></td>
                        <td><?php echo $oUsuario->getLogin(); ?></td>
                        <td><?php echo $oUsuario->getNombres(); ?></td>
                        <td><?php echo $oUsuario->getApellidos(); ?></td>
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
