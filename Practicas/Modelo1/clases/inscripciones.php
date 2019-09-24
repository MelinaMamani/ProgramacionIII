<?php 

class Inscripciones
{
    public $apellido;
    public $nombre;
    public $email;
    public $codigo;
    public $materia;

    public function __construct($apellido,$nombre,$email,$codigo,$materia)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->codigo = $codigo;
        $this->materia = $materia;
    }

    public function cargarInscripcion($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$this->codigo".","."$this->materia".","."$this->apellido".","."$this->nombre".","."$this->email");
            }
            else
            {
                fwrite($resource, "$this->codigo".","."$this->materia".","."$this->apellido".","."$this->nombre".","."$this->email");
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$this->codigo".","."$this->materia".","."$this->apellido".","."$this->nombre".","."$this->email");
        }
        fclose($resource);
        return true;
    }
}


?>