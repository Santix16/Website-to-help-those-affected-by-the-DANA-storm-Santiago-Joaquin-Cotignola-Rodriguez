<?php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$usuario = getenv('DB_USER') ?: 'root';
$contrasena = getenv('DB_PASSWORD') ?: '';
$base_de_datos = getenv('DB_NAME') ?: 'tele_dana';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
