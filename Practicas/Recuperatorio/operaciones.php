<?php

require_once './clases/pizza.php';

class Operaciones
{
    public static function nuevoValor($id)
    {
        return $id;
    }

    public static function altaPizza($request,$response)
    {
        $elemento = count(Pizza::ConstruirPizzas("./archivos/pizzas.txt"));
        $id = $elemento+1;
        $campos = $request->getParsedBody();
        $obj = new stdClass();
        $obj->estado = "No se da de alta.";
        $Pizzas = Pizza::ConstruirPizzas("./archivos/pizzas.txt");

        $pizza = new Pizza($id,$campos["precio"],$campos["tipo"],$campos["sabor"],$campos["cantidad"]);
        
        if((Pizza::VerificarPizza("./archivos/pizzas.txt",$campos["sabor"],$campos["tipo"])))
        {
            $obj->estado = "La pizza ya está dada de alta.";            
        }
        else
        {
            $foto1 = $pizza->GuardarFoto1("./img/pizzas");
            $pizza->foto1 = $foto1;

            $foto2 = $pizza->GuardarFoto2("./img/pizzas");
            $pizza->foto2 = $foto2;

            if($pizza->cargarPizza("./archivos/pizzas.txt"))
            {
                $obj->estado = "Se da de alta.";
            }
        }

        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    }
    
    public static function consultaPizza($request,$response)
    {
        $campos = $request->getParsedBody();
        $obj = new stdClass();
        $obj->estado = "No existe la combinacion.".$campos["sabor"]."o".$campos["tipo"];
        $cant = Pizza::RetornarCant("./archivos/pizzas.txt",$campos["sabor"],$campos["tipo"]);

        if($cant != 0)
        {
            $obj->estado = "La pizza fue encontrada.";
            $obj->suCantidadEs = $cant;            
        }

        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    }
}


?>