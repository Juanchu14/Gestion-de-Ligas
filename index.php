<?php

include 'db/conexion.php'; // Incluimos la conexión 

$sql = "SELECT * FROM ligas";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <title>Gestión de Ligas - Página Principal</title>
    
</head>
<body>

<?php 
include 'db/conexion.php'; 
include 'includes/cabecera.php'; 
?>

    <h1>🏆 Mis Ligas</h1>


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la Liga</th>
                <th>Deporte/Ámbito</th>
                <th>Fecha de Inicio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            if (mysqli_num_rows($resultado) > 0) { // si hay ligas, las mostramos
                
                while($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id_liga'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['tipo_liga'] . "</td>";
                    echo "<td>" . $fila['fecha_inicio'] . "</td>";
                    
                    echo "<td><a href='ver_liga.php?id=" . $fila['id_liga'] . "' class='btn btn-ver'>Ver</a></td>";  // Enviamos el ID por la URL para saber qué liga ver
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay ligas creadas todavía. ¡Crea tu primera liga!</td></tr>";
            }
            ?>
        </tbody>
    </table>


<?php 
include 'includes/pie.php'; // Esto mete los créditos y cierra el HTML
?>

</body>
</html>