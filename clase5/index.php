<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->get('/', function (Request $request, Response $response) {    
    $response->withStatus(200)->write("GET => Bienvenido!!! a SlimFramework");
    return $response;
});

$app->post('/', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;
});
$app->put('/', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;
});
$app->delete('/', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;
});

$app->group('/grupo', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("API=> GET");
        return $response;
    });
    
    $this->post('/', function ($request, $response) {    
        $p = $request->getParsedBody();
        $obj = new stdClass();
        $obj->nombre = $p['nombre'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    
    });

    $this->put('/', function ($request, $response) {    
        $p = $request->getParsedBody();
        $obj = new stdClass();
        $obj->id = $p['id'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    });
    
    $this->delete('/', function ($request, $response) {    
        //$response->getBody()->write("API => DELETE");
        $p = $request->getParsedBody();
        $obj = new stdClass();
        $obj->id = $p['id'];
        $newResponse = $response->withJson($obj,200);
        return $newResponse;
    
    });
});

$app->run();
?>