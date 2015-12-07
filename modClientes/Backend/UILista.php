<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
    require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
    require_once $_RUTARAIZ.'modUsuarios/Clases/class.CUsuario.php';
    require_once $_RUTARAIZ.'modUtilidades/Clases/class.CUtils.php';
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
        //Conecto con la base de datos
        $oBD = new CBaseDatos();
        $bEstado=$oBD->fBoolConectar();
        $arTabla=CCliente::fArTabla($oBD);
        $sWarning=$_SESSION['sWarning'];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link type="text/css" rel="stylesheet" href="../../CSS_JS/cssGeneral.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="../CSS/cssUILista.css" media="screen" />

    <script type="text/javascript" src="../../CSS_JS/jsAjax.js"></script>
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../JS/jsClientes.js"></script>
    
    <title>CLIENTES - LISTA</title>
</head>
<body onload="">
    <center>
    <?php include($_RUTARAIZ."Includes/Cabecera.php");?>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    <!-- FORMULARO CON LA TABLA -->
    <form id="frmLista" method="post" action="" class="clsUILista">
        <div id="divFrmHead">CLIENTES</div>
        <?php include($_RUTARAIZ."Includes/UIListaBotonesCab.php");?>
        <div id="divFrmBody">
            <table>
                <!--ENCABEADO-->
                <thead>
                    <tr>
                        <th><input type="checkbox" id="chkTodo" name="chkTodo"
                                   onclick="pSelecAll(this,'frmLista');" />
                        </th>
                        <th>N&deg;&nbsp;</th>
                        <th>EMPRESA</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DIRECCION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>P.&nbsp;CONTACTO</th>
                        <th>TELEFONO</th>
                        <th>EMAIL</th>
                        <th>FICHA</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <!-- FIN ENCABEZADO-->
                <!--INICIO FILA QUE SE ITERA-->
                <tbody>
                <?php
                    $sEstilo="";
                    //http://foro.undersecurity.net/read.php?11,674  recorrer un array
                    //foreach ($arTabla as $i => $valor)
                    for($i=0; $i < count($arTabla); $i++)
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
                        <td><input type="checkbox" id="chkID[]" name="chkID[]" value="<?php echo $arTabla[$i]['IDN'] ?>" /></td>
                        <td><?php echo $arTabla[$i]["IDN"] ?></td>
                        <td><?php echo $arTabla[$i]["EMPRESA"] ?></td>
                        <td><?php echo $arTabla[$i]["DIRECCION"] ?></td>
                        <td><?php echo $arTabla[$i]["PERCONT"] ?></td>
                        <td><?php echo $arTabla[$i]["TELEFONO"] ?></td>
                        <td><?php echo $arTabla[$i]["EMAIL"] ?></td>
                        <td><input type="button" id="botDet<?php echo $arTabla[$i]['IDN'] ?>" name="botDet<?php echo $arTabla[$i]['IDN'] ?>"
                                   value="Ficha" onclick="pUILista(this);"/>
                        </td>
                        <td>
                            <input type="button" id="botMod<?php echo $arTabla[$i]['IDN'] ?>" name="botMod<?php echo $arTabla[$i]['IDN'] ?>"
                                   value="Modificar" onclick="pUILista(this);"/>
                        </td>
                    </tr>
                <?php } ?>
                <!--FIN FILA QUE SE ITERA-->
                </tbody>

            </table>
        </div>
        <?php include($_RUTARAIZ."Includes/UIListaBotonesPie.php");?>
    </form>
    </center>
</body>
</html>
