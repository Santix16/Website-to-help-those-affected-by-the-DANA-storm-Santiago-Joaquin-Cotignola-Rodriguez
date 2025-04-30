<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tele_dana');

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    if (password_verify($password, $usuario['contraseña'])) {
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];
        header('Location: index.html');
        exit();
    } else {
        header('Location: login.html?error=1');
        exit();
    }
} else {
    header('Location: login.html?error=1');
    exit();
}
?>
