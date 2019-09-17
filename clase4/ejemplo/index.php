<?php

require_once 'persona.php';

$legajo = $_POST['legajo'];
$apellido = $_POST['apellido'];
$nombre = $_POST['nombre'];

$archivoTMP = $_FILES['imagen']['tmp_name'];
$nombreIMG = $_FILES['imagen']['name'];
$ext = pathinfo($nombreIMG, PATHINFO_EXTENSION);
$nuevoNombre = "./img/".$legajo.".".$ext;

$persona = new Persona($nombre,$apellido,$legajo,$nuevoNombre);

if(Persona::Agregar($persona))
    move_uploaded_file($archivoTMP,$nuevoNombre);
    echo "Se guardó el usuario ".$persona->ToString();

?>