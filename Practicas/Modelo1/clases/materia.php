<?php

class Materia
{
    public $nombre;
    public $codigo;
    public $cupo;
    public $aula;
    
    public function __construct($codigo,$nombre,$cupo,$aula)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->cupo = $cupo;
        $this->aula = $aula;
    }

    public function cargarMateria($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$this->codigo".","."$this->nombre".","."$this->cupo".","."$this->aula");
            }
            else
            {
                fwrite($resource, "$this->codigo".","."$this->nombre".","."$this->cupo".","."$this->aula");
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$this->codigo".","."$this->nombre".","."$this->cupo".","."$this->aula");
        }
        fclose($resource);
        return true;
    }

    public static function ValidarCodigo($codigo, $dirFile)
    {
        $Materias = Materia::ConstruirMaterias($dirFile);
        if($Materias !=NULL)
        {
            foreach($Materias as $Materia)
            {
                if($Materia->codigo == $codigo)
                {
                  return -1;  
                }
            }
        }
        return 0;
    }

    public static function LeerArchivo($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"r");
            $vectorArchivo = array();
            do
            {
                array_push($vectorArchivo,fgets($resource));
            }while(!(feof($resource)));
            return $vectorArchivo;
        }
    }

    public static function ConstruirMaterias($dirFile)
    {
        $lineas = Materia::LeerArchivo($dirFile);
        $Materias = array();
        if($lineas !=NULL)
        {
            foreach($lineas as $linea)
            {
                $datos = explode(",",$linea);
                $Materia = new Materia((int)$datos[0],$datos[1],(int)$datos[2],(int)$datos[3]);
                array_push($Materias,$Materia);
            }
            return $Materias;
        }
    }
}


?>