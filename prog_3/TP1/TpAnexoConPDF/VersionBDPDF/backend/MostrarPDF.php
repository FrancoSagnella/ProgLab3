<?php
require_once("../clases/empleado.php");
require_once("../clases/fabrica.php");
require_once __DIR__ . '/vendor/autoload.php';
header('content-type:application/pdf', "charset = utf-8");
            $fabrica = new Fabrica('Mi fabrica', 7);
            $fabrica->traerDeBD();
    
            $lista = '<table>
                <thead>
                    <tr>
                        <td >
                            <h4>Nombre</h4>                    
                        </td>
                        <td >
                            <h4>Apellido</h4>                    
                        </td>
                        <td >
                            <h4>DNI</h4>                    
                        </td>
                        <td >
                            <h4>Sexo</h4>                    
                        </td>
                        <td >
                            <h4>Legajo</h4>                    
                        </td>
                        <td >
                            <h4>Sueldo</h4>                    
                        </td>
                        <td >
                            <h4>Turno</h4>                    
                        </td>
                        <td >
                            <h4>PathFoto</h4>                    
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" ><hr /></td>
                    </tr>
                </thead>
                <tbody>';

        foreach ($fabrica->getEmpleados() as $value) {
            $lista .= '<tr>
            <td >
                '.$value->getNombre().'                    
            </td>
            <td >
            '.$value->getApellido().'                                    
            </td>
            <td >
            '.$value->getDni().'                                      
            </td>
            <td >
            '.$value->getSexo().'                                       
            </td>
            <td >
            '.$value->getLegajo().'                                       
            </td>
            <td >
            '.$value->getSueldo().'                                       
            </td>
            <td >
            '.$value->getTurno().'                                      
            </td>
            <td >
            '.$value->getPathFoto().'                                       
            </td>
                <td>
                        
                        <img src=../' . $value->getPathFoto() . ' width=90 height=90 />
                    </td>
                </tr>';
            }
    
            $lista .= "</tbody>
                        </table>";
                    

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                                    'pagenumPrefix' => 'Sagnella Franco, Pagina nro. ',
                                    'nbpgPrefix' => ' de ']);
            
            session_start();
            $pass = $_SESSION['DNIEmpleado'];
            $mpdf->SetProtection(array(), $pass, $pass);
            $mpdf->SetHeader('{PAGENO}{nbpg}');
            $mpdf->setFooter('||<a href="https://sagnella-franco-ezequiel-tpuno.herokuapp.com/">https://sagnella-franco-ezequiel-tpuno.herokuapp.com/</a>');

            $mpdf->WriteHTML("<h3>Listado de Empleados</h3>");
            $mpdf->WriteHTML("<br>");
            $mpdf->WriteHTML($lista);


            $mpdf->Output('ListaEmpleados.pdf', 'I');