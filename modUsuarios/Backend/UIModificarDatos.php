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
        $sWarning=$_SESSION['sWarning'];
        $oUsuDatosUI = new CUsuario(null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null);
        $oUsuDatosUI=$_SESSION['oUsuDatosR'];
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
    <div id="divMensaje"><?php echo $sWarning ?></div>
    
    <!-- EL FORMULARO PARA LOGIN -->
    <form id="frmModificarDatos" method="POST" action="../Pasadores/PSModificarDatosW.php"
          onsubmit="">
        <fieldset>
            <dl>

                <dt>NOMBRES:</dt>
                <dd><input type="text" id="txtNombres" name="txtNombres" 
                           value="<?php echo $oUsuDatosUI->getNombres(); ?>" /></dd>

                <dt>APELLIDOS:</dt>
                <dd><input type="text" id="txtApellidos" name="txtApellidos"
                           value="<?php echo $oUsuDatosUI->getApellidos(); ?>" /></dd>

                <dt>TELEFONOS:</dt>
                <dd><input type="text" id="txtTelefonos" name="txtTelefonos"
                           value="<?php echo $oUsuDatosUI->getTelefonos(); ?>" /></dd>

                <dt>EMAIL:</dt>
                <dd><input type="text" id="txtEmail" name="txtEmail"
                           value="<?php echo $oUsuDatosUI->getEmail(); ?>" /></dd>

                <dt>PAIS:</dt>
                <dd>
                    <select id="selPais" name="selPais" >
                        <option value="España">Espa&ntilde;a</option>
                        <option value="Francia">Francia</option>
                    </select>
                </dd>

                <dt>REGION:</dt>
                <dd>
                    <select id="selRegion" name="selRegion" >
                        <option value="Madrid">Madrid</option>
                        <option value="Paris">Paris</option>
                        <option value="Londres">Londres</option>
                    </select>
                </dd>
                
                <dt>CODIGO POSTAL:</dt>
                <dd><input type="text" id="txtCodpos" name="txtCodpos"
                          value="<?php echo $oUsuDatosUI->getCodigoPostal(); ?>" /></dd>

                <dt>SEXO:</dt>
                <dd>
                    <input type="radio" id="radSexo" name="radSexo" value="M" />Mujer
                    <input type="radio" id="radSexo" name="radSexo" value="H" checked />Hombre
                </dd>

                <dt>FECHA DE NACIMIENTO:</dt>
                <dd>
                    <input type="text" id="txtFecnac" name="txtFecnac"
                           value="<?php echo $oUsuDatosUI->getFechaNacimiento(); ?>" />
                </dd>
                
            </dl>

            <input type="submit" id="subUsuario" name="subUsuario" value="Guardar" />
            <input type="button" id="botCancelar" name="botCancelar" value="Cancelar" onclick="" />
        </fieldset>
    </form>

</body>
</html>
