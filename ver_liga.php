<?php
include 'db/conexion.php';

// Recogemos el ID de la liga que viene por la URL
if (isset($_GET['id'])) {
    $id_liga = $_GET['id'];

    $sql_liga = "SELECT nombre FROM ligas WHERE id_liga = $id_liga";
    $res_liga = mysqli_query($conexion, $sql_liga);
    $datos_liga = mysqli_fetch_assoc($res_liga);

    // unimos Equipos y Clasificaciones para ver la clasificación
    // La ordenamos por puntos de mayor a menor
    $sql_clasificacion = "SELECT e.nombre, c.puntos, c.pj, c.pg, c.pe, c.pp 
                          FROM equipos e
                          JOIN clasificaciones c ON e.id_equipo = c.id_equipo
                          WHERE e.id_liga = $id_liga
                          ORDER BY c.puntos DESC";
    $resultado = mysqli_query($conexion, $sql_clasificacion);
} else {
    // Si no hay ID, volvemos al índice
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clasificación - <?php echo $datos_liga['nombre']; ?></title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<?php 
include 'db/conexion.php'; 
include 'includes/cabecera.php'; // Esto mete el <head>, el CSS y el menú
?>

    
    <h1>📊 Clasificación: <?php echo $datos_liga['nombre']; ?></h1>

    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Equipo</th>
                <th>Puntos</th>
                <th>PJ</th>
                <th>PG</th>
                <th>PE</th>
                <th>PP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $posicion = 1;
            if (mysqli_num_rows($resultado) > 0) {
                while($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td><strong>" . $posicion++ . "º</strong></td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['puntos'] . "</td>";
                    echo "<td>" . $fila['pj'] . "</td>";
                    echo "<td>" . $fila['pg'] . "</td>";
                    echo "<td>" . $fila['pe'] . "</td>";
                    echo "<td>" . $fila['pp'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aún no hay equipos o datos en esta liga.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    
    <input type="button" value="Añadir Resultados" onclick="location.href='añadir_partido.php?id=<?php echo $id_liga; ?>'">
    <input type="button" value="Gestionar Liga" onclick="location.href='gestionar_liga.php?id=<?php echo $id_liga; ?>'">
    

</body>
</html>