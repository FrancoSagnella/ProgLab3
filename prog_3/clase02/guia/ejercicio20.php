<?php

class Rectangulo
{
    private $vertice1;
    private $vertice2;
    private $vertice3;
    private $vertice4;
    public $area;
    public $ladoUno;
    public $ladoDos;
    public $perimetro;

    public function __construct($v1, $v3)
    {
        $this->vertice1 = $v1;
        $this->vertice3 = $v3;
        $this->vertice2 = new Punto($v3->getX(), $v1->getY());
        $this->vertice4 = new Punto($v1->getX(), $v3->getY());

        //Tengo que restarle al que tiene el vertice mas grande, el mas chico
        //Por eso tengo que compararlo asi
        if ($this->vertice1->getY() > $this->vertice4->getY()) {
            $this->ladoUno = ($this->vertice1->getY()) - ($this->vertice4->getY());
        } else {
            $this->ladoUno = ($this->vertice4->getY()) - ($this->vertice1->getY());
        }

        if ($this->vertice2->getX() > $this->vertice1->getX()) {
            $this->ladoDos = ($this->vertice2->getX()) - ($this->vertice1->getX());
        } else {
            $this->ladoDos = ($this->vertice1->getX()) - ($this->vertice2->getX());
        }
        

        $this->area = $this->ladoUno * $this->ladoDos;
        $this->perimetro = $this->ladoUno * 2 + $this->ladoDos * 2;
    }

    function dibujar()
    {
        $cadena = "";
        for ($i = 0; $i < $this->ladoUno; $i++) {
            for ($j = 0; $j < $this->ladoDos; $j++) {
                $cadena .= "*";
            }
            $cadena .= "<br/>";
        }
        return $cadena;
    }
}

class Punto
{
    private $_x;
    private $_y;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function getX()
    {
        return $this->_x;
    }

    public function getY()
    {
        return $this->_y;
    }
}

$punto1 = new Punto(1, 1);
$punto2 = new Punto(30, 30);
$rectangulo = new Rectangulo($punto1, $punto2);

echo $rectangulo->dibujar();
