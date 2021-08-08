<?php
require_once 'accesodatos.php';

//En esta clase me quedaron los metodos para traer y crear usuarios
class Usuario{
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $foto;
    public $id_perfil;
    public $perfil;
    public $clave;

    public static function construirUsuario($id, $nombre, $apellido, $correo, $foto, $id_perfil, $perfil, $clave)
    {   
        $user = new Usuario();
        $user->id = $id;
        $user->nombre = $nombre;
        $user->apellido  = $apellido;
        $user->correo = $correo;
        $user->foto = $foto;
        $user->id_perfil = $id_perfil;
        $user->perfil = $perfil;
        $user->clave = $clave;

        return $user;
    }

    public static function TraerUnUsuario($correo, $clave)
    {
        try {
           
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre,usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil WHERE usuarios.correo = :correo AND usuarios.clave = :clave");

            $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $clave, PDO::PARAM_INT);

            $consulta->execute();
 
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user =  Usuario::construirUsuario($row['id'], $row['nombre'], $row['apellido'], $row['correo'], $row['foto'], $row['id_perfil'], $row['descripcion'], $row['clave']);            }

            if (isset($user)) {
                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}