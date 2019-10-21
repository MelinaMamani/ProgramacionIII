<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './operaciones.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/pizzas', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("API=> GET");
        return $response;
    });
    
    $this->post('/', \operaciones::class . ':altaPizza');
});

$app->run();
?>