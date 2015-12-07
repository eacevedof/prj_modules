<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    ///Applications/XAMPP/xamppfiles/htdocs/proyMODULOS
    //http://localhost/Applications/XAMPP/xamppfiles/htdocs/proyMODULOS/index.php
    //AQUI se supone q el usuario ya se ha validado en el sistema por lo tanto
    //se le ha guardado en nuestra variable global de oUsuSesion eso lo emulare
    session_start();
    $_SESSION['sWarning']=""; //para manejar mensajes entre paginas
    header('Location: modAcceso/Frontend/UIAcceso.php');
    exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>INDEX</title>
</head>
<body onload="">
    <div id="divMensaje">PAGINA DE TRANSISION</div>
</body>
</html>
