<?php
$host = "localhost";
$db_name = "hotel";
$username = "root";
$password = "";

try {
    $conex = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password); //conexion a la base de datos
    $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>