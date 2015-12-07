<?php

class CUtils
{
    /***
     *Comprueba la sesion
     */
    public static function fBoolSesion()
    {
        session_start();
        if( isset( $_SESSION['bAcceso'] ) )
        {
            if ($_SESSION['bAcceso']==false)
            {
               $_SESSION['sMensaje']="Su sesion ha expirado, vuelva a conectarse";
               return false;
            }
            else
            {
               return true;
            }
        }
        else
        {
            return false;
        }

    }

    public static function pTerminaSesion()
    {
        session_start();
        if( isset( $_SESSION['bAcceso'] ) )
        {
            if($_SESSION['bAcceso']==true)
            {
                $_SESSION['bAcceso']=false;
            }
        }
    }

    public static function fBoolNombre($sNombre)
    {
        $sArMatches="";
        $sFechaMYSQL="";

        $sPatronESP="/^[a-züA-ZÜ]+[\s]?[a-züA-ZÜ]+$/";

        if (preg_match($sPatronESP, $sNombre, $sArMatches))
        {
            $sFechaMYSQL=$sArMatches[3]."-".$sArMatches[2]."-".$sArMatches[1];
        }
        else
        {
            $sFechaMYSQL="00-00-0000";
        }
        return $sFechaMYSQL;
    }

    public static function fFechaMySql($sFechaESP)
    {
        $sArMatches="";//^[a-züA-ZÜ]+[\s]?[a-züA-ZÜ]+$
        $sFechaMYSQL="";

        $sPatronESP="/([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})/";

        if (preg_match($sPatronESP, $sFechaESP, $sArMatches))
        {
            $sFechaMYSQL=$sArMatches[3]."-".$sArMatches[2]."-".$sArMatches[1];
        }
        else
        {
            $sFechaMYSQL="00-00-0000";
        }
        return $sFechaMYSQL;
    }

    public static function fFechaESP($sFechaMYSQL)
    {
        $sFechaESP="";

        $sPatronMYSQL='/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/';

        if (preg_match($sPatronMYSQL, $sFechaMYSQL, $sArMatches))
        {
            $sFechaESP=$sArMatches[3]."-".$sArMatches[2]."-".$sArMatches[1];
        }
        else
        {
            $sFechaESP="00-00-0000";
        }

        return $sFechaESP;
    }
    //$sNotasTA = texto notas en textArea
    public static function fNotasBD($sNotasTA)
    {
        //pasa los caracteres en $sNotas " y ' a \" y \'
        //evitando conflicto con el SQL
        $sTextoParaBD=addslashes($sNotasTA);
        return $sTextoParaBD;
    }
    public static function fFicha($sNotasBD)
    {
        //cambia los caracteres de salto por <br\>
        $sTextoParaDiv=str_replace ("\r\n","<br />",$sNotasBD);
        return $sTextoParaDiv;
    }

    public static function fTextoBD($sTextoHTML)
    {
        //Todos los caracteres que tengan un equivalente en HTML se pasan
        //a texto "utf-8" texto plano. De <> a &lt;&bt;
        $sTextoParaBD=html_entity_decode($sTextoHTML, ENT_QUOTES, "utf-8");
        //Si hay quotes le añado los slashes
        $sTextoParaBD=addslashes($sTextoParaBD);
        return $sTextoParaBD;
    }
    public static function fTextoTxa($sTextoBD)
    {

        $sTextoParaBD=html_entity_decode($sTextoHTML, ENT_QUOTES, "utf-8");
        $sTextoParaBD=addslashes($sTextoParaBD);
        return $sTextoParaBD;
    }
    public static function fTextoAMP($sTextoMixto)
    {
        $sTextoSlashes=addslashes($sTextoMixto);
        $sTextoAmp=htmlentities($sTextoSlashes);

        return $sTextoAmp;
    }
    public static function fFechaLarga($sFechaCorta)
    {
        $arParteFecha=explode('-', $sFechaCorta);
        $iDia=0;
        $sMes="";
        switch ($arParteFecha[1])
        {
            case 01:
                $sMes='Enero';
                break;
            case 02:
                $sMes='Febrero';
                break;
            case 03:
                $sMes='Marzo';
                break;
            case 04:
                $sMes='Abril';
                break;
            case 05:
                $sMes='Mayo';
                break;
            case 06:
                $sMes='Junio';
                break;
            case 07:
                $sMes='Julio';
                break;
            case 08:
                $sMes='Agosto';
                break;
            case 09:
                $sMes='Septiembre';
                break;
            case 10:
                $sMes='Octubre';
                break;
            case 11:
                $sMes='Noviembre';
                break;
            case 12:
                $sMes='Diciembre';
                break;
            default:
                break;
        }
        $iDia=(int)$arParteFecha[2];

        $sFechaLarga=$iDia." de ".$sMes." de ".$arParteFecha[0].".";
        return $sFechaLarga;
    }
}

?>
