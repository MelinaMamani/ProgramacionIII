<?php

require_once "./clases/alumno.php";
Alumno::ConsultarAlumno("./archivos/alumnos.txt",$_GET["apellido"]);

?>