<?php

abstract class FiguraGeometrica
{
    protected $perimetro;
    protected $superficie;

    function __construct()
    {
        $this->perimetro = 0;
        $this->superficie = 0;
    }

    public function toString()
    {
        return "Perimetro: $this->perimetro - Superficie: $this->superficie";
    }

    public abstract function calcularDatos();
    public abstract function dibujar();

}

class Rectangulo extends FiguraGeometrica
{
    private $ladoUno;
    private $ladoDos;

    function __construct($l1, $l2)
    {
        parent::__construct();
        $this->ladoUno = $l1;
        $this->ladoDos = $l2;
        $this->calcularDatos();
    }

    public function calcularDatos()
    {
        $this->perimetro = $this->ladoUno*2 + $this->ladoDos*2;
        $this->superficie = $this->ladoUno * $this->ladoDos;
    }

    public function dibujar()
    {
        return "*******<br/>*******<br/>*******<br/>";
    }

    function toString()
    {
        return parent :: toString() . " Es un rectangulo<br/>" . $this->dibujar();
    }
}

class Triangulo extends FiguraGeometrica
{
    private $base;
    private $altura;

    function __construct($b, $a)
    {
        parent::__construct();
        $this->base = $b;
        $this->altura = $a;
        $this->calcularDatos();
    }

    public function calcularDatos()
    {
        $this->perimetro = $this->base + (sqrt(pow($this->base/2, 2)+pow($this->altura, 2)) * 2);
        $this->superficie = ($this->base * $this->altura) / 2;
    }

    public function dibujar()
    {
        return "   *   <br/> *** <br/>*****<br/>";
    }

    function toString()
    {
        return parent :: toString() . " Es un striangulo<br/>" . $this->dibujar();
    }
}

$rectangulo = new Rectangulo(4, 5);
$triangulo = new Triangulo(4, 8);

echo $rectangulo->toString();
echo $triangulo->toString();