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

    public static function VerificarMateria($codigo, $dirFile)
    {
        $Materias = Materia::ConstruirMaterias($dirFile);
        if($Materias !=NULL)
        {
            foreach($Materias as $Materia)
            {
                if($Materia->codigo == $codigo)
                {
                    $Materia = new Materia((int)$Materia->codigo,$Materia->nombre,(int)$Materia->cupo,(int)$Materia->aula);
                    break;
                }
            }
        }
        return $Materia;
    }

    public function ModificarMateria($dirFile)
    {
        $materias = Materia::ConstruirMaterias($dirFile);
        $indice = Materia::BuscarIndiceArray($materias,$this->codigo);
        if($indice != -1)
        {
            $cupo = ((int)$this->cupo) - 1;
            $materias[$indice]->cupo = $cupo;
            materia::VaciarArchivo($dirFile);
            foreach($materias as $materia)
            {
                $materia->cargarMateria($dirFile);
            }
        }
        else
        {
            echo "<br>La materia que intenta modificar no se encuentra en la base de datos";
        }
    }

    private static function BuscarIndiceArray($materias, $codigo)
    {
        $indice = -1;
        for($i = 0; $i < count($materias); $i++)
        {    
            if($materias[$i]->codigo == $codigo)
            {
                $indice = $i; 
            }
        }
        return $indice;
    }

    private static function VaciarArchivo($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"w");
            fclose($resource);   
        }
    }
}


?>