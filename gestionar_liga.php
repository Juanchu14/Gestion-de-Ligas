<?php
include 'db/conexion.php';
$id_liga = $_GET['id'];

// 1. Cargar datos actuales
$res = mysqli_query($conexion, "SELECT * FROM ligas WHERE id_liga = $id_liga");
$liga = mysqli_fetch_assoc($res);

// 2. Lógica de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nombre'];
    $reg = $_POST['reglas'];
    
    $sql_update = "UPDATE ligas SET nombre = '$nom', reglas = '$reg' WHERE id_liga = $id_liga";
    if (mysqli_query($conexion, $sql_update)) {
        header("Location: ver_liga.php?id=$id_liga");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Liga</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<?php 
include 'db/conexion.php'; 
include 'includes/cabecera.php'; // Esto mete el <head>, el CSS y el menú
?>

    <h1>⚙️ Configuración de la Liga</h1>
    <form method="POST" style="max-width: 500px; background: white; padding: 20px; border: 1px solid #ddd;">
        <label>Nombre de la liga:</label><br>
        <input type="text" name="nombre" value="<?php echo $liga['nombre']; ?>" style="width: 100%; margin-bottom: 15px;">
        
        <label>Reglas / Descripción:</label><br>
        <textarea name="reglas" rows="5" style="width: 100%; margin-bottom: 15px;"><?php echo $liga['reglas']; ?></textarea>

        <h3>Equipos Participantes</h3>
        <input type="button" value="+ Añadir Nuevo Equipo" onclick="location.href='añadir_equipo.php?id=<?php echo $id_liga; ?>'">

        <button type="submit" class="btn" style="background-color: #7f8c8d;">Actualizar Datos</button>
        <a href="ver_liga.php?id=<?php echo $id_liga; ?>">Volver sin cambios</a>
    </form>
    <div style="margin-top: 20px;">
    <h4>Equipos inscritos actualmente:</h4>
    <ul style="background: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px solid #eee;">
        <?php
        // Consultamos los equipos de esta liga
        $sql_lista = "SELECT nombre FROM equipos WHERE id_liga = $id_liga";
        $res_lista = mysqli_query($conexion, $sql_lista);
        
        if (mysqli_num_rows($res_lista) > 0) {
            while($equipo = mysqli_fetch_assoc($res_lista)) {
                echo "<li>🛡️ " . $equipo['nombre'] . "</li>";
            }
        } else {
            echo "<li>Aún no hay equipos en esta liga.</li>";
        }
        ?>
    </ul>
</div>
</body>
</html>