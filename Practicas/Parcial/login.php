<?php

require_once './clases/usuario.php';

Usuario::VerificarUsuario("./archivos/usuarios.txt",$_GET["legajo"],$_GET["clave"]);

?>