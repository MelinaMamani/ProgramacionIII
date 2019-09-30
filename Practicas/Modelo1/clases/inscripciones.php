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

    public static function ConstruirInscripciones($dirFile)
    {
        $lineas = Inscripciones::LeerArchivo($dirFile);
        $Inscripciones = array();
        if($lineas !=NULL)
        {
            foreach($lineas as $linea)
            {
                $datos = explode(",",$linea);
                $Inscripcion = new Inscripciones($datos[2],$datos[3],$datos[4],(int)$datos[0],$datos[1]);
                array_push($Inscripciones,$Inscripcion);
            }
            return $Inscripciones;
        }
    }

    public function MostrarInscripciones()
    {
        echo "<tr><td>".$this->codigo."</td>";
        echo "<td>",$this->materia."</td>";
        echo "<td>",$this->nombre."</td>";
        echo "<td>",$this->apellido."</td>";
        echo "<td>",$this->email."</td></tr>";
    }
    
    public static function Inscripciones($dirFile)
    {
        $Inscripciones = Inscripciones::ConstruirInscripciones($dirFile);
        if($Inscripciones != NULL)
        {
            echo "<table border='1'>
            <tr>
                <th>Codigo</th>
                <th>Materia</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
            </tr>";

            foreach($Inscripciones as $inscripcion)
            {
                $inscripcion->MostrarInscripciones();
            }

            echo "</table>";
        }
    }
    public static function InscripcionesConParam($dirFile,$dato)
    {
        $Inscripciones = Inscripciones::ConstruirInscripciones($dirFile);
        $flag = false;

        echo "<table border='1'>
            <tr>
                <th>Codigo</th>
                <th>Materia</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
            </tr>";

        foreach($Inscripciones as $inscripcion)
        {
            if(($inscripcion->materia == $dato) || ($inscripcion->apellido == $dato))
            {
                $inscripcion->MostrarInscripciones();
                $flag = true;
            }
        }

        echo "</table>";

        if($flag == false)
        {
            echo "<br>La materia o apellido, no es correcta<br>";
        }
    }
}


?>