<?php

//Clase interface
interface IAccionBaseDatos
{
    public function Agregar();
    public function Modificar();
    public function EliminarF();
    public function EliminarL();
    public function Buscar();
    public static function fBoolExiste($iIDN,CBaseDatos $oBD);
}
?>
