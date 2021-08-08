<?php
class AccesoDatos
{
    private static $_objAccesoDatos;
    private $_objPDO;
 
    private function __construct()
    {
        try {

            $this->_objPDO  = new PDO('mysql:host=localhost;dbname=modelo_parcial_ovnis;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
 
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
 
    // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida', E_USER_ERROR);
    }
}