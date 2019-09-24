<?php

require_once './clases/inscripciones.php';

$inscripcion = new Inscripciones($_POST["apellido"],$_POST["nombre"],$_POST["email"],(int)$_POST["codigo"],$_POST["materia"]);
if((Inscripciones::ValidarEmail($_POST["email"],"./archivos/inscripcions.txt"))!=-1)
{
    $foto = $inscripcion->GuardarFoto("./Fotos");
    $inscripcion->foto = $foto;
    if($inscripcion->cargarinscripcion("./archivos/inscripcions.txt"))
    {
        echo "<br>La inscripcion se ha cargado.</br>";
    }
}
else
{
    echo "<br>La inscripcion ya se encuentra en la base de datos";
}

?>