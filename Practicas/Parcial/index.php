<?php

$ip = $_SERVER['REMOTE_ADDR'];
$hora = date("H:i:s");

$caso = $_GET['caso'];

switch ($caso) {
    case 'cargarUsuario':
        include_once 'cargarUsuario.php';
        GuardarInfo("./archivos/info.log",$ip,$hora,$caso);
        break;

    case 'login':
        include_once 'login.php';
        GuardarInfo("./archivos/info.log",$ip,$hora,$caso);
        break;
    
    case 'modificarUsuario':
        include_once 'modificarUsuario.php';
        GuardarInfo("./archivos/info.log",$ip,$hora,$caso);
        break;

    default:
        echo "No existe este caso.";
        break;
}

 function GuardarInfo($dirFile,$ip,$hora,$caso)
{
    if(file_exists($dirFile))
        {
            $resource = fopen($dirFile,"a");
            if(file_get_contents($dirFile) != "")
            {
                fwrite($resource, "\r\n"."$caso".","."$hora".","."$ip");
            }
            else
            {
                fwrite($resource, "$caso".","."$hora".","."$ip");
            }
        }
        else
        {
            $resource = fopen($dirFile,"w");
            fwrite($resource, "$caso".","."$hora".","."$ip");
        }
        fclose($resource);
        return true;
}

?>