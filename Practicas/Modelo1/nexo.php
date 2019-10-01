<?php

$caso = $_GET['caso'];

switch ($caso) {
    case 'cargarAlumno':
        include_once 'cargarAlumno.php';
        break;

    case 'consultarAlumno':
        include_once 'consultarAlumno.php';
        break;

    case 'cargarMateria':
        include_once 'cargarMateria.php';
        break;

    case 'inscribirAlumno':
        include_once 'inscribirAlumno.php';
        break;

    case 'inscripciones':
        include_once 'inscripciones.php';
        break;

    case 'modificarAlumno':
        include_once 'modificarAlumno.php';
        break;

    case 'alumnos':
        include_once 'alumnos.php';
        break;

    default:
        echo "No existe este caso.";
        break;
}

?>
