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
        $arTabla=CUsuario::fArTabla($oBD);
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
    <link type="text/css" rel="stylesheet" href="../CSS/cssUILista.css" media="screen" />
    
    <script type="text/javascript" src="../../CSS_JS/jsUtils.js"></script>
    <script type="text/javascript" src="../Ajax/jsAjax.js"></script>
    <script type="text/javascript" src="../JS/jsUsuarios.js"></script>
    
    <title>USUARIOS - LISTA</title>
</head>
<body onload="">
    <center>
    <?php include($_RUTARAIZ."Includes/Cabecera.php");?>
    <div id="divMensaje"><?php echo $sWarning ?></div>
    <!-- FORMULARO CON LA TABLA -->
    <form id="frmLista" method="post" action="" class="clsUILista">
        <div id="divFrmHead">USUARIOS</div>
        <?php include($_RUTARAIZ."Includes/UIListaBotonesCab.php");?>
        <div id="divFrmBody">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="chkTodo" name="chkTodo"
                               onclick="pSelecAll(this,'frmLista');" />
                    </th>
                    <th>N&ordm;&nbsp;</th>
                    <th>NICK</th>
                    <th>EMAIL</th>
                    <th>NOMBRES</th>
                    <th>APELLIDOS</th>
                    <th>CATEGORIA</th>
                    <th>ESTADO</th>
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
                    <td><?php echo $arTabla[$i]["LOGIN"] ?></td>
                    <td><?php echo $arTabla[$i]["EMAIL"] ?></td>
                    <td><?php echo $arTabla[$i]["NOMBRES"] ?></td>
                    <td><?php echo $arTabla[$i]["APELLIDOS"] ?></td>
                    <td><?php echo $arTabla[$i]["CATEGORIA"] ?></td>
                    <td><?php echo $arTabla[$i]["ESTADO"] ?></td>
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
