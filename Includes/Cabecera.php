<div class="clsCabecera">BURBAN</div>
    <div class="clsBarra">
        <ul>
            <li><a href="../../modClientes/Backend/UILista.php" target="_self">Clientes</a></li>
            <li><a href="../../modFacturas/Backend/UILista.php" target="_self">Facturas</a></li>
            <li><a href="../../modUsuarios/Backend/UILista.php" target="_self">Usuarios</a></li>
            <li><a href="../../modAcceso/Pasadores/PSSalir.php" target="_self">Salir X</a></li>
        </ul>
    </div>
    <div class="clsUsuario">
        <div>sesion:&nbsp;<?php echo $oUsuSesion->getLogin(); ?>&nbsp;<?php echo '&nbsp;&nbsp;'.$oUsuSesion->getCategoria(); ?>&nbsp;&nbsp;&nbsp;</div>
    </div>
