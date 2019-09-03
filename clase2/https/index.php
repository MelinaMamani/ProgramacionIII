<?php

require_once 'clases/persona.php';
require_once 'clases/alumno.php';
require_once 'clases/alumnosDAO.php';


if($_SERVER['REQUEST_METHOD'] == "GET")
{
    if(isset($_GET['nombre'], $_GET['dni'], $_GET['legajo']))
    {
        $alumnoJSON = new stdClass;
        $alumnoJSON->nombre = $_GET['nombre'];
        $alumnoJSON->dni = $_GET['dni'];
        $alumnoJSON->legajo = $_GET['legajo'];

        AlumnoDAO::Listar($alumnoJSON);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
    if(isset($_POST['nombre'], $_POST['dni'], $_POST['legajo']))
    {
        $alumno = $_POST;
        AlumnoDAO::Guardar($alumno);
    }
} 

if ($_SERVER['REQUEST_METHOD'] == "PUT") 
{
    parse_str(file_get_contents("php://input"),$post_vars);
    if (isset($post_vars['legajo'])) {
       $legajo = $post_vars['legajo'];
       AlumnoDAO::Modificar($legajo);
    }
}
?>