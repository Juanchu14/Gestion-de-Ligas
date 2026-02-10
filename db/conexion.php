<?php
$servidor = "localhost";    
$usuario  = "root";         
$password = "";             
$base_datos = "gestion_ligas"; 

// Crear la conexión
$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

// Comprobar si la conexión ha fallado
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar el idioma para que se vean las tildes y la ñ
mysqli_set_charset($conexion, "utf8");

?>