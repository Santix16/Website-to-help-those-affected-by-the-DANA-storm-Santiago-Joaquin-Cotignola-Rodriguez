<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit();
}

require_once __DIR__ . '/../includes/db.php';
$id = (int) $_SESSION['usuario']['id'];
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = (string) ($_POST['password'] ?? '');

if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: perfil_privado.php?error=datos');
    exit();
}

try {
    if ($password !== '' && strlen($password) < 8) {
        throw new InvalidArgumentException('La nueva contraseña debe tener al menos 8 caracteres.');
    }

    $conexion->beginTransaction();
    if ($password !== '') {
        $stmt = $conexion->prepare('UPDATE usuarios SET nombre = :nombre, email = :email, password = :password WHERE id_usuario = :id');
        $stmt->execute([':nombre' => $nombre, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $id]);
    } else {
        $stmt = $conexion->prepare('UPDATE usuarios SET nombre = :nombre, email = :email WHERE id_usuario = :id');
        $stmt->execute([':nombre' => $nombre, ':email' => $email, ':id' => $id]);
    }
    $conexion->commit();
    $_SESSION['usuario']['nombre'] = $nombre;
    $_SESSION['usuario']['email'] = $email;
    header('Location: perfil_privado.php?actualizado=1');
    exit();
} catch (Throwable $exception) {
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }
    header('Location: perfil_privado.php?error=' . urlencode($exception->getMessage()));
    exit();
}

