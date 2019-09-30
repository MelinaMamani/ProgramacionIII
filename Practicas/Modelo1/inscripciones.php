<?php

require_once './clases/inscripciones.php';

echo "<h1>Tabla de inscripciones</h1>";

if (isset($_GET['dato'])) 
{
    Inscripciones::InscripcionesConParam("./archivos/inscripciones.txt",$_GET['dato']);
} 

else 
{
    Inscripciones::Inscripciones("./archivos/inscripciones.txt");
}


?>