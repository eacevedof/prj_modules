<?php

class CValida
{
    public static function fBoolEmail(&$sEmail)
    {
        $sPatron="/(^[0-9a-zA-Z]+(?:[._][0-9a-zA-Z]+)*)@([0-9a-zA-Z]+(?:[._-][0-9a-zA-Z]+)*\.[0-9a-zA-Z]{2,3})$/";
        $sEmail=strtolower($sEmail);
        $sEmail=trim($sEmail);
        $bBien=false;

        if (preg_match($sPatron, $sEmail))
        {
            $bBien=true;
        }
        return $bBien;
    }
    public static function fBoolNombres(&$sNombre)
    {
        $sPatron="/^[a-züA-ZÜ]+[\s]?[a-züA-ZÜ]+$/";
        $sNombre=strtoupper($sNombre);
        $sNombre=trim($sNombre);
        $bBien=false;

        if (preg_match($sPatron, $sNombre))
        {
            $bBien=true;
        }
        return $bBien;
    }

    public static function fBoolTelefono(&$sTelefono)
    {
        $sPatron="/^[0-9\s\+\-]+$/";
        $sTelefono=strtoupper($sTelefono);
        $sTelefono=trim($sTelefono);
        $bBien=false;

        if (preg_match($sPatron, $sTelefono))
        {
            $bBien=true;
        }
        return $bBien;
    }

    public static function fBoolFecha(&$dFechaSinHora)
    {
        $sPatron="/^[0-9\s\+\-]+$/";
        $dFechaSinHora=strtoupper($dFechaSinHora);
        $dFechaSinHora=trim($dFechaSinHora);
        $bBien=false;

        if (preg_match($sPatron, $dFechaSinHora))
        {
            $bBien=true;
        }
        return $bBien;
    }
}

?>
