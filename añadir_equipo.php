<?php
include 'db/conexion.php';
$id_liga = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_equipo = $_POST['nombre_equipo'];

    $sql_equipo = "INSERT INTO equipos (nombre, id_liga) VALUES ('$nombre_equipo', $id_liga)";
    
    if (mysqli_query($conexion, $sql_equipo)) {

        $id_nuevo_equipo = mysqli_insert_id($conexion);

        // Creamos su fila en la clasificación (todo a 0)
        $sql_clasif = "INSERT INTO clasificaciones (id_equipo, puntos, pj, pg, pe, pp) 
                       VALUES ($id_nuevo_equipo, 0, 0, 0, 0, 0)";
        mysqli_query($conexion, $sql_clasif);

        header("Location: gestionar_liga.php?id=$id_liga");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Equipo</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>🛡️ Añadir Equipo a la Liga</h1>
    
    <form method="POST" style="max-width: 400px; background: white; padding: 20px; border: 1px solid #ddd;">
        <label>Nombre del Equipo:</label><br>
        <input type="text" name="nombre_equipo" required placeholder="Ej: Real Betis" style="width: 100%; margin-bottom: 15px; padding: 8px;">

        <button type="submit" class="btn" style="background-color: #3498db;">Inscribir Equipo</button>
        <a href="gestionar_liga.php?id=<?php echo $id_liga; ?>" style="margin-left: 10px;">Cancelar</a>
    </form>
</body>
</html>