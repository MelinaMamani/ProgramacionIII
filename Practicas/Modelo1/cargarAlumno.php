<?php

require_once './clases/alumno.php';

$alumno = new Alumno($_POST["apellido"],$_POST["nombre"],$_POST["email"]);
if((Alumno::ValidarEmail($_POST["email"],"./archivos/alumnos.txt"))!=-1)
{
    $foto = $alumno->GuardarFoto("./Fotos");
    $alumno->foto = $foto;
    if($alumno->cargarAlumno("./archivos/alumnos.txt"))
    {
        echo "<br>El alumno se ha cargado.</br>";
    }
}
else
{
    echo "<br>El Alumno ya se encuentra en la base de datos";
}

?>