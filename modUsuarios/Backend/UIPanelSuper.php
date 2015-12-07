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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="CSS_JS/cssPHP.css" />
    <link rel="stylesheet" type="text/css" href="CSS_JS/cssFormularios.css" media="screen" />
    <script type="text/javascript" src="CSS_JS/jsUtils.js"></script>
    <title> Panel Super Admin</title>
</head>
<body onload="pEnfoca('txtLogin');">
    <center>
    <div id="divTotal">

        <div id="divCabecera">
            <div>
                <img src="../Images/intraCab.png" width="748" height="171" alt="proTop"/>
            </div>
        </div>
        <!--FIN header-->

        <div id="divContenido">
            <div id="divPanel" class="clsPanel">
                <div id="divTitulo">PANEL DE CONTROL</div>
                <div id="divUsuario">
                    <div>USUARIOS</div>
                    <ul>
                        <li><a href="UsuarioNuevo.php">Nuevo</a></li>
                        <li><a href="UsuarioListaR.php" title="Modificar / Eliminar">Lista</a></li>
                    </ul>
                </div>
                <div id="divNoticia">
                    <div>NOTICIAS</div>
                    <ul>
                        <li><a href="NoticiaNueva.php">Nueva</a></li>
                        <li><a href="NoticiaListaR.php" title="Modificar / Eliminar">Lista</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="divPie">
            <div>salir</div>
        </div>
    </div>
    </center>
</body>
</html>
