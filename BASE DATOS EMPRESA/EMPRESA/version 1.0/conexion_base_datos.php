<!DOCTYPE html>
<html>
<head>
    <title>Conexión a base datos Mysql empresa</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once "autoloader.php";
use lib\BaseDatos;
$servidor = "mysql";
$usuario = "root";
$pass = "root";
$base_datos = "empresa";

$conexion = new BaseDatos($servidor, $usuario, $pass, $base_datos);
?>
<div class="container">
    <h2>Entidades de mi Empresa</h2>
    <hr>
    <div class="d-grid gap-3">
    <?php
        if ($conexion->consulta("select * from entidad")) {
            $hayDatos = false;
            while ($fila = $conexion->extraer_registro()) {
              $hayDatos = true;
              echo '<div class="card">';
                foreach ($fila as $campo => $valor) {
                    echo "<div> $campo: $valor </div>"; 
                }
                echo "</div>";
            }
            if (!$hayDatos){ echo "<div>No hay registros en la tabla consultada</div>";}
        } else {echo "<div> ERROR EN LA CONSULTA SQL</div>";}
        //ahora extraigo todos los registros de una sola vez
        if ($conexion->consulta("select * from entidad")) {
        $filas = $conexion->extraer_todos(); // $filas es un array de arrays: [ [fila1], [fila2], ... ]
            if ($filas) {
                foreach ($filas as $fila) {
                    echo '<div class="card">';
                    foreach ($fila as $campo => $valor) {
                        echo "<div>$campo: $valor</div>";
                    }
                }
            }
        }
    ?>
    </div>
</div>

</body>

</html>