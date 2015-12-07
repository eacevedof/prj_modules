<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
require_once $_RUTARAIZ.'modConexion/Clases/class.IAccionBaseDatos.php';
require_once $_RUTARAIZ.'modClientes/Clases/class.CCliente.php';

class CFactura implements IAccionBaseDatos
{
// <editor-fold defaultstate="collapsed" desc="VARIABLES">
    //private $_oBD;

    private $_iIDN;
    private $_dFecha;
    private $_fSubtotal;
    private $_fIva;
    private $_fTotal;
    private $_sEstado;
    private $_sNotas;
    private $_iIdCliente;

    private $_sMensaje;

// </editor-fold>

// <editor-fold defaultstate="" desc="CONSTRUCTORES">
    /***
     * CONSTRUCTOR
     * Para AGREGAR EN BD llenar todos los argumentos
     * Para MODIFICAR llenar todos menos el sUser
     * Para ELIMINAR llenar solo sUser
     * Para BUSCAR llenar sUser, sNombre o sPerfil
     */ 
    public function __construct($iIDN,$dFecha,$fSubtotal,$fIva,$fTotal,$sEstado,
        $sNotas, $iIdCliente)
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
                    $this->_dFecha=$ArValor[$i];
                    break;
                case 2:
                    $this->_fSubtotal=$ArValor[$i];
                    break;
                case 3:
                    $this->_fIva=$ArValor[$i];
                    break;
                case 4:
                    $this->_fTotal=$ArValor[$i];
                    break;
                case 5:
                    $this->_sEstado=$ArValor[$i];
                    break;
                case 6:
                    $this->_sNotas=$ArValor[$i];
                    break;
                case 7:
                    $this->_iIdCliente=$ArValor[$i];
                    break;
                default:
                    $this->_sMensaje="Indice no valido: '$i'";
                    break;
            }
        }
    }

    /*public function __construct($iIDN,$dFecha,$fSubtotal,$fIva,$fTotal,$sEstado,
    $sNotas, $iIdCliente)
    {
        $this->_iIDN=$iIDN;
        $this->_dFecha=$dFecha;
        $this->_fSubtotal=$fSubtotal;
        $this->_fIva=$fIva;
        $this->_fTotal=$fTotal;
        $this->_sEstado=$sEstado;
        $this->_sNotas=$sNotas;
        $this->_iIdCliente=$iIdCliente;
        $this->_sMensaje="Indice no valido: ".$i;

    }*/

// </editor-fold>

// <editor-fold defaultstate="" desc="METODOS">

    public function pAtributosDesdeIDN(CBaseDatos $oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t06factura ".
                  "WHERE IDN='$this->_iIDN'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }

            $fRow = mysql_fetch_assoc($fResult);
            $this->_iIDN=$fRow["IDN"];
            $this->_dFecha=$fRow['FECHA'];
            $this->_fSubtotal=$fRow['SUBTOTAL'];
            $this->_fIva=$fRow['IVA'];
            $this->_fTotal=$fRow['TOTAL'];
            $this->_sEstado=$fRow['ESTADO'];
            $this->_sNotas=$fRow['NOTAS'];
            $this->_iIdCliente=$fRow['IDCLIENTE'];
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
            
            $sSQL="SELECT IDN FROM t06factura ".
                  "WHERE FECHA='$fSubtotalN'";

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

    public static function fArTabla(CBaseDatos $oBD)
    {
        $fArRegistros=Array();
        try
        {
            //Sentencia SQL
            $sSQL="SELECT DISTINCT f.* FROM t06factura AS f, t05cliente AS c
                   WHERE f.IDCLIENTE=c.IDN ORDER BY c.EMPRESA ASC";
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

    public static function fIdFactura(CBaseDatos $oBD,$dFecha,$fSubtotal,$fIva,$fTotal,$sEstado,$sNotas,$iIdCliente)
    {
        $idFactura=88;
        //Los redondeo a dos pq en mysql se guardan asi con decimal(10,2)
        $fSubtotal=round($fSubtotal,2);
        $fIva=round($fIva,2);
        $fTotal=round($fTotal,2);
        try
        {
            //Sentencia SQL
            $sSQL="SELECT MAX(IDN) AS ID FROM t06factura
                   WHERE FECHA='$dFecha' AND SUBTOTAL='$fSubtotal' AND IVA='$fIva' AND TOTAL='$fTotal' AND
                   ESTADO='$sEstado' AND NOTAS='$sNotas' AND IDCLIENTE='$iIdCliente'";
            //Obtengo los registros
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            $fRow = mysql_fetch_array($fResult);
            if(isset($fRow))
            {
                $idFactura=$fRow['ID'];
            }
            //Array que tiene como indices los nombres de los campos
            return $idFactura;
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
        $sSQL="INSERT INTO t06factura (FECHA, SUBTOTAL, IVA, TOTAL, ESTADO, NOTAS,
               IDCLIENTE) ".
        "VALUES(
            '$this->_dFecha',
            '$this->_fSubtotal',
            '$this->_fIva',
            '$this->_fTotal',
            '$this->_sEstado',
            '$this->_sNotas',
            '$this->_iIdCliente'
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
        $sSQL="UPDATE t06factura ".
        "SET
             FECHA='$this->_dFecha',
             SUBTOTAL='$this->_fSubtotal',
             IVA='$this->_fIva',
             TOTAL='$this->_fTotal',
             ESTADO='$this->_sEstado',
             NOTAS='$this->_sNotas',
             IDCLIENTE='$this->_iIdCliente'
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
        $sSQL="UPDATE t06factura ".
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
        $sSQL="DELETE FROM t06factura ".
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
        $sSQL="SELECT IDN FROM t06factura ".
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
    public function setFecha($dValor)
    {
        $this->_dFecha=$dValor;
    }

    public function setSubtotal($fValor)
    {
        $this->_fSubtotal=$fValor;
    }

    public function setIva($fValor)
    {
        $this->_fIva=$fValor;
    }

    public function setTotal($fValor)
    {
        $this->_fTotal=$fValor;
    }
    
    public function setEstado($sValor)
    {
        $this->_sEstado=$sValor;
    }

    public function setNotas($sValor)
    {
        $this->_sNotas=$sValor;
    }
    public function setIdCliente($iValor)
    {
        $this->_iIdCliente=$iValor;
    }

    public function setMensaje($sValor)
    {
        $this->_sMensaje=$sValor;
    }

    //*GET**GET**GET**GET**GET**GET**GET**GET**GET**GET*
    public function getIdFactura()
    {
        return $this->_iIDN;
    }

    public function getFecha()
    {
        return $this->_dFecha;
    }

    public function getSubtotal()
    {
        return $this->_fSubtotal;
    }
    
    public function getIva()
    {
        return $this->_fIva;
    }

    public function getTotal()
    {
        return $this->_fTotal;
    }

    public function getEstado()
    {
        return $this->_sEstado;
    }

    public function getNotas()
    {
        return $this->_sNotas;
    }

    public function getIdCliente()
    {
        return $this->_iIdCliente;
    }
  
    public function getMensaje()
    {
        return $this->_sMensaje;
    }

// </editor-fold>

}
?>