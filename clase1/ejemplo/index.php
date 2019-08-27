<?php 

include './funcion.php';
require_once './funcion.php';
require_once './clases/persona.php';
require_once './clases/alumno.php';

echo "Hola PHP<br/>";

Saludar("Nayeon");

$persona = new Persona("Peppa",1736727);
$persona->Saludar();

$alumno = new Alumno("Pepe",1736447,888888,"4to");
$alumno->Saludar();

?>