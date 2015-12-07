<?php
    session_start();
    //Cerramos la sesion destruyendo las variables
    unset($_SESSION['oUsuSesion']);
    unset($_SESSION['oFactura']);
    unset($_SESSION['arDetalles']);
    unset($_SESSION['arElim']);
    unset($_SESSION['sWarning']);

    //Me voy al index
    header('Location: ../../index.php');
?>