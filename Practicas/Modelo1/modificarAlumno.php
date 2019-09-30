<?php

require_once './clases/alumno.php';

$alumnoM = new Alumno($_POST["apellido"],$_POST["nombre"],$_POST["email"]);
$alumnoM->ModificarAlumno("./archivos/alumnos.txt");

?>