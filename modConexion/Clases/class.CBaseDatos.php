<?php include ($_SERVER['DOCUMENT_ROOT'].'/proyMODULOS/config.php'); ?>
<?php
require_once $_RUTARAIZ.'modConexion/Clases/class.ConstBD.php';

class CBaseDatos
{

// <editor-fold defaultstate="" desc="VARIABLES">
    private $_linkID;  //resourse para ok y false para error
    private $_Host;
    private $_sNombreBD;
    private $_sUserBD;
    private $_sPassBD;
    private $_sMensaje;
// </editor-fold>

// <editor-fold defaultstate="" desc="CONSTRUCTORES">
    /**
     *CONSTRUCTOR Para iniciar la conexion
     * @param <String> $sUserBD Usuario de la base de datos con privilegios de admin
     * @param <String> $sPassBD Contraseña
     */
    public function __construct()
    {
        $this->_Host=sServidorBD;
        $this->_sNombreBD=sNombreBD;
        $this->_sUserBD=sUserBD;
        $this->_sPassBD=sClaveBD;
        $this->_sMensaje="";
    }

// </editor-fold>

// <editor-fold defaultstate="" desc="METODOS">
    public function fBoolConectar()
    {
        $pMensaje="SE CONECTO CON EXITO";
        //VERIFICAMOS LA CONEXION AL MOTOR DE BD
        //rCon es tipo resource si tiene exito y guarda un "link identifier"
        //sino guarda un false
        $rConex=mysql_connect
        (
            $this->_Host,
            $this->_sUserBD,
            $this->_sPassBD
        );

        //si no es tipo resource es q no ha tenido exito la conexion;
        if(!is_resource($rConex))
        {
            $pMensaje="ERROR: No se puede conectar a la base de datos..! ".$this->_sNombreBD;
            $this->setMensaje($pMensaje);
            //Lanza la excepcion y se sale del procedimiento
            throw new Exception($pMensaje);
        }
        $this->setLinkID($rConex);

        //VERIFICAMOS QUE EXISTA LA BASE DE DATOS EN EL MOTOR
        //Guardo la existencia de la base de datos
        $bBDok = mysql_select_db($this->getStrNombreBD(), $rConex);

        //si no se pudo encontrar esa BD lanza un error
        if(!$bBDok)
        {
            $pMensaje="ERROR: No se puede usar la base de datos..! ".$this->getStrNombreBD();
            $this->setMensaje($pMensaje);
            //Lanza la excepcion y se sale del procedimiento
            throw new Exception($pMensaje);
        }

        $this->setMensaje($pMensaje);
        return true;
        //SI TODO ESTA BIEN HAGO LA PETICION DE DATOS DE UNA TABLA
        //$sSQL="SELECT * FROM USUARIO";
        //$rRegistros=mysql_query($sSQL,$rCon);
    }
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="GETS Y SETS">
    private function getStrHost()
    {
        return $this->_Host;
    }

    public function getStrUser()
    {
        return $this->_sUserBD;
    }

    public function getStrPass()
    {
        return $this->_sPassBD;
    }

    public function getStrMensaje()
    {
        return $this->_sMensaje;
    }
    private function getStrNombreBD()
    {
        return $this->_sNombreBD;
    }

    private function setMensaje($sValor)
    {
        $this->_sMensaje=$sValor;
    }

    private function setLinkID($rValor)
    {
        $this->_linkID=$rValor;
    }

    public function getRLinkID()
    {
        return $this->_linkID;
    }
// </editor-fold>

}
?>
