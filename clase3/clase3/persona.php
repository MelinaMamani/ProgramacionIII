<?php

class Persona
{
    public $nombre;
    public $apellido;

    #Parametros opcionales como en la siguiente linea
    public function __construct($nombre = "",$apellido = "",$legajo = 0)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->legajo = $legajo;
    }

    public function GuardarJson()
    {
        $archivo = fopen("personas.json","a");
        $persona = new stdClass();
        $persona->apellido = $this->apellido;
        $persona->nombre = $this->nombre;
        $persona->legajo = $this->legajo;

        $escritura = json_encode($persona);
        $texto = fwrite($archivo,$escritura);
    }

}



?>