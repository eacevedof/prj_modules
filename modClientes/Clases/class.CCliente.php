<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
require_once $_RUTARAIZ.'modConexion/Clases/class.IAccionBaseDatos.php';

class CCliente implements IAccionBaseDatos
{
// <editor-fold defaultstate="collapsed" desc="VARIABLES">
    //private $_oBD;

    private $_iIDN;
    private $_sCifnif;
    private $_sEmpresa;
    private $_sCodpos;
    private $_sCiudad;
    private $_sDireccion;
    private $_sTelefono;
    private $_sMovil;
    private $_sPercont;
    private $_sEmail;
    private $_sCBanco;
    private $_sDominios;
    private $_sNotas;

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
    public function __construct($iIDN,$sCifnif,$sEmpresa,$sCodpos,$sCiudad,$sDireccion,
        $sTelefono,$sMovil,$sPercont,$sEmail,$sCBanco,$sDominios,$sNotas)
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
                    $this->_sCifnif=$ArValor[$i];
                    break;
                case 2:
                    $this->_sEmpresa=$ArValor[$i];
                    break;
                case 3:
                    $this->_sCodpos=$ArValor[$i];
                    break;
                case 4:
                    $this->_sCiudad=$ArValor[$i];
                    break;
                case 5:
                    $this->_sDireccion=$ArValor[$i];
                    break;
                case 6:
                    $this->_sTelefono=$ArValor[$i];
                    break;
                case 7:
                    $this->_sMovil=$ArValor[$i];
                    break;
                case 8:
                    $this->_sPercont=$ArValor[$i];
                    break;
                case 9:
                    $this->_sEmail=$ArValor[$i];
                    break;
                case 10:
                    $this->_sCBanco=$ArValor[$i];
                    break;
                case 11:
                    $this->_sDominios=$ArValor[$i];
                    break;
                case 12:
                    $this->_sNotas=$ArValor[$i];
                    break;
                default:
                    $this->setMensaje("Indice no valido: '$i'");
                    break;
            }
        }
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="METODOS">

    public function pAtributosDesdeIDN($oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t05cliente ".
                  "WHERE IDN='$this->_iIDN'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }

            $fRow = mysql_fetch_assoc($fResult);
            $this->_iIDN=$fRow["IDN"];
            $this->_sCifnif=$fRow['CIFNIF'];
            $this->_sEmpresa=$fRow['EMPRESA'];
            $this->_sCodpos=$fRow['CODPOS'];
            $this->_sCiudad=$fRow['CIUDAD'];
            $this->_sDireccion=$fRow['DIRECCION'];
            $this->_sTelefono=$fRow['TELEFONO'];
            $this->_sMovil=$fRow['MOVIL'];
            $this->_sPercont=$fRow['PERCONT'];
            $this->_sEmail=$fRow['EMAIL'];
            $this->_sCBanco=$fRow['CBANCO'];
            $this->_sDominios=$fRow['DOMINIOS'];
            $this->_sNotas=$fRow['NOTAS'];
        }
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje(); si dejo los echo habra problema con los header();
        }
    }
    //Habria que construir el objeto solo con el email
    //y este metodo llena el resto de atributos
    public function pAtributosDesdeCif($oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t05cliente ".
                  "WHERE CIFNIF='$this->_sCifnif'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }
            $fRow = mysql_fetch_assoc($fResult);
            $this->_iIDN=$fRow["IDN"];
            $this->_sCifnif=$fRow['CIFNIF'];
            $this->_sEmpresa=$fRow['EMPRESA'];
            $this->_sCodpos=$fRow['CODPOS'];
            $this->_sCiudad=$fRow['CIUDAD'];
            $this->_sDireccion=$fRow['DIRECCION'];
            $this->_sTelefono=$fRow['TELEFONO'];
            $this->_sMovil=$fRow['MOVIL'];
            $this->_sPercont=$fRow['PERCONT'];
            $this->_sEmail=$fRow['EMAIL'];
            $this->_sCBanco=$fRow['CBANCO'];
            $this->_sDominios=$fRow['DOMINIOS'];
            $this->_sNotas=$fRow['NOTAS'];
        }
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje(); si dejo los echo habra problema con los header();
        }
    }

    public static function fBoolExisteCif($sCifNif, CBaseDatos $oBD)
    {
        try
        {

            $sSQL="SELECT IDN FROM t05cliente ".
                  "WHERE CIFNIF='$sCifNif'";

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
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje();
        }
    }

    //Para AJAX
    public static function fStrLoginOK($sCifNifN, CBaseDatos $oBD)
    {
        $sPatronCif='/^[a-zd_]{4,28}$/i';
        try
        {
            if (!preg_match($sPatronCif, $sCifNifN))
            {
                return "N";
            }
            
            $sSQL="SELECT IDN FROM t05cliente ".
                  "WHERE CIFNIF='$sCifNifN'";

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
            setMensaje($e);
            //echo getMensaje();
        }
    }



    public static function fArTabla(CBaseDatos $oBD)
    {
        $fArRegistros=Array();
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t05cliente ORDER BY EMPRESA ASC";
            //Obtengo los registros
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());
            //El numero de registros
            //$iFilas=mysql_num_rows($fResult);
            //Recupero todos los registros
            //http://docs.php.net/manual/en/function.mysql-fetch-array.php
            $i=0;
            while($fRow = mysql_fetch_array($fResult))
            {
                $fArRegistros[$i]=$fRow;
                //Imprimo los datos
                //echo $fArRegistros[$i]["empresa"]."<br>";
                $i++;
            }
            //Array que tiene como indices los nombres de los campos
            return $fArRegistros;
        }
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje();
        }

    }

    /**
     * Supongo que ya tengo un usuario construido y con las variables
     * privadas ejecuto este metodo
     */
    public function Agregar()
    {
        //No hace falta utilizar $oBD, pq mysql_query
        //captura el ultimo link que se abrio, por lo tanto
        //solo se abre el link con oBD.
        $sSQL="INSERT INTO t05cliente (CIFNIF, EMPRESA, CODPOS, CIUDAD, DIRECCION, TELEFONO,
               MOVIL, PERCONT, EMAIL, CBANCO, DOMINIOS, NOTAS) ".
        "VALUES(
            '$this->_sCifnif',
            '$this->_sEmpresa',
            '$this->_sCodpos',
            '$this->_sCiudad',
            '$this->_sDireccion',
            '$this->_sTelefono',
            '$this->_sMovil',
            '$this->_sPercont',
            '$this->_sEmail',
            '$this->_sCBanco',
            '$this->_sDominios',
            '$this->_sNotas'
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
            $this->setMensaje($e);
        }
    }

    public function Modificar()
    {
        $sSQL="UPDATE t05cliente ".
        "SET 
             CIFNIF='$this->_sCifnif',
             EMPRESA='$this->_sEmpresa',
             CODPOS='$this->_sCodpos',
             CIUDAD='$this->_sCiudad',
             DIRECCION='$this->_sDireccion',
             TELEFONO='$this->_sTelefono',
             MOVIL='$this->_sMovil',
             PERCONT='$this->_sPercont',
             EMAIL='$this->_sEmail',
             CBANCO='$this->_sCBanco',
             DOMINIOS='$this->_sDominios',
             NOTAS='$this->_sNotas'
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
            setMensaje($e);
            //echo getMensaje();
        }
    }

    //TODO en un futuro
    public function EliminarL()
    {
        $sSQL="UPDATE t05cliente ".
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
            setMensaje($e);
            //echo getMensaje();
        }
    }

    public function EliminarF()
    {
        $sSQL="DELETE FROM t05cliente ".
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
            setMensaje($e);
            //echo getMensaje();
        }
    }

    public function Buscar()
    {

    }
    public static function fBoolExiste($iIDN, CBaseDatos $oBD)
    {
        $sSQL="SELECT IDN FROM t05cliente ".
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
    public function setCifnif($sValor)
    {
        $this->_sCifnif=$sValor;
    }

    public function setEmpresa($sValor)
    {
        $this->_sEmpresa=$sValor;
    }

    public function setCodpos($sValor)
    {
        $this->_sCodpos=$sValor;
    }
    
    public function setCiudad($sValor)
    {
        $this->_sCiudad=$sValor;
    }
    public function setDireccion($sValor)
    {
        $this->_sDireccion=$sValor;
    }
    public function setTelefono($sValor)
    {
        $this->_sTelefono=$sValor;
    }

    public function setMovil($sValor)
    {
        $this->_sMovil=$sValor;
    }

    public function setPersonaContacto($sValor)
    {
        $this->_sPercont=$sValor;
    }

    public function setEmail($sValor)
    {
        $this->_sEmail=$sValor;
    }

    public function setCuentaBancaria($sValor)
    {
        $this->_sCBanco=$sValor;
    }

    public function setDominios($sValor)
    {
        $this->_sDominios=$sValor;
    }

    public function setNotas($sValor)
    {
        $this->_sNotas=$sValor;
    }

    public function setMensaje($sValor)
    {
        $this->_sMensaje=$sValor;
    }

    //*GET**GET**GET**GET**GET**GET**GET**GET**GET**GET*
    public function getIdCliente()
    {
        return $this->_iIDN;
    }

    public function getCifnif()
    {
        return $this->_sCifnif;
    }
    public function getEmpresa()
    {
        return $this->_sEmpresa;
    }

    public function getCodigoPostal()
    {
        return $this->_sCodpos;
    }

    public function getCiudad()
    {
        return $this->_sCiudad;
    }

    public function getDireccion()
    {
        return $this->_sDireccion;
    }

    public function getTelefonos()
    {
        return $this->_sTelefono;
    }

    public function getMoviles()
    {
        return $this->_sMovil;
    }

    public function getPersonaContacto()
    {
        return $this->_sPercont;
    }
    public function getEmail()
    {
        return $this->_sEmail;
    }

    public function getCuentaBancaria()
    {
        return $this->_sCBanco;
    }

    public function getDominios()
    {
        return $this->_sDominios;
    }
    
    public function getNotas()
    {
        return $this->_sNotas;
    }
  
    public function getMensaje()
    {
        return $this->_sMensaje;
    }

// </editor-fold>

}
?>