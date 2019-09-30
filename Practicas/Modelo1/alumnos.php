<?php

require_once './clases/alumno.php';

echo "<h1>Tabla de alumnos</h1>";

Alumno::AlumnosEnTabla("./archivos/alumnos.txt");

?>