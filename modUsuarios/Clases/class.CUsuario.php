<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
require_once $_RUTARAIZ.'modConexion/Clases/class.CBaseDatos.php';
require_once $_RUTARAIZ.'modConexion/Clases/class.IAccionBaseDatos.php';

class CUsuario implements IAccionBaseDatos
{
// <editor-fold defaultstate="collapsed" desc="VARIABLES">
    //private $_oBD;

    private $_iIDN;
    private $_sLogin;
    private $_sClave;
    private $_sEmail;
    private $_sNombres;
    private $_sApellidos;
    private $_sTelefonos;
    private $_sPais;
    private $_sRegion;
    private $_sCodpos;
    private $_sSexo;     //M:Mujer H:Hombre
    private $_dFecnac;   //Año de nacimiento

    //private $_dUltacc;   //TODO Clase accesoFecha y hora de acceso
    private $_sCategoria; //Administrador, Usuario, SuperUsuario
    private $_sEstado;   //Activo, bloqueado, Borrado
    private $_sUltimaAcc; //La ultima accion realizada en la tabla
    private $_iEjecpor;  //IDN de quien ejecuto
    private $_dEjecfec;  //Fecha y hora de cuando se ejecuto

    private $_bSesion=false;  //Esta no interactua con la BD
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
    public function __construct($iIDN,$sLogin,$sClave,$sEmail,$sNombres,$sApellidos,
        $sTelefonos,$sPais,$sRegion,$sCodpos,$sSexo,$dFecnac,$sCategoria, $sEstado,
        $sUltimaAccion, $iEjecpor, $sEjecfec)
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
                    $this->_sLogin=$ArValor[$i];
                    break;
                case 2:
                    $this->_sClave=$ArValor[$i];
                    break;
                case 3:
                    $this->_sEmail=$ArValor[$i];
                    break;
                case 4:
                    $this->_sNombres=$ArValor[$i];
                    break;
                case 5:
                    $this->_sApellidos=$ArValor[$i];
                    break;
                case 6:
                    $this->_sTelefonos=$ArValor[$i];
                    break;
                case 7:
                    $this->_sPais=$ArValor[$i];
                    break;
                case 8:
                    $this->_sRegion=$ArValor[$i];
                    break;
                case 9:
                    $this->_sCodpos=$ArValor[$i];
                    break;
                case 10:
                    $this->_sSexo=$ArValor[$i];
                    break;
                case 11:
                    $this->_dFecnac=$ArValor[$i];
                    break;
                case 12:
                    $this->_sCategoria=$ArValor[$i];
                    break;
                case 13:
                    $this->_sEstado=$ArValor[$i];
                    break;
                case 14:
                    $this->_sUltimaAcc=$ArValor[$i];
                    break;
                case 15:
                    $this->_iEjecpor=$ArValor[$i];
                    break;
                case 16:
                    $this->_dEjecfec=$ArValor[$i];
                    break;

                default:
                    $this->setMensaje("Indice no valido: '$i'");
                    break;
            }
        }
    }

// </editor-fold>

// <editor-fold defaultstate="" desc="METODOS">

    public function pAtributosDesdeIDN($oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t01usuario ".
                  "WHERE IDN='$this->_iIDN'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }

            $fRow = mysql_fetch_assoc($fResult);
            $this->_iIDN=$fRow["IDN"];;
            $this->setLogin($fRow['LOGIN']);
            $this->setClave($fRow['CLAVE']);
            $this->setEmail($fRow['EMAIL']);
            $this->setNombres($fRow['NOMBRES']);
            $this->setApellidos($fRow['APELLIDOS']);
            $this->setTelefonos($fRow['TELEFONOS']);
            $this->setPaiS($fRow['PAIS']);
            $this->setRegion($fRow['REGION']);
            $this->setCodigoPostal($fRow['CODPOS']);
            $this->setSexo($fRow['SEXO']);
            $this->setFechaNacimiento($fRow['FECNAC']);
            $this->setCagetgoria($fRow['CATEGORIA']);
            $this->setEstado($fRow['ESTADO']);
            $this->setUltimaAccion($fRow['ULTIMAACC']);
            $this->setEjecutadoPor($fRow['EJECPOR']);
            $this->setEjecucionFecha($fRow['EJECFEC']);
            
        }
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje(); si dejo los echo habra problema con los header();
        }
    }
    //Habria que construir el objeto solo con el email
    //y este metodo llena el resto de atributos
    public function pAtributosDesdeLogin($oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT * FROM t01usuario ".
                  "WHERE LOGIN='$this->_sLogin'";

            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no hay registros
            if(!$fResult)
            {
                exit;
            }
            
            $fRow = mysql_fetch_assoc($fResult);
            
            $this->_iIDN=$fRow["IDN"];;
            $this->setLogin($fRow['LOGIN']);
            $this->setClave($fRow['CLAVE']);
            $this->setEmail($fRow['EMAIL']);
            $this->setNombres($fRow['NOMBRES']);
            $this->setApellidos($fRow['APELLIDOS']);
            $this->setTelefonos($fRow['TELEFONOS']);
            $this->setPaiS($fRow['PAIS']);
            $this->setRegion($fRow['REGION']);
            $this->setCodigoPostal($fRow['CODPOS']);
            $this->setSexo($fRow['SEXO']);
            $this->setFechaNacimiento($fRow['FECNAC']);
            $this->setCagetgoria($fRow['CATEGORIA']);
            $this->setEstado($fRow['ESTADO']);
            $this->setUltimaAccion($fRow['ULTIMAACC']);
            $this->setEjecutadoPor($fRow['EJECPOR']);
            $this->setEjecucionFecha($fRow['EJECFEC']);
        }
        catch (Exception $e)
        {
            setMensaje($e);
            //echo getMensaje(); si dejo los echo habra problema con los header();
        }
    }

    public static function fBoolAcceso($sLogin, $sClave, CBaseDatos $oBD)
    {
        try
        {
            $sClave=(hash("sha256", $sClave));
            //Sentencia SQL
            $sSQL="SELECT IDN,CLAVE FROM t01usuario ".
                  "WHERE LOGIN='$sLogin' AND CLAVE='$sClave'";

            //Obtengo los registros, si no hay nada devuelve false
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            if($fResult)
            {
                $iFilas=mysql_num_rows($fResult);
                if($iFilas==1)//Evita el sql injection
                {
                    while($fRow = mysql_fetch_array($fResult))
                    {
                        $fArRegistros[0]=$fRow;
                    }
                    
                    $sClaveEnBD=$fArRegistros[0]["CLAVE"];
                    
                    if(strcmp($sClave,$sClaveEnBD)==0)
                    {
                        return true;
                    }
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

    public static function fBoolExisteLogin($sLoginN, $sClave, CBaseDatos $oBD)
    {
        try
        {
            //Sentencia SQL
            //$sSQL="SELECT * FROM t01usuario ".
            //      "WHERE LOGIN='$sLogin' AND CLAVE='$sClave'";
            $sSQL="SELECT CLAVE FROM t01usuario ".
                  "WHERE LOGIN='$sLoginN'";

            //Obtengo los registros, si no hay nada devuelve false
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            if($fResult)
            {
                $iFilas=mysql_num_rows($fResult);
                if($iFilas==1)
                {
                    while($fRow = mysql_fetch_array($fResult))
                    {
                        $fArRegistros[0]=$fRow;
                    }

                    $sClaveEnBD=$fArRegistros[0]["CLAVE"];
                    
                    if(strcmp($sClave,$sClaveEnBD)==0)
                    {
                        return true;
                    }
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
    public static function fStrLoginOK($sLoginN, CBaseDatos $oBD)
    {
        $sPatronLogin='/^[a-zd_]{4,28}$/i';
        try
        {
            if (!preg_match($sPatronLogin, $sLoginN))
            {
                return "N";
            }
            
            $sSQL="SELECT IDN FROM t01usuario ".
                  "WHERE LOGIN='$sLoginN'";

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

    //Si llamo a esta funcion quiere decir que tengo que enviarle
    //el usuario con este login, se usa para cambiar el login
    public static function fStrModLogin($sLoginOrig, $sLoginNuevo, CBaseDatos $oBD)
    {
        try
        {
            //Sentencia SQL
            $sSQL="SELECT IDN FROM t01usuario ".
                  "WHERE LOGIN!='$sLoginOrig' AND LOGIN='$sLoginNuevo'";

            //Obtengo los registros, si no hay nada devuelve false
            $fResult=mysql_query($sSQL, $oBD->getRLinkID());

            //Si no ha tenido exito es pq esta disponible ese login
            if(!$fResult)
            {
                return "ERROR en consulta";
            }
            else
            {
                $iFilas=mysql_num_rows($fResult);
                if($iFilas==0)
                {
                    return "ok";
                }
                else
                {
                    return "x";
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
            $sSQL="SELECT * FROM t01usuario WHERE CATEGORIA!='SUPER'";
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
                //echo $fArRegistros[$i]["user"]."<br>";
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

    public function pActualizaAcceso()
    {
        $sSQL="UPDATE t01usuario ".
        "SET ULTACC='$this->_dUltacc'
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

    /**
     * Supongo que ya tengo un usuario construido y con las variables
     * privadas ejecuto este metodo
     */
    public function Agregar()
    {
        //Encripto la clave
        $this->setClave(hash("sha256", $this->getClave()));
        //No hace falta utilizar $oBD, pq mysql_query
        //captura el ultimo link automaticamente que se abrio en el archivo.php.
        $sSQL="INSERT INTO t01usuario (LOGIN, CLAVE, EMAIL, NOMBRES, APELLIDOS, TELEFONOS,
               PAIS, REGION, CODPOS, SEXO, FECNAC, CATEGORIA, ESTADO, ULTIMAACC, EJECPOR, EJECFEC) ".
        "VALUES(
            '$this->_sLogin',
            '$this->_sClave',
            '$this->_sEmail',
            '$this->_sNombres',
            '$this->_sApellidos',
            '$this->_sTelefonos',
            '$this->_sPais',
            '$this->_sRegion',
            '$this->_sCodpos',
            '$this->_sSexo',
            '$this->_dFecnac',
            '$this->_sCategoria',
            '$this->_sEstado',
            '$this->_sUltimaAcc',
            '$this->_iEjecpor',
            '$this->_dEjecfec'
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
        //Encripto la clave
        $this->setClave(hash("sha256", $this->getClave()));

        $sSQL="UPDATE t01usuario ".
        "SET 
             LOGIN='$this->_sLogin',
             CLAVE='$this->_sClave',
             EMAIL='$this->_sEmail',
             NOMBRES='$this->_sNombres',
             APELLIDOS='$this->_sApellidos',
             TELEFONOS='$this->_sTelefonos',
             PAIS='$this->_sPais',
             REGION='$this->_sRegion',
             CODPOS='$this->_sCodpos',
             SEXO='$this->_sSexo',
             FECNAC='$this->_dFecnac',
             CATEGORIA='$this->_sCategoria',
             ESTADO='$this->_sEstado',
             ULTIMAACC='$this->_sUltimaAcc',
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

    public function ModificarDatos()
    {
        $sSQL="UPDATE t01usuario ".
        "SET
             EMAIL='$this->_sEmail',
             NOMBRES='$this->_sNombres',
             APELLIDOS='$this->_sApellidos',
             TELEFONOS='$this->_sTelefonos',
             PAIS='$this->_sPais',
             REGION='$this->_sRegion',
             CODPOS='$this->_sCodpos',
             SEXO='$this->_sSexo',
             FECNAC='$this->_dFecnac',
             ULTIMAACC='$this->_sUltimaAcc',
             EJECPOR='$this->_iEjecpor',
             EJECFEC='$this->_dEjecfec'
        WHERE IDN='$this->_iIDN'";
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

    public function ModificarLogin()
    {
        $sSQL="UPDATE t01usuario ".
        "SET LOGIN='$this->_sLogin' 
        WHERE IDN='$this->_iIDN'";
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

    public function EliminarL()
    {
        $sSQL="UPDATE t01usuario ".
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
        $sSQL="DELETE FROM t01usuario ".
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
        $sSQL="SELECT IDN FROM t01usuario ".
              "WHERE LOGIN='$iIDN'";

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
    public function setLogin($sValor)
    {
        $this->_sLogin=$sValor;
    }

    public function setClave($sValor)
    {
        $this->_sClave=$sValor;
    }

    public function setEmail($sValor)
    {
        $this->_sEmail=$sValor;
    }
    
    public function setNombres($sValor)
    {
        $this->_sNombres=$sValor;
    }

    public function setApellidos($sValor)
    {
        $this->_sApellidos=$sValor;
    }
    public function setTelefonos($sValor)
    {
        $this->_sTelefonos=$sValor;
    }

    public function setPais($sValor)
    {
        $this->_sPais=$sValor;
    }

    public function setRegion($sValor)
    {
        $this->_sRegion=$sValor;
    }

    public function setCodigoPostal($sValor)
    {
        $this->_sCodpos=$sValor;
    }

    public function setSexo($sValor)
    {
        $this->_sSexo=$sValor;
    }

    public function setFechaNacimiento($dValor)
    {
        $this->_dFecnac=$dValor;
    }

    public function setCagetgoria($sValor)
    {
        $this->_sCategoria=$sValor;
    }

    public function setEstado($sValor)
    {
        $this->_sEstado=$sValor;
    }

    public function setUltimaAccion($sValor)
    {
        $this->_sUltimaAcc=$sValor;
    }

    public function setEjecutadoPor($iValor)
    {
        $this->_iEjecpor=$iValor;
    }

    public function setEjecucionFecha($dValor)
    {
        $this->_dEjecfec=$dValor;
    }

    public function setSesion($bValor)
    {
        $this->_bSesion=$bValor;
    }

    public function setMensaje($sValor)
    {
        $this->_sMensaje=$sValor;
    }

    //*GET**GET**GET**GET**GET**GET**GET**GET**GET**GET*
    public function getIdUsuario()
    {
        return $this->_iIDN;
    }

    public function getLogin()
    {
        return $this->_sLogin;
    }
    public function getClave()
    {
        return $this->_sClave;
    }

    public function getEmail()
    {
        return $this->_sEmail;
    }

    public function getNombres()
    {
        return $this->_sNombres;
    }

    public function getApellidos()
    {
        return $this->_sApellidos;
    }

    public function getTelefonos()
    {
        return $this->_sTelefonos;
    }

    public function getPais()
    {
        return $this->_sPais;
    }

    public function getRegion()
    {
        return $this->_sRegion;
    }

    public function getCodigoPostal()
    {
        return $this->_sCodpos;
    }

    public function getSexo()
    {
        return $this->_sSexo;
    }

    public function getFechaNacimiento()
    {
        return $this->_dFecnac;
    }
    
    public function getCategoria()
    {
        return $this->_sCategoria;
    }

    public function getEstado()
    {
        return $this->_sEstado;
    }

    public function getUltimaAccion()
    {
        return $this->_sUltimaAcc;
    }

    public function getEjecutadoPor()
    {
        return $this->_iEjecpor;
    }

    public function getEjecucionFecha()
    {
        return $this->_dEjecfec;
    }

    public function getSesion()
    {
        return $this->_bSesion;
    }

    public function getMensaje()
    {
        return $this->_sMensaje;
    }

// </editor-fold>

}
?>