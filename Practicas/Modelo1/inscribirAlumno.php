<?php

require_once './clases/materia.php';
require_once './clases/inscripciones.php';

$inscripcion = new Inscripciones((int)$_POST["codigo"],$_POST["materia"],$_POST["apellido"],$_POST["nombre"],$_POST["email"]);
if((Materia::ValidarCodigo($_POST["codigo"],"./archivos/materias.txt"))==-1)
{
    $materia = Materia::VerificarMateria($_POST["codigo"],"./archivos/materias.txt");

    if ($materia->cupo > 0) 
    {
        if($inscripcion->cargarInscripcion("./archivos/inscripciones.txt"))
        {
            $materia->ModificarMateria("./archivos/materias.txt");
            echo "<br>La inscripción se ha realizado.</br>";
        }
    } 
    
    else {
        echo "<br>Ya no hay cupo para la materia.</br>";
    }
    
}
else
{
    echo "<br>La materia no existe.</br>";
}



//echo json_encode($materia);

?>