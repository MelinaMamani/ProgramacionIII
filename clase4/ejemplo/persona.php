<?php

class Persona
{
    public $nombre;
    public $apellido;
    public $legajo;
    public $img;

    #Parametros opcionales como en la siguiente linea
    public function __construct($nombre,$apellido,$legajo, $img)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->legajo = $legajo;
        $this->img = $img;
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

    public function ToString()
    {
        return $this->legajo."-".$this->apellido."-".$this->nombre."-".$this->img."\r\n";
    }

    static function Agregar($persona)
    {
        $archivo = fopen("ingresantes.txt","a");
        $cant = fwrite($archivo,$persona->ToString());
        if ($cant > 0) {
            return true;
        }
        fclose($archivo);
    }
    static function TraerTodos()
    {
        $archivo = fopen("ingresantes.txt","r");
        $personas[] = array();
        
        while (!(feof($archivo))) {
            $datos = fgets($archivo);
            $datoEmp = explode("-",$datos);
            
            $persona = new Persona($datoEmp[2],$datoEmp[1],$datoEmp[0],$datoEmp[3]);
            array_push($personas,$persona);
        }
        fclose($archivo);
        return $personas;
    }
}



?>
