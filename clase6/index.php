<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$guardar = function ($request, $response, $next)
{
    if(file_exists("./info.log"))
        {
            $resource = fopen("./info.log","a");
            if(file_get_contents("./info.log") != "")
            {
                fwrite($resource, "\r\n".$_SERVER['REQUEST_METHOD'].",".$_SERVER['REQUEST_URI'].",".date("Y-m-d").",".$_SERVER['REMOTE_ADDR']);
            }
            else
            {
                fwrite($resource, $_SERVER['REQUEST_METHOD'].",".$_SERVER['REQUEST_URI'].",".date('Y-m-d').",".$_SERVER['REMOTE_ADDR']);
            }
        }
        else
        {
            $resource = fopen("./info.log","w");
            fwrite($resource, $_SERVER['REQUEST_METHOD'].",".$_SERVER['REQUEST_URI'].",".date('Y-m-d').",".$_SERVER['REMOTE_ADDR']);
        }
        $response = $next($request,$response);
        fclose($resource);
        return $response;
};

$md1 = function ($request, $response, $next){
    $response->getBody()->write("Antes de ejecutar md1...");
    $response = $next($request,$response);
    $response->getBody()->write("...Despues de ejecutar md1");
    return $response;
};

$app->add($guardar);

$app->group('/usuario', function (){
    $this->get('/', function ($request, $response) {    
        $response->getBody()->write("GET usuario");
        return $response;
    });
    
    $this->post('/', function ($request, $response) {    
        $response->getBody()->write("POST usuario");
        return $response;
    
    });

    $this->put('/', function ($request, $response) {    
        $response->getBody()->write("PUT usuario");
        return $response;
    });
    
    $this->delete('/', function ($request, $response) {    
        $response->getBody()->write("DELETE usuario");
        return $response;
    
    });
});

$app->post('/Crear',function (Request $request, Response $response){
    $datos = $request->getParsedBody();
    $ahora = time();
    $user =  new stdClass();
    $user->dni = $datos['dni'];
    
    $payload = array('iat' => $ahora,
    //'exp' => $ahora+(30),
    'data' => $user,
    'app' => "token"
    );
    $token = JWT::encode($payload,"unUsuario");
    return $response->withJSON($token,200);
});

$app->post('/Verificar',function (Request $request, Response $response){
    $arrayDeParam = $request->getParsedBody();
    $token = $arrayDeParam['token'];
    if (empty($token) || $token === "") {
        throw new Exception("Token vacío");
    }
    try{
        $decodificado = JWT::decode($token,"unUsuario",['HS256']);
    }
    catch(Exception $e)
    {
        throw new Exception("Ocurrió un error con el token". $e->getMessage());
        
    }
    return "0k= ".$decodificado;
});

$app->run();
?>