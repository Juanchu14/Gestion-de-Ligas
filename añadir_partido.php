<?php
include 'db/conexion.php';
$id_liga = $_GET['id'];

$sql_equipos = "SELECT id_equipo, nombre FROM equipos WHERE id_liga = $id_liga";
$res_equipos = mysqli_query($conexion, $sql_equipos);
$equipos = [];
while($fila = mysqli_fetch_assoc($res_equipos)) {
    $equipos[] = $fila;
}

// guardar el partido al pulsar el botón
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $local     = $_POST['local'];
    $visitante = $_POST['visitante'];
    $goles_l   = $_POST['goles_l'];
    $goles_v   = $_POST['goles_v'];
    $resultado = $goles_l . "-" . $goles_v;

    $sql_insert = "INSERT INTO partidos (id_liga, id_equipo_local, id_equipo_visitante, resultado, estado) 
                   VALUES ($id_liga, $local, $visitante, '$resultado', 'jugado')";
    
    if (mysqli_query($conexion, $sql_insert)) {
        
        // --- CÁLCULO DE PUNTOS ---
        $puntos_l = 0; $puntos_v = 0;
        $pg_l = 0; $pe_l = 0; $pp_l = 0;
        $pg_v = 0; $pe_v = 0; $pp_v = 0;

        if ($goles_l > $goles_v) { 
            $puntos_l = 3; $pg_l = 1; $pp_v = 1; 
        } elseif ($goles_l < $goles_v) { 
            $puntos_v = 3; $pg_v = 1; $pp_l = 1; 
        } else { 
            $puntos_l = 1; $pe_l = 1; $puntos_v = 1; $pe_v = 1; 
        }

        // --- ACTUALIZACIÓN CON REPORTE DE ERRORES ---
        
        $up_local = "UPDATE clasificaciones SET 
            puntos = puntos + $puntos_l, pj = pj + 1, pg = pg + $pg_l, pe = pe + $pe_l, pp = pp + $pp_l 
            WHERE id_equipo = $local";
        
        if(!mysqli_query($conexion, $up_local)) {
            die("Error actualizando local: " . mysqli_error($conexion));
        }

        $up_visit = "UPDATE clasificaciones SET 
            puntos = puntos + $puntos_v, pj = pj + 1, pg = pg + $pg_v, pe = pe + $pe_v, pp = pp + $pp_v 
            WHERE id_equipo = $visitante";

        if(!mysqli_query($conexion, $up_visit)) {
            die("Error actualizando visitante: " . mysqli_error($conexion));
        }

        // Si el número de filas afectadas es 0, es que el equipo no estaba en la tabla clasificaciones
        if (mysqli_affected_rows($conexion) == 0) {
            echo "Aviso: El partido se guardó, pero los equipos no tienen fila en la tabla clasificaciones.";
            echo "<br><a href='index.php'>Volver</a>";
            exit();
        }

        header("Location: ver_liga.php?id=$id_liga");
        exit();
    } else {
        echo "Error al guardar el partido: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Partido</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<?php 
include 'db/conexion.php'; 
include 'includes/cabecera.php'; // Esto mete el <head>, el CSS y el menú
?>

    <h1>⚽ Registrar Nuevo Partido</h1>
    
    <form method="POST" style="max-width: 500px; background: white; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="width: 45%;">
                <label><strong>Equipo Local:</strong></label><br>
                <select name="local" required style="width: 100%; padding: 8px; margin-top: 5px;">
                    <?php foreach($equipos as $e) { 
                        echo "<option value='".$e['id_equipo']."'>".$e['nombre']."</option>"; 
                    } ?>
                </select><br><br>
                <label>Goles Local:</label><br>
                <input type="number" name="goles_l" value="0" min="0" style="width: 50px; padding: 5px;">
            </div>

            <div style="align-self: center; font-weight: bold; font-size: 1.5em;">VS</div>

            <div style="width: 45%;">
                <label><strong>Equipo Visitante:</strong></label><br>
                <select name="visitante" required style="width: 100%; padding: 8px; margin-top: 5px;">
                    <?php foreach($equipos as $e) { 
                        echo "<option value='".$e['id_equipo']."'>".$e['nombre']."</option>"; 
                    } ?>
                </select><br><br>
                <label>Goles Visitante:</label><br>
                <input type="number" name="goles_v" value="0" min="0" style="width: 50px; padding: 5px;">
            </div>
        </div>

        <button type="submit" class="btn" style="background-color: #f39c12; width: 100%;">Guardar Resultado</button>
        <p style="text-align: center;"><a href="ver_liga.php?id=<?php echo $id_liga; ?>" style="color: #666;">Cancelar</a></p>
    </form>
</body>
</html>