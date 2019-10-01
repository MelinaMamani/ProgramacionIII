<?php

require_once './clases/usuario.php';

$usuario = new usuario($_POST["legajo"],$_POST["nombre"],$_POST["email"],$_POST["clave"]);


if((Usuario::ValidarLegajo($_POST["legajo"],"./archivos/usuarios.txt"))!=-1)
{
    $foto1 = $usuario->GuardarFoto1("./img/fotos");
    $usuario->foto1 = $foto1;

    $foto2 = $usuario->GuardarFoto2("./img/fotos");
    $usuario->foto2 = $foto2;

    if($usuario->cargarUsuario("./archivos/usuarios.txt"))
    {
        echo "<br>El usuario se ha cargado.</br>";
    }
}
else
{
    echo "<br>El usuario ya se encuentra en la base de datos";
}

?>