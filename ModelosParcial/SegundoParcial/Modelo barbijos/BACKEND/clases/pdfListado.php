<?php 
    require_once 'Barbijos.php';
    require_once 'Usuarios.php';
    require_once './vendor/autoload.php';
    //include_once("../vendor/autoload.php");
class pdf
{
    public static function Listado($request, $response, $args)
    {
            $datos = $args['tipo_pdf'];
            
            

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            if($datos=="usuarios")
            {
                
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
                
                if($consulta->execute()){
                    
                    $retorno= $consulta->fetchAll(PDO::FETCH_CLASS, "Usuarios");
                    //var_dump($retorno);
                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);
                            
                    $mpdf->SetHeader('Segota Ezequiel||{PAGENO}{nbpg}');
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
                    foreach ($retorno as $emp ) {
                        $grilla .= "<tr>
                        <td>".$emp->apellido."</td>
                        <td>".$emp->nombre."</td>
                        <td>".$emp->correo."</td>
                        <td>".$emp->perfil."</td>
                        <td><img src='./fotos/" . $emp->foto . "' width='100px' height='100px'/></td>
                        
                    </tr>";
                    }
                    $grilla .= '</table>';
    
                    $mpdf->WriteHTML("<h3>Listado de usuarios</h3>");
                    
                    
                    $mpdf->WriteHTML("<br>");
                    
                    $mpdf->WriteHTML($grilla);

                    $mpdf->setFooter(date("dis"));
                    
                    $headers = getallheaders();
                    $jwt = $headers["token"];
            
                    $user = AutentificadorJWT::DecodificarToken($jwt);
                    
                    
                    if(strtolower($user->perfil)=="propietario" || strtolower($user->perfil)=="encargado")
                        $pass=$user->correo;
                    else if(strtolower($user->perfil)=="empleado")
                        $pass=$user->apellido;
                    
                    $mpdf->SetProtection(array(), $pass, $pass);
                    
                    
                            
                    $mpdf->Output();

                    
                }
             
            }else if($datos=="barbijos")       
            {
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM barbijos");

                if($consulta->execute()){
                    $retorno= $consulta->fetchAll(PDO::FETCH_CLASS, "Barbijos");

                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);
                            
                    $mpdf->SetHeader('Segota Ezequiel||{PAGENO}{nbpg}');
                    $grilla = '<table class="table" border="1" align="center">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                        </tr> 
                    </thead>';
                    foreach ($retorno as $bar ) {
                        $grilla .= "<tr>
                        <td>".$bar->color."</td>
                        <td>".$bar->tipo."</td>
                        <td>".$bar->precio."</td>
                    </tr>";
                    }
                    $grilla .= '</table>';
    
                    $mpdf->WriteHTML("<h3>Listado de barbijos</h3>");
                    $mpdf->WriteHTML("<br>");
                    
                    $mpdf->WriteHTML($grilla);
                    $mpdf->setFooter(date("dis"));
                    
                    $headers = getallheaders();
                    $jwt = $headers["token"];
            
                    $user = AutentificadorJWT::DecodificarToken($jwt);
                    if(strtolower($user->perfil)=="propietario" || strtolower($user->perfil)=="encargado")
                        $pass=$user->correo;
                    else if(strtolower($user->perfil)=="empleado")
                        $pass=$user->apellido;
                    
                    $mpdf->SetProtection(array(), $pass, $pass);
                            
                    $mpdf->Output();
                }
            }
    }
}