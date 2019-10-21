<?php

class Usuario
{
    public $nombre;
    public $legajo;
    public $email;
    public $clave;
    
    public function __construct($legajo,$nombre,$email,$clave)
    {
        $this->nombre = $nombre;
        $this->legajo = $legajo;
        $this->email = $email;
        $this->clave = $clave;
    }

    #region punto1
    public function cargarUsuario($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$this->legajo".","."$this->nombre".","."$this->email".","."$this->clave".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
            }
            else
            {
                fwrite($resource, "$this->legajo".","."$this->nombre".","."$this->email".","."$this->clave".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$this->legajo".","."$this->nombre".","."$this->email".","."$this->clave".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
        }
        fclose($resource);
        return true;
    }

    public static function ValidarLegajo($legajo, $dirFile)
    {
        $Usuarios = Usuario::ConstruirUsuarios($dirFile);
        if($Usuarios !=NULL)
        {
            foreach($Usuarios as $Usuario)
            {
                if($Usuario->legajo == $legajo)
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

    public static function ConstruirUsuarios($dirFile)
    {
        $lineas = Usuario::LeerArchivo($dirFile);
        $Usuarios = array();
        if($lineas !=NULL)
        {
            foreach($lineas as $linea)
            {
                $datos = explode(",",$linea);
                $Usuario = new Usuario($datos[0],$datos[1],$datos[2],$datos[3]);
                $Usuario->foto1 = $datos[4];
                $Usuario->foto2 = $datos[5];
                array_push($Usuarios,$Usuario);
            }
            return $Usuarios;
        }
    }

    public function GuardarFoto1($path)
    {
        if(file_exists($_FILES["foto1"]["tmp_name"]))
        {
            $nombreArchivo = "";
            $arrayNombre = explode(".",$_FILES["foto1"]["name"]);
            $nombreArchivo .=  $this->legajo . '-1.' . $arrayNombre[1];
            $path .= '/' . $nombreArchivo;
            $this->PonerMarcaDeAgua($_FILES["foto1"]["tmp_name"],$path);
            return $path;
        }
    }

    public function GuardarFoto2($path)
    {
        if(file_exists($_FILES["foto2"]["tmp_name"]))
        {
            $nombreArchivo = "";
            $arrayNombre = explode(".",$_FILES["foto2"]["name"]);
            $nombreArchivo .=  $this->legajo . '-2.' . $arrayNombre[1];
            $path .= '/' . $nombreArchivo;
            $this->PonerMarcaDeAgua($_FILES["foto2"]["tmp_name"],$path);

            return $path;
        }
    }

    public function MoverFotos($path,$legajo,$dirFile)
    {
        $Usuarios = Usuario::ConstruirUsuarios($dirFile);
        if($Usuarios != NULL)
        {
            foreach($Usuarios as $usuario)
            {
                if ($usuario->legajo == $legajo) {
                    $foto1 = $usuario->foto1;
                    $foto2 = $usuario->foto2;
                    break;
                }
            }
        }
        
        //$arrayNombre1 = explode("/",$foto1);
        //$arrayNombre2 = explode("/",$foto2);

        rename();
        move_uploaded_file($arrayNombre1[3],$path);
        move_uploaded_file($arrayNombre2[3],$path);

    }

    private function PonerMarcaDeAgua($archivo,$path)
    {
        $marca = imagecreatefrompng('./img/fotos/sello.png');
        $imagen = imagecreatefromjpeg($archivo);
        $margenDerecho = 10; 
        $margenIzquierdo = 10; 
        $marcax = imagesx($marca); 
        $marcay = imagesy($marca); 
        imagecopy($imagen, $marca, imagesx($imagen) - $marcax - $margenDerecho, imagesy($imagen) - $marcay - $margenIzquierdo,0,0,$marcax,$marcay);
        imagepng($imagen,$path);
    }
    #endregion

    public static function VerificarUsuario($dirFile, $legajo, $clave)
    {
        $Usuarios = Usuario::ConstruirUsuarios($dirFile);
        $flag = false;
        if($Usuarios != NULL)
        {
            foreach($Usuarios as $Usuario)
            {
                if($Usuario->legajo == $legajo && $Usuario->clave == $clave)
                {
                    echo json_encode($Usuario);
                    $flag = true;
                }
            }
            if($flag == false)
            {
                echo "No existe Usuario ",$nombre;
            }
        }
    }

    public function ModificarUsuario($dirFile)
    {
        $Usuarios = Usuario::ConstruirUsuarios($dirFile);
        $indice = Usuario::BuscarIndiceArray($Usuarios,$this->legajo);
        if($indice != -1)
        {
            //$Usuarios[$indice]->legajo = $this->legajo;
            $Usuarios[$indice]->nombre = $this->nombre;
            $Usuarios[$indice]->email = $this->email;
            $Usuarios[$indice]->clave = $this->clave;
            Usuario::VaciarArchivo($dirFile);
            foreach($Usuarios as $Usuario)
            {
                $Usuario->cargarUsuario($dirFile);
            }
        }
        else
        {
            echo "<br>El Usuario que intenta modificar no se encuentra en la base de datos";
        }
    }

    private static function VaciarArchivo($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"w");
            fclose($resource);
        }
    }

    private static function BuscarIndiceArray($Usuarios, $legajo)
    {
        $indice = -1;
        for($i = 0; $i < count($Usuarios); $i++)
        {
            if($Usuarios[$i]->legajo == $legajo)
            {
                $indice = $i;
            }
        }
        return $indice;
    }

}


?>