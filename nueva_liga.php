<?php

include 'db/conexion.php';

// para guardar los datos cuando se envíe el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos del formulario
    $nombre = $_POST['nombre'];
    $tipo   = $_POST['tipo_liga'];
    $fecha  = $_POST['fecha_inicio'];
    $reglas = $_POST['reglas'];

    $sql = "INSERT INTO ligas (nombre, tipo_liga, fecha_inicio, reglas) 
            VALUES ('$nombre', '$tipo', '$fecha', '$reglas')";

    if (mysqli_query($conexion, $sql)) {
        // Si sale bien, volvemos al índice para ver la nueva liga en la lista
        header("Location: index.php");
        exit();
    } else {
        echo "Error al crear la liga: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Liga</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<?php 
include 'db/conexion.php'; 
include 'includes/cabecera.php'; // Esto mete el <head>, el CSS y el menú
?>

    <h1>🆕 Crear Nueva Liga</h1>
    <p>Introduce los datos para configurar tu nueva competición.</p>

    <form method="POST" action="nueva_liga.php" style="max-width: 500px; background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        
        <label>Nombre de la Liga:</label><br>
        <input type="text" name="nombre" required style="width: 100%; margin-bottom: 15px; padding: 8px;">
        
        <label>Deporte :</label><br>
        <input type="text" name="tipo_liga" placeholder="Ej: Futbol, Padel..." style="width: 100%; margin-bottom: 15px; padding: 8px;">
        
        <label>Fecha de Inicio:</label><br>
        <input type="date" name="fecha_inicio" required style="width: 100%; margin-bottom: 15px; padding: 8px;">
        
        <label>Reglas o Descripción:</label><br>
        <textarea name="reglas" rows="4" style="width: 100%; margin-bottom: 15px; padding: 8px;"></textarea>
        
        <div style="margin-top: 10px;">
            <button type="submit" class="btn btn-nuevo">Guardar Liga</button>
            <a href="index.php" style="margin-left: 10px; color: #666; text-decoration: none;">Cancelar</a>
        </div>
        
    </form>

</body>
</html>