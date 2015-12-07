<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
require_once $_RUTARAIZ.'modConexion/Clases/class.IAccionBaseDatos.php';
require_once $_RUTARAIZ.'modFacturas/Clases/class.CFactura.php';

class CDetalleFactura implements IAccionBaseDatos
{
// <editor-fold defaultstate="collapsed" desc="VARIABLES">
    //private $_oBD;

    private $_iIDN;
    private $_sConcepto;
    private $_fCantidad;
    private $_iIdFactura;

    private $_sMensaje;

// </editor-fold>

// <editor-fold defaultstate="" desc="CONSTRUCTORES">
    /***
     * CONSTRUCTOR
     * Para AGREGAR EN BD llenar todos los argumentos
     * Para MODIFICAR llenar todos menos el sUser
     * Para ELIMINAR llenar solo sUser
     * Para BUSCAR llenar sUser, sNombre o sPerfil
     * 
     */
    public function __construct($iIDN,$sConcepto,$fCantidad, $iIdFactura)
    {
        //arg_list[i] contenido de la variable i
        $iNumArgs = func_num_args();
        $ArValor = func_get_args();
        for ($i = 0; $i < $iNumArgs; $i++)
        {
            switch($i)
            {
                case 0:
                    $this->_iIDN=$ArValor[$i];
                    break;
                case 1:
                    $this->_sConcepto=$ArValor[$i];
                    break;
                case 2:
                    $this->_fCantidad=$ArValor[$i];
                    break;
                case 3:
                    $this->_iIdFactura=$ArValor[$i];
                    break;
                default:
                    $this->_sMensaje="Indice no valido: '$i'";
                    break;
            }
        }
    }

// </editor-fold>

// <editor-fold defaultstate="" desc="METODOS">

    public function pAtributosDesdeIDN(CBaseDatos $oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t07detfactur ".
                  "WHERE IDN='$this->_iIDN'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }

            $fRow = mysql_fetch_assoc($fResult);
            $this->_iIDN=$fRow["IDN"];
            $this->_sConcepto=$fRow['CONCEPTO'];
            $this->_fCantidad=$fRow['CANTIDAD'];
            $this->_iIdFactura=$fRow['IDFACTURA'];
        }
        catch (Exception $e)
        {
            $this->_sMensaje=$e;
        }
    }


    //Para AJAX
    public static function fStrLoginOK($fSubtotalN, CBaseDatos $oBD)
    {
        $sPatronCif='/^[a-zd_]{4,28}$/i';
        try
        {
            if (!preg_match($sPatronCif, $fSubtotalN))
            {
                return "N";
            }
            
            $sSQL="SELECT IDN FROM t07detfactur ".
                  "WHERE CONCEPTO='$fSubtotalN'";

            //Obtengo los registros, si no hay nada devuelve false
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            if(!$fResult)
            {
                return "ERROR en consulta";
            }
            else
            {
                $iFilas=mysql_num_rows($fResult);
                if($iFilas==0)
                {
                    //Si no hay filas es q se puede usar
                    return "Y";
                }
                else
                {
                    //si tiene al menos una fila es q el login ya existe
                    return "N";
                }
            }
        }
        catch (Exception $e)
        {
            $this->_sMensaje=$e;
            //echo getMensaje();
        }
    }

    public static function fArTabla($iIdFactura, CBaseDatos $oBD)
    {
        $fArRegistros=Array();
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t07detfactur
                   WHERE IDFACTURA='$iIdFactura'";
            //Obtengo los registros
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());
            $i=0;
            while($fRow = mysql_fetch_array($fResult))
            {
                $fArRegistros[$i]=$fRow;
                $i++;
            }
            //Array que tiene como indices los nombres de los campos
            return $fArRegistros;
        }
        catch (Exception $e)
        {
            $this->_sMensaje=$e;
        }

    }

    /**
     * Supongo que ya tengo un usuario construido y con las variables
     * privadas ejecuto este metodo
     */
    public function Agregar()
    {
        /*
        $iIDCliente=$fRow['IDCLIENTE'];
        $iIdFactura= new CCliente($iIDCliente, null, null, null, null, null, null, null, null, null, null, null, null);
        $iIdFactura=$this->_iIdFactura;
        */
        $sSQL="INSERT INTO t07detfactur (CONCEPTO, CANTIDAD, IDFACTURA) ".
        "VALUES(
            '$this->_sConcepto',
            '$this->_fCantidad',
            '$this->_iIdFactura'
        )";
        try
        {
            $result = mysql_query($sSQL);
            if (!$result)
            {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sSQL;
                die($message);
            }
        }
        catch(Exception $e)
        {
            $this->_sMensaje=$e;
        }
    }

    public function Modificar()
    {
        $sSQL="UPDATE t07detfactur ".
        "SET
             CONCEPTO='$this->_sConcepto',
             CANTIDAD='$this->_fCantidad',
             IDFACTURA='$this->_iIdFactura'
         WHERE IDN='$this->_iIDN'
        ";
        try
        {
            $result = mysql_query($sSQL);
            if (!$result)
            {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sSQL;
                die($message);
            }
        }
        catch(Exception $e)
        {
            $this->_sMensaje=$e;
        }
    }

    //TODO en un futuro
    public function EliminarL()
    {
        $sSQL="UPDATE t07detfactur ".
        "SET
             ESTADO='$this->_sEstado',
             EJECPOR='$this->_iEjecpor',
             EJECFEC='$this->_dEjecfec'
         WHERE IDN='$this->_iIDN'
        ";
        try
        {
            $result = mysql_query($sSQL);
            if (!$result)
            {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sSQL;
                die($message);
            }
        }
        catch(Exception $e)
        {
            $this->_sMensaje=$e;
            //echo getMensaje();
        }
    }

    public function EliminarF()
    {
        $sSQL="DELETE FROM t07detfactur ".
              "WHERE IDN=$this->_iIDN";
        try
        {
            $result = mysql_query($sSQL);
            if (!$result)
            {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $sSQL;
                die($message);
            }
        }
        catch(Exception $e)
        {
            $this->_sMensaje=$e;
        }
    }

    public function Buscar()
    {

    }
    public static function fBoolExiste($iIDN, CBaseDatos $oBD)
    {
        $sSQL="SELECT IDN FROM t07detfactur ".
              "WHERE IDN='$iIDN'";

        //Obtengo los registros, si no hay nada devuelve false
        $fResult=mysql_query($sSQL, $oBD->getRLinkID());

        if($fResult)
        {
            $iFilas=mysql_num_rows($fResult);
            if($iFilas==1)
            {
                return true;
            }
        }
        return false;
    }
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="GETS Y SETS">
    public function setConcepto($sValor)
    {
        $this->_sConcepto=$sValor;
    }

    public function setCantidad($fValor)
    {
        $this->_fCantidad=$fValor;
    }

    public function setIdFactura($iValor)
    {
        $this->_iIdFactura=$iValor;
    }

    public function setMensaje($sValor)
    {
        $this->_sMensaje=$sValor;
    }

    //*GET**GET**GET**GET**GET**GET**GET**GET**GET**GET*
    public function getIdDetalleFactura()
    {
        return $this->_iIDN;
    }

    public function getConcepto()
    {
        return $this->_sConcepto;
    }

    public function getCantidad()
    {
        return $this->_fCantidad;
    }
    
    public function getIdFactura()
    {
        return $this->_iIdFactura;
    }

    public function getMensaje()
    {
        return $this->_sMensaje;
    }

// </editor-fold>

}
?>