<?php
function conectarDB() {
    
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $baseDatos = "parking_management"; 
    $puerto = 3307; 

 
    $conexion = new mysqli($servidor, $usuario, $contrasena, $baseDatos, $puerto);

   
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}
?>
