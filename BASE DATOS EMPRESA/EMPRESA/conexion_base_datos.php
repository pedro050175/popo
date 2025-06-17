<!DOCTYPE html>
<html>
<head>
    <title>Conexión a base datos Mysql "empresa"</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once "autoloader.php";
use lib\basedatos;

$servidor = "mysql";
$usuario = "root";
$pass = "root";
$base_datos = "empresa";

$conexion = new basedatos($servidor, $usuario, $pass, $base_datos);
?>
<h1> "Conexion establecida"</h1>

</body>

</html>