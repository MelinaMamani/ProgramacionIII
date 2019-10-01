<?php

require_once './clases/usuario.php';

$usuarioM = new Usuario($_POST["legajo"],$_POST["nombre"],$_POST["email"],$_POST["clave"]);

if (isset($_FILES['foto1']) && isset($_FILES['foto2'])) 
{
    $usuarioM->MoverFotos("./img/backup",$usuarioM->legajo,"./archivos/usuarios.txt");

    $foto1 = $usuarioM->GuardarFoto1("./img/fotos");
    $usuarioM->foto1 = $foto1;

    $foto2 = $usuarioM->GuardarFoto2("./img/fotos");
    $usuarioM->foto2 = $foto2;
} 

$usuarioM->ModificarUsuario("./archivos/usuarios.txt");

?>