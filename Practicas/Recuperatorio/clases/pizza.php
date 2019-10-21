<?php

class Pizza
{
    public $precio;
    public $id;
    public $tipo;
    public $sabor;
    public $cantidad;
    
    public function __construct($id,$precio,$tipo,$sabor,$cantidad)
    {
        $this->precio = $precio;
        $this->id = $id;
        $this->tipo = $tipo;
        $this->sabor = $sabor;
        $this->cantidad = $cantidad;
    }

    #region punto1
    public function cargarPizza($dirFile)
    {
        if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$this->id".","."$this->precio".","."$this->tipo".","."$this->sabor".","."$this->cantidad".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
            }
            else
            {
                fwrite($resource, "$this->id".","."$this->precio".","."$this->tipo".","."$this->sabor".","."$this->cantidad".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$this->id".","."$this->precio".","."$this->tipo".","."$this->sabor".","."$this->cantidad".",".trim($this->foto1,"").",".trim($this->foto2,"\r\n"));
        }
        fclose($resource);
        return true;
    }

    public static function ValidarID($id, $dirFile)
    {
        $Pizzas = Pizza::ConstruirPizzas($dirFile);
        if($Pizzas !=NULL)
        {
            foreach($Pizzas as $Pizza)
            {
                if($Pizza->id == $id)
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

    public static function ConstruirPizzas($dirFile)
    {
        $lineas = Pizza::LeerArchivo($dirFile);
        $Pizzas = array();
        if($lineas !=NULL)
        {
            foreach($lineas as $linea)
            {
                $datos = explode(",",$linea);
                $Pizza = new Pizza($datos[0],$datos[1],$datos[2],$datos[3],$datos[4]);
                $Pizza->foto1 = $datos[5];
                $Pizza->foto2 = $datos[6];
                array_push($Pizzas,$Pizza);
            }
            return $Pizzas;
        }
    }

    public function GuardarFoto1($path)
    {
        if(file_exists($_FILES["foto1"]["tmp_name"]))
        {
            $nombreArchivo = "";
            $arrayNombre = explode(".",$_FILES["foto1"]["name"]);
            $nombreArchivo .=  $this->id . '-1.' . $arrayNombre[1];
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
            $nombreArchivo .=  $this->id . '-2.' . $arrayNombre[1];
            $path .= '/' . $nombreArchivo;
            $this->PonerMarcaDeAgua($_FILES["foto2"]["tmp_name"],$path);

            return $path;
        }
    }

    public function MoverFotos($path,$id,$dirFile)
    {
        $Pizzas = Pizza::ConstruirPizzas($dirFile);
        if($Pizzas != NULL)
        {
            foreach($Pizzas as $Pizza)
            {
                if ($Pizza->id == $id) {
                    $foto1 = $Pizza->foto1;
                    $foto2 = $Pizza->foto2;
                    break;
                }
            }
        }
        
        rename();
        move_uploaded_file($arrayNombre1[3],$path);
        move_uploaded_file($arrayNombre2[3],$path);

    }

    private function PonerMarcaDeAgua($archivo,$path)
    {
        $marca = imagecreatefrompng('./img/pizzas/sello.png');
        $imagen = imagecreatefromjpeg($archivo);
        $margenDerecho = 10; 
        $margenIzquierdo = 10; 
        $marcax = imagesx($marca); 
        $marcay = imagesy($marca); 
        imagecopy($imagen, $marca, imagesx($imagen) - $marcax - $margenDerecho, imagesy($imagen) - $marcay - $margenIzquierdo,0,0,$marcax,$marcay);
        imagepng($imagen,$path);
    }
    #endregion

    public static function VerificarPizza($dirFile, $sabor, $tipo)
    {
        $Pizzas = Pizza::ConstruirPizzas($dirFile);
        $flag = false;
        if($Pizzas != NULL)
        {
            foreach($Pizzas as $Pizza)
            {
                if($Pizza->sabor == $sabor && $Pizza->tipo == $tipo)
                {
                    $flag = true;
                    break;
                }
            }
        }
    }

    public function ModificarPizza($dirFile)
    {
        $Pizzas = Pizza::ConstruirPizzas($dirFile);
        $indice = Pizza::BuscarIndiceArray($Pizzas,$this->id);
        if($indice != -1)
        {
            //$Pizzas[$indice]->id = $this->id;
            $Pizzas[$indice]->precio = $this->precio;
            $Pizzas[$indice]->tipo = $this->tipo;
            $Pizzas[$indice]->sabor = $this->sabor;
            Pizza::VaciarArchivo($dirFile);
            foreach($Pizzas as $Pizza)
            {
                $Pizza->cargarPizza($dirFile);
            }
        }
        else
        {
            echo "<br>La Pizza que intenta modificar no se encuentra en la base de datos";
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

    private static function BuscarIndiceArray($Pizzas, $id)
    {
        $indice = -1;
        for($i = 0; $i < count($Pizzas); $i++)
        {
            if($Pizzas[$i]->id == $id)
            {
                $indice = $i;
            }
        }
        return $indice;
    }

    
}


?>