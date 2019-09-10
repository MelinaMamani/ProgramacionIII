<?php

/*$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$escritura = $nombre."-".$apellido.""; //"\r\n"

$archivo = fopen("onda.txt","a");

$texto = fwrite($archivo,$escritura.PHP_EOL);

*/

$archivo = fopen("onda.txt","r");

$nombres = array();

$alumno = new stdClass();

while (!feof($archivo)) {
    $linea = fgets($archivo);

    $names = explode("-",$linea);
    $limpio = explode("\r\n",$names);

    if (!(explode("-",$linea) == "")) {
        array_push($nombres,$limpio);
    }
    
}

$nombresJson = json_encode($nombres);

echo $nombresJson;

//var_dump($nombres);

fclose($archivo);

?>