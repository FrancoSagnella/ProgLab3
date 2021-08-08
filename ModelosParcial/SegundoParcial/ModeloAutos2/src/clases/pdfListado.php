<?php 
    require_once 'usuario.php';
    require_once 'auto.php';
    require_once 'accesodatos.php';
    require_once '../vendor/autoload.php';

class pdf
{
    public static function Listado($request, $response, $args)
    {
            $datos = strtolower($args['tipo_pdf']);
            

            $objetoAccesoDato = AccesoDatos::TraerAccesoDatos();

            if($datos=="usuarios")
            {
                
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
                
                if($consulta->execute()){
                    
                    $retorno= $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);
                            
                    $mpdf->SetHeader('Sagnella Franco||{PAGENO}{nbpg}');
                    $grilla = '<table class="table" border="1" align="center">
                    <thead>
                        <tr>
                            <th>APELLIDO</th>
                            <th>NOMBRE</th>
                            <th>CORREO</th>
                            <th>PERFIL</th>
                            <th>FOTO</th>
                        </tr> 
                    </thead>';
                    foreach ($retorno as $usuario ) {
                        $grilla .= "<tr>
                        <td>".$usuario->apellido."</td>
                        <td>".$usuario->nombre."</td>
                        <td>".$usuario->correo."</td>
                        <td>".$usuario->perfil."</td>";

                        if($usuario->foto!==null)
                        {
                            //esto se esta ejecutando siempre desde el index.php, desde el directorio public
                            //tengo que referenciar desde esa carpeta hacia donde esta la foto
                            $grilla.="<td><img src='../src/fotos/" . $usuario->foto . "' width='100px' height='100px'/></td>";
                        }
            
                    $grilla.="</tr>";
                    }
                    $grilla .= '</table>';
    
                    $mpdf->WriteHTML("<h3>Listado de usuarios</h3>");
                    
                    
                    $mpdf->WriteHTML("<br>");
                    
                    $mpdf->WriteHTML($grilla);

                    $mpdf->setFooter(date("dis"));
                    
                    // $headers = getallheaders();
                    // $jwt = $headers["token"];
            
                    // $user = AutentificadorJWT::DecodificarToken($jwt);
                    
                    
                    // if(strtolower($user->perfil)=="propietario" || strtolower($user->perfil)=="encargado")
                    //     $pass=$user->correo;
                    // else if(strtolower($user->perfil)=="empleado")
                    //     $pass=$user->apellido;
                    
                    // $mpdf->SetProtection(array(), $pass, $pass);
                    
                    
                            
                    $mpdf->Output();

                    
                }
             
            }else if($datos=="autos")       
            {
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM autos");

                if($consulta->execute()){
                    $retorno= $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");

                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);
                            
                    $mpdf->SetHeader('Sagnella Franco Ezequiel||{PAGENO}{nbpg}');
                    $grilla = '<table class="table" border="1" align="center">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Modelo</th>
                        </tr> 
                    </thead>';
                    foreach ($retorno as $auto ) {
                        $grilla .= "<tr>
                        <td>".$auto->color."</td>
                        <td>".$auto->marca."</td>
                        <td>".$auto->precio."</td>
                        <td>".$auto->modelo."</td>
                    </tr>";
                    }
                    $grilla .= '</table>';
    
                    $mpdf->WriteHTML("<h3>Listado de autos</h3>");
                    $mpdf->WriteHTML("<br>");
                    
                    $mpdf->WriteHTML($grilla);
                    $mpdf->setFooter(date("dis"));
                    
                    // $headers = getallheaders();
                    // $jwt = $headers["token"];
            
                    // $user = AutentificadorJWT::DecodificarToken($jwt);
                    // if(strtolower($user->perfil)=="propietario" || strtolower($user->perfil)=="encargado")
                    //     $pass=$user->correo;
                    // else if(strtolower($user->perfil)=="empleado")
                    //     $pass=$user->apellido;
                    
                    // $mpdf->SetProtection(array(), $pass, $pass);
                            
                    $mpdf->Output();
                }
            }
    }
}