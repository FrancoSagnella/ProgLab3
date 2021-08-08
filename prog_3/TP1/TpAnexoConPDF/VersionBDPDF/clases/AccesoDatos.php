<?php
class AccesoDatos
{
    private static $_objAccesoDatos;
    private $_objPDO;
 
    private function __construct()
    {
        try {
            //$this->_objPDO  = new PDO('mysql:host=localhost;dbname=tp_bd;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->_objPDO  = new PDO('mysql:host=us-cdbr-east-03.cleardb.com;dbname=heroku_a33f45fa011b954;charset=utf8', 'b1a81ab4c3eefd', '3b3806c6', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            //b1a81ab4c3eefd:3b3806c6@us-cdbr-east-03.cleardb.com/heroku_a33f45fa011b954?reconnect=true
        } catch (PDOException $e) {
 
            print $e->getMessage();
            die();
        }
    }
 
    public function RetornarConsulta($sql)
    {
        return $this->_objPDO->prepare($sql);
    }
 
    public static function TraerAccesoDatos()
    {
        if (!isset(self::$_objAccesoDatos)) {       
            self::$_objAccesoDatos = new AccesoDatos(); 
        }
 
        return self::$_objAccesoDatos;        
    }
 
    public function __clone()
    {
        trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida', E_USER_ERROR);
    }
}