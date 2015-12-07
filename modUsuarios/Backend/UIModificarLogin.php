<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.ConstBD.php';
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
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
        $oUsuDatos = new CUsuario(null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null);
        $oUsuDatos=$_SESSION['oModLogin'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script type="text/javascript" src="CSS_JS/jsAjax.js"></script>
    <script type="text/javascript" src="CSS_JS/jsUtils.js"></script>
    
    <title>Formulario para todos Modificar Datos</title>
</head>
<body onload="">

    <!-- EL FORMULARO PARA LOGIN -->
    <div id="divMensaje"></div>
    
    <!-- EL FORMULARO PARA LOGIN -->
    <form id="frmModificarLogin" method="POST" action="../Pasadores/PSModificarLoginW.php"
          onsubmit="">
        <fieldset>
            <dl>

                <dt>LOGIN ACTUAL:</dt>
                <dd><input type="text" id="txtLoginA" name="txtLoginA"
                           value="<?php echo $oUsuDatos->getLogin(); ?>" readonly="readonly" /></dd>
                <dt>NUEVO LOGIN:</dt>
                <dd><input type="text" id="txtLoginN" name="txtLoginN" /></dd>

                <!--AJAX--><dt>___________________________________</dt>
                <dd><input type="button" id="botComprobar" name="botComprobar" value="Comprobar disponibilidad" onclick="" /></dd>

            </dl>
            <!--AJAX--><input type="hidden" id="hidValido" name="hidValido" value="N" />
            <input type="submit" id="subUsuario" name="subUsuario" value="Guardar" />
            <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="" />
        </fieldset>
    </form>

</body>
</html>
