<?php
    session_start();
    $sWarning=$_SESSION['sWarning'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUIAcceso.css" media="screen" />
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../JS/jsAcceso.js"></script>
    <title> ACCESO </title>
</head>
<body onload="pEntrada();">
    <center>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <form id="frmAcceso" method="post" action="" class="clsUIAcceso">
        <fieldset>
            <div id="divFrmHead">AREA RESTRINGIDA</div>
            <div id="divFrmBody">
                <dl>
                    <dt><label>USUARIO:</label></dt>
                    <dd><input type="text" id="txtLog" name="txtLog" /></dd>
                    <dt><label>CLAVE:</label></dt>
                    <dd><input type="password" id="pasClave" name="pasClave" /></dd>
                    <dt><label>NOBOTS:</label></dt>
                    <dd><input type="text" id="txtVeri" name="txtVeri" /></dd>
                </dl>
                <div class="clsDivFix"></div>
            </div>
            <div id="divFrmFoot">
                <input type="hidden" id="hidAccion" name="hidAccion"/> 
                <input type="submit" id="subAceptar" name="subAceptar" value="Aceptar" class="" onclick="pUIAcceso(this);" />
            </div>
        </fieldset>
    </form>
    </center>
</body>
</html>
