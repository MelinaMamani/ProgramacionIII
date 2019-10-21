<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/usuario.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/cargarUsuario', function (Request $request, Response $response) {    
    $campos = $request->getParsedBody();
    $obj = new stdClass();
    $obj->estado = "No se da de alta.";

    $usuario = new usuario($campos["legajo"],$campos["nombre"],$campos["email"],$campos["clave"]);

    if((Usuario::ValidarLegajo($campos["legajo"],"./archivos/usuarios.txt"))!=-1)
    {
        $foto1 = $usuario->GuardarFoto1("./img/fotos");
        $usuario->foto1 = $foto1;

        $foto2 = $usuario->GuardarFoto2("./img/fotos");
        $usuario->foto2 = $foto2;

        if($usuario->cargarUsuario("./archivos/usuarios.txt"))
        {
            $obj->estado = "Se da de alta.";
        }
    }
    else
    {
        $obj->estado = "El usuario ya está dado de alta.";
    }

    $newResponse = $response->withJson($obj,200);
    return $newResponse;
});

$app->group('/grupo', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("API=> GET");
        return $response;
    });
    
    $this->post('/', function ($request, $response) {    
        $campos = $request->getParsedBody();
        $obj = new stdClass();
        $obj->nombre = $campos['nombre'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    
    });

    $this->put('/', function ($request, $response) {    
        $campos = $request->getParsedBody();
        $obj = new stdClass();
        $obj->id = $campos['id'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    });
    
    $this->delete('/', function ($request, $response) {    
        //$response->getBody()->write("API => DELETE");
        $campos = $request->getParsedBody();
        $obj = new stdClass();
        $obj->id = $campos['id'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    
    });
});

$app->run();
?>