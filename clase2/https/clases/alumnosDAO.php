<?php

require_once 'alumno.php';

class AlumnoDAO extends Alumno
{
    
    public static function Guardar($alumno)
    {
        $unAlumno = new Alumno($alumno['nombre'],$alumno['dni'],$alumno['legajo']);
        echo "Guardado alumno ".$unAlumno->legajo;
    }

    public static function Listar($alumnoJSON)
    {
        echo json_encode($alumnoJSON);
    }

    public static function Modificar($legajo)
    {
        echo "Modificado: ".$legajo;
    }
}


?>