<?php

class Persona
{
    public $nombre;
    public $dni;

    #Parametros opcionales como en la siguiente linea
    public function __construct($nombre = "",$dni = 0)
    {
        $this->nombre = $nombre;
        $this->dni = $dni;
    }

    public function Saludar()
    {
        echo "Hola soy ".$this->nombre."<br/>con DNI ".$this->dni."<br/>";
    }
}



?>