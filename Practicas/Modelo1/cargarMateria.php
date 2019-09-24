<?php

require_once './clases/materia.php';

$Materia = new Materia((int)$_POST["codigo"],$_POST["nombre"],(int)$_POST["cupo"],(int)$_POST["aula"]);
if((Materia::ValidarCodigo($_POST["codigo"],"./archivos/materias.txt"))!=-1)
{
    if($Materia->cargarMateria("./archivos/materias.txt"))
    {
        echo "<br>La Materia se ha cargado.</br>";
    }
}
else
{
    echo "<br>La Materia ya se encuentra en la base de datos";
}

?>