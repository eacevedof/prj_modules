<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';?>
<?php
    session_start();
    $oUsuSesion=$_SESSION['oUsuSesion'];
    if($oUsuSesion==null||!$oUsuSesion->getSesion())
    {
       $_SESSION['sWarning']="Debe iniciar sesión.";
       header('Location: ../../index.php');
       exit;
    }
    $sWarning=$_SESSION['sWarning'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIPanel.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../AJAX/jsAjax.js"></script>
    <title>PANEL DE CONTROL</title>
</head>
<body onload="">
    <?php include($_RUTARAIZ."Includes/Cabecera.php");?>
    <div class="clsSeccion">PANEL DE CONTROL</div>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    <div  class="clsUIPanel">
    <table>
        <thead>
            <tr>
                <th>Clientes</th>
                <th>Facturas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <ul>
                        <li><a href="../../modClientes/Backend/UILista.php" target="_self">Listado</a></li>
                        <li><a href="../../modClientes/Backend/UIAgregar.php" target="_self">Nuevo</a></li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li><a href="../../modFacturas/Backend/UILista.php" target="_self">Listado</a></li>
                        <li><a href="../../modFacturas/Backend/UIAgregar.php" target="_self">Nueva</a></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <div  class="clsUIPanel">
    <table border="0">
        <thead>
            <tr>
                <th>Usuarios</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <ul>
                        <li><a href="../../modUsuarios/Backend/UILista.php" target="_self">Listado</a></li>
                        <li><a href="../../modUsuarios/Backend/UIAgregar.php" target="_self">Nuevo</a></li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
</body>
</html>
