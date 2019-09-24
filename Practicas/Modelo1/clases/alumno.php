<?php

class Alumno
{
    public $nombre;
    public $apellido;
    public $email;
    
    public function __construct($apellido,$nombre,$email)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
    }

    #region punto1
    public function cargarAlumno($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$this->apellido".","."$this->nombre".","."$this->email".",".trim($this->foto,"\r\n"));
            }
            else
            {
                fwrite($resource, "$this->apellido".","."$this->nombre".","."$this->email".",".trim($this->foto,"\r\n"));
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$this->apellido".","."$this->nombre".","."$this->email".",".trim($this->foto,"\r\n"));
        }
        fclose($resource);
        return true;
    }

    public static function ValidarEmail($email, $dirFile)
    {
        $Alumnos = Alumno::ConstruirAlumnos($dirFile);
        if($Alumnos !=NULL)
        {
            foreach($Alumnos as $Alumno)
            {
                if($Alumno->email == $email)
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

    public static function ConstruirAlumnos($dirFile)
    {
        $lineas = Alumno::LeerArchivo($dirFile);
        $Alumnos = array();
        if($lineas !=NULL)
        {
            foreach($lineas as $linea)
            {
                $datos = explode(",",$linea);
                $Alumno = new Alumno($datos[0],$datos[1],$datos[2]);
                $Alumno->foto = $datos[3];
                array_push($Alumnos,$Alumno);
            }
            return $Alumnos;
        }
    }

    public function GuardarFoto($path)
    {
        if(file_exists($_FILES["foto"]["tmp_name"]))
        {
            $nombreArchivo = "";
            $arrayNombre = explode(".",$_FILES["foto"]["name"]);
            $nombreArchivo .=  $this->apellido . $this->nombre . '.' . $arrayNombre[1];
            $path .= '/' . $nombreArchivo;
            if(file_exists($path))
            {
                $this->ReemplazarFoto("./backUpFotos",$path);
            }
            else
            {
                $this->PonerMarcaDeAgua($_FILES["foto"]["tmp_name"],$path);
            }
            return $path;
        }
    }

    private function ReemplazarFoto($pathBackup,$FotoExistente)
    {
        $nombreArchivo = "";
        $arrayNombre = explode(".",$FotoExistente);
        date_default_timezone_set('America/Argentina/Buenos_Aires'); //Seteo la zona horaria para que al imprimir la hora sea la hora local de argentina
        $fecha = date("d\-m\-y--H\.i\.s"); //Recibo la hora en formato dia-Mes-Año--Hora.Minuto.Seugndo
        $nombreArchivo .= $this->apellido . "_" . $fecha . '.' . $arrayNombre[2]; //Creo el nombre del archivo con el Legajo, nombre, fecha y extension
        $pathBackup .= '/' . $nombreArchivo;        
        rename($FotoExistente,$pathBackup); //Muevo la foto a archivos Backup 
    }

    private function PonerMarcaDeAgua($archivo,$path)
    {
        $marca = imagecreatefrompng('./Fotos/sello.png');
        $imagen = imagecreatefromjpeg($archivo);
        $margenDerecho = 10; 
        $margenIzquierdo = 10; 
        $marcax = imagesx($marca); 
        $marcay = imagesy($marca); 
        imagecopy($imagen, $marca, imagesx($imagen) - $marcax - $margenDerecho, imagesy($imagen) - $marcay - $margenIzquierdo,0,0,$marcax,$marcay);
        imagepng($imagen,$path);
    }
    #endregion

    public static function ConsultarAlumno($dirFile, $apellido)
    {
        $Alumnos = Alumno::ConstruirAlumnos($dirFile);
        $flag = false;
        if($Alumnos != NULL)
        {
            foreach($Alumnos as $Alumno)
            {
                if($Alumno->apellido == $apellido)
                {
                    $Alumno->MostrarAlumno();
                    $flag = true;
                }
            }
            if($flag == false)
            {
                echo "No existe Alumno ",$nombre;
            }
        }
    }

    public function MostrarAlumno()
    {
        echo "<br>Apellido: ",$this->apellido;
        echo "<br>Nombre: ",$this->nombre;
        echo "<br>Email: ",$this->email;
        echo "<br>Foto: ",$this->foto;
        echo "<br>";
    }

    public static function AlumnosMostrar($dirFile)
    {
        $Alumnos = Alumno::ConstruirAlumnos($dirFile);
        foreach($Alumnos as $Alumno)
        {
            $Alumno->MostrarAlumno();
        }
    }
}


?>