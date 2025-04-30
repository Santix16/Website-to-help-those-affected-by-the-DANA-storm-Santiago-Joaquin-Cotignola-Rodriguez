<?php
$conn = new mysqli('localhost', 'root', '', 'tele_dana');

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = 'cliente';  // Por defecto cliente

$sql = "INSERT INTO usuarios (nombre, email, contraseña, rol) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $nombre, $email, $password, $rol);

if ($stmt->execute()) {
    header('Location: login.html?registro=1');
} else {
    echo "Error al registrar: " . $stmt->error;
}
?>
